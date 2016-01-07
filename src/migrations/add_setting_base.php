<?php

namespace voskobovich\admin\setting\migrations;

use voskobovich\admin\setting\db\SettingsMigration;
use voskobovich\admin\setting\models\Setting;

/**
 * Class add_setting_base
 * @package voskobovich\admin\setting\migrations
 */
class add_setting_base extends SettingsMigration
{
    /**
     * Массив новых настроек для внесения в базу
     * @var array
     */
    protected $_rows = [
        [
            self::FIELD_SECTION => 'general',
            self::FIELD_KEY => 'meta_title',
            self::FIELD_NAME => 'Meta title',
            self::FIELD_HINT => 'Meta title for main page',
            self::FIELD_VALUE => 'Yii2 App Basic',
            self::FIELD_RULES => [
                ['string', 'max' => 255],
            ]
        ],
        [
            self::FIELD_SECTION => 'general',
            self::FIELD_KEY => 'meta_description',
            self::FIELD_NAME => 'Meta description',
            self::FIELD_HINT => 'Meta description for main page',
            self::FIELD_VALUE => 'Meta description',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
        [
            self::FIELD_SECTION => 'general',
            self::FIELD_KEY => 'meta_keywords',
            self::FIELD_NAME => 'Meta keywords',
            self::FIELD_HINT => 'Meta keywords for main page',
            self::FIELD_VALUE => 'cms, basic, yii2',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
    ];
}
