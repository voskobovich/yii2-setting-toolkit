<?php

namespace voskobovich\admin\setting\migrations;

use yii\db\Schema;
use yii\db\Migration;

defined('DB_QUOTE') or define('DB_QUOTE', '`');

/**
 * Class create_table_setting
 * @package voskobovich\admin\setting\migrations
 */
class create_table_setting extends Migration
{
    private $_tableName = '{{%setting}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->_tableName, [
            'section' => Schema::TYPE_STRING . '(50) NOT NULL',
            'key' => Schema::TYPE_STRING . '(50) NOT NULL',
            'name' => Schema::TYPE_STRING . '(100) NOT NULL',
            'hint' => Schema::TYPE_STRING,
            'value' => Schema::TYPE_TEXT,
            'type' => Schema::TYPE_SMALLINT,
            'position' => Schema::TYPE_SMALLINT,
            'variants' => Schema::TYPE_TEXT,
            'rules' => Schema::TYPE_TEXT,
            'PRIMARY KEY (' . DB_QUOTE . 'section' . DB_QUOTE . ', ' . DB_QUOTE . 'key' . DB_QUOTE . ')'
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable($this->_tableName);
    }
}
