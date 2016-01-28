<?php

namespace voskobovich\setting\migrations;

use voskobovich\setting\db\SettingsMigration;
use voskobovich\setting\models\Setting;

/**
 * Class setting_section__code
 * @package voskobovich\setting\migrations
 */
class setting_section__code extends SettingsMigration
{
    /**
     * @var array
     */
    protected $_rows = [
        [
            self::FIELD_SECTION => 'code',
            self::FIELD_KEY => 'head',
            self::FIELD_NAME => 'Code in Head',
            self::FIELD_VALUE => '',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
        [
            self::FIELD_SECTION => 'code',
            self::FIELD_KEY => 'body_start',
            self::FIELD_NAME => 'Code in start Body',
            self::FIELD_VALUE => '',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
        [
            self::FIELD_SECTION => 'code',
            self::FIELD_KEY => 'body_end',
            self::FIELD_NAME => 'Code in end Body',
            self::FIELD_VALUE => '',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
    ];
}
