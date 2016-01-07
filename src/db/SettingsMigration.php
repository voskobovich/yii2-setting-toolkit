<?php

namespace voskobovich\admin\setting\db;

use voskobovich\admin\setting\models\Setting;
use yii\db\Expression;
use yii\db\Migration;

defined('DB_QUOTE') or define('DB_QUOTE', '`');

/**
 * Class SettingsMigration
 * @package app\db
 */
class SettingsMigration extends Migration
{
    /**
     * Константы колонок
     */
    const FIELD_SECTION = 'section';
    const FIELD_KEY = 'key';
    const FIELD_NAME = 'name';
    const FIELD_HINT = 'hint';
    const FIELD_VALUE = 'value';
    const FIELD_TYPE = 'type';
    const FIELD_POSITION = 'position';
    const FIELD_VARIANTS = 'variants';
    const FIELD_RULES = 'rules';

    /**
     * @var null
     */
    protected $_rows = null;

    /**
     * Применение миграции
     * @return bool
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        foreach ($this->_rows as $row) {
            $model = new Setting();

            $model->setAttributes([
                'section' => $row['section'],
                'key' => $row['key'],
            ]);

            $model->name = !empty($row['name']) ? $row['name'] : $row['key'];
            $model->hint = !empty($row['hint']) ? $row['hint'] : null;
            $model->value = !empty($row['value']) ? (string)$row['value'] : '';
            $model->position = !empty($row['position']) ? $row['position'] : null;
            $model->type = !empty($row['type']) ? $row['type'] : $model::TYPE_TEXT;
            $model->variants = !empty($row['variants']) ? $row['variants'] : [];
            $model->rules = !empty($row['rules']) ? $row['rules'] : [];

            if ($model->validate()) {
                $tableName = $model::tableName();
                $command = $this->db
                    ->createCommand("SELECT * FROM {$tableName} WHERE section = :section AND position = :position")
                    ->bindValue(':section', $model->section)
                    ->bindValue(':position', $model->position);

                if ($command->query()->rowCount) {
                    $command = $this->db->createCommand()
                        ->update(
                            $tableName,
                            ['position' => new Expression('position+1')],
                            'position >= :position AND section = :section',
                            ['position' => $model->position, 'section' => $model->section]
                        );

                    if (!$command->execute()) {
                        echo "Saving error\n";
                        return false;
                    }
                }

                if (!$model->save()) {
                    $error = ['Save Error!!'];
                    $error['attributes'] = $model->getAttributes();
                    $error['errors'] = $model->errors;

                    print_r($error);
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Отмена миграции
     * @return bool
     */
    public function safeDown()
    {
        foreach ($this->_rows as $row) {
            $command = $this->db
                ->createCommand()
                ->delete(
                    Setting::tableName(),
                    DB_QUOTE . 'section' . DB_QUOTE . ' = :section AND ' . DB_QUOTE . 'key' . DB_QUOTE . ' = :key',
                    [':section' => $row['section'], ':key' => $row['key']]
                );

            if (!$command->execute()) {
                echo "Error, position not updated!\n";
                return false;
            }
        }

        return true;
    }
}