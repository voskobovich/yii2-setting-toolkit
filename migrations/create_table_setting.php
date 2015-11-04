<?php

namespace voskobovich\admin\setting\migrations;

use yii\db\Migration;

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
            'section' => $this->string(50)->notNull(),
            'key' => $this->string(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'hint' => $this->string(50),
            'value' => $this->text(),
            'type' => $this->smallInteger(),
            'position' => $this->smallInteger(),
            'variants' => $this->text(),
            'rules' => $this->text()
        ], $tableOptions);

        $this->addPrimaryKey('setting_section_key_pk', $this->_tableName, ['section', 'key']);
    }

    public function safeDown()
    {
        $this->dropTable($this->_tableName);
    }
}
