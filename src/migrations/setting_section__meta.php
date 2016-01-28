<?php

namespace voskobovich\setting\migrations;

use voskobovich\setting\db\SettingsMigration;
use voskobovich\setting\models\Setting;

/**
 * Class setting_section__meta
 * @package voskobovich\setting\migrations
 */
class setting_section__meta extends SettingsMigration
{
    /**
     * @var array
     */
    protected $_rows = [
        [
            self::FIELD_SECTION => 'meta',
            self::FIELD_KEY => 'title',
            self::FIELD_NAME => 'Meta title',
            self::FIELD_VALUE => '',
            self::FIELD_RULES => [
                ['string', 'max' => 255],
            ]
        ],
        [
            self::FIELD_SECTION => 'meta',
            self::FIELD_KEY => 'description',
            self::FIELD_NAME => 'Meta description',
            self::FIELD_VALUE => '',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
        [
            self::FIELD_SECTION => 'meta',
            self::FIELD_KEY => 'keywords',
            self::FIELD_NAME => 'Meta keywords',
            self::FIELD_VALUE => '',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
    ];
}
