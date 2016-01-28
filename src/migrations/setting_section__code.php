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
            self::FIELD_SECTION => 'ga',
            self::FIELD_KEY => 'code',
            self::FIELD_NAME => 'Google analytics code',
            self::FIELD_VALUE => '',
            self::FIELD_TYPE => Setting::TYPE_TEXT_AREA,
            self::FIELD_RULES => [
                ['string'],
            ]
        ],
    ];
}
