<?php

namespace voskobovich\admin\setting\models;

use voskobovich\base\db\ActiveRecord;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


/**
 * This is the model class for table "{{%setting}}".
 *
 * @property string $section
 * @property string $key
 * @property string $name
 * @property string $hint
 * @property string $value
 * @property integer $type
 * @property string $variants
 * @property string $rules
 * @property string $position
 */
class Setting extends ActiveRecord
{
    /**
     * Константы типов полей
     */
    const TYPE_TEXT = 0;
    const TYPE_TEXT_AREA = 1;
    const TYPE_SELECT_BOX = 2;
    const TYPE_SELECT_BOX_MULTIPLE = 3;
    const TYPE_CHECK_BOX = 4;
    const TYPE_CHECK_BOX_LIST = 5;
    const TYPE_RADIO = 6;
    const TYPE_RADIO_LIST = 7;
    const TYPE_EDITOR = 8;

    /**
     * Ключ по которому хранится кеш настроек
     * @var string
     */
    private static $cacheKey = 'setting';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['value'], 'string'],
        ];

        if ($this->isNewRecord) {
            $rules = ArrayHelper::merge($rules, [
                [['section', 'key'], 'required'],
                [['section', 'key'], 'string', 'max' => 50],
                ['name', 'required'],
                ['name', 'string', 'max' => 100],
                ['hint', 'string', 'max' => 255],
                [['type', 'position'], 'integer'],
                [['variants', 'rules'], 'validatorIsArray'],
            ]);
        }

        return $rules;
    }

    /**
     * Проверяет чтобы в значении аттрибута был массив
     * @param $attribute
     */
    public function validatorIsArray($attribute)
    {
        if (!is_array($this->{$attribute})) {
            $this->addError($attribute, Yii::t('setting', 'Must be array'));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'section' => Yii::t('setting', 'Section'),
            'key' => Yii::t('setting', 'Key'),
            'name' => Yii::t('setting', 'Name'),
            'hint' => Yii::t('setting', 'Hint'),
            'value' => Yii::t('setting', 'Value'),
            'type' => Yii::t('setting', 'Input type'),
            'variants' => Yii::t('setting', 'Variants'),
            'rules' => Yii::t('setting', 'Rules'),
            'position' => Yii::t('setting', 'Position'),
        ];
    }

    /**
     * Перед сохранением
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->_autoIncrementPosition();

        if (is_array($this->variants)) {
            $this->variants = Json::encode($this->variants);
        }
        if (is_array($this->rules)) {
            $this->rules = Json::encode($this->rules);
        }

        return parent::beforeSave($insert);
    }

    /**
     * Заполняем позицию автоматически
     * если она не указана в миграции
     */
    private function _autoIncrementPosition()
    {
        if (empty($this->position)) {
            $maxPositionInSection = self::find()
                ->where(['section' => $this->section])
                ->max("position");
            $this->position = !empty($maxPositionInSection) ? $maxPositionInSection + 1 : 1;
        }
    }

    /**
     * Получение вариантов для списка в виде массива
     * @return mixed
     */
    public function getVariants()
    {
        return Json::decode($this->variants, true);
    }

    /**
     * Получение настройки
     * или секции настроек
     * @param $key
     * @param null|mixed $defaultValue
     * @return mixed|null
     * @throws Exception
     */
    public static function get($key, $defaultValue = null)
    {
        if (strpos($key, '.') !== false) {
            $pieces = explode('.', $key, 2);
            $section = $pieces[0];
            $key = $pieces[1];
        } else {
            $section = $key;
            $key = null;
        }

        // Если указан ключ, тогда пытаемся его получить из кеша
        // в противном случае будем получать всю секцию
        $value = !is_null($key) && !empty(Yii::$app->cache) ?
            Yii::$app->cache->get(self::$cacheKey . '_' . $section . '_' . $key) : false;

        if ($value === false) {
            $query = static::find()->where(['section' => $section]);

            if (!is_null($key)) {
                $query->andWhere(['key' => $key]);

                /** @var Setting $model */
                $model = $query->one();

                if (empty($model)) {
                    throw new Exception("Key {$section}.{$key} not found!");
                }

                $value = $model->value;

                if (!empty(Yii::$app->cache)) {
                    Yii::$app->cache->set(self::$cacheKey . '_' . $section . '_' . $key, $value);
                }
            } else {
                $value = $query->all();
            }
        }

        return !empty($value) ? $value : $defaultValue;
    }

    /**
     * Сохранение настройки
     * @param $key
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function set($key, $value)
    {
        if (strpos($key, '.') !== false) {
            $pieces = explode('.', $key, 2);
            $section = $pieces[0];
            $key = $pieces[1];
        } else {
            throw new Exception("Key must be in section.key format!");
        }

        /** @var Setting $model */
        $model = self::find()
            ->where(['key' => $key, 'section' => $section])
            ->one();

        if (empty($model)) {
            throw new Exception("Key {$section}.{$key} not found!");
        }

        if (!empty($model)) {
            $model->value = $value;

            if ($model->save()) {
                if (!empty(Yii::$app->cache)) {
                    Yii::$app->cache->delete(self::$cacheKey . '_' . $section . '_' . $key);
                }

                return true;
            }
        }

        return false;
    }
}