<?php

namespace voskobovich\setting\forms;

use voskobovich\setting\models\Setting;
use Yii;
use yii\base\Model;
use yii\helpers\Json;


/**
 * Class IndexForm
 * @package app\forms
 */
class IndexForm extends Model
{
    /**
     * Коллекция стрибутов модели
     * @var array
     */
    private $_settingModels = [];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $items = [];
        foreach ($this->_settingModels as $key => $setting) {
            $items[$key] = $setting->name;
        }

        return $items;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $items = [];
        foreach ($this->_settingModels as $key => $setting) {
            if (!empty($setting->rules)) {
                $rules = Json::decode($setting->rules, true);
                foreach ($rules as $rule) {
                    $items[] = array_merge([$key], $rule);
                }
            } else {
                $items[] = [$key, 'safe'];
            }
        }

        return $items;
    }

    /**
     * Геттер атрибутов модели
     * @param null $names
     * @param array $except
     * @return array
     */
    public function getAttributes($names = null, $except = [])
    {
        $items = [];
        foreach ($this->_settingModels as $key => $model) {
            $items[$key] = $model->value;
        }

        return $items;
    }

    /**
     * Получение массива моделей настроек
     * @return array
     */
    public function getSettings()
    {
        return $this->_settingModels;
    }

    /**
     * Сохранение настроек
     * @return array|bool
     */
    public function save()
    {
        /**
         * @var string $key
         * @var Setting $setting
         */
        foreach ($this->_settingModels as $key => $setting) {
            if (!$setting->validate()) {
                $this->addErrors([$key => $setting->errors]);
            }
        }

        if (!$this->hasErrors()) {
            foreach ($this->_settingModels as $key => $setting) {
                Setting::set("{$setting->section}.{$key}", $setting->value);
            }

            return true;
        }

        return false;
    }

    /**
     * Загрузка настроек по секции
     * @param string $section
     * @return IndexForm
     */
    public function loadBySection($section = 'general')
    {
        $models = Setting::find()
            ->where(['section' => $section])
            ->indexBy('key')
            ->orderBy('position ASC')
            ->all();

        if (!empty($models)) {
            $this->_settingModels = $models;
            return true;
        }

        return false;
    }

    /**
     * Сеттер значений настроек
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if (!empty($this->_settingModels[$key])) {
            $this->_settingModels[$key]->value = $value;
        }
    }

    /**
     * Геттер значений настроек
     * @param string $key
     * @return mixed|null
     */
    public function __get($key)
    {
        if (!empty($this->_settingModels[$key])) {
            return $this->_settingModels[$key]->value;
        }

        return null;
    }
} 