<?php

namespace voskobovich\setting\migrations;

use voskobovich\setting\db\SettingsMigration;
use voskobovich\setting\models\Setting;

/**
 * Class add_setting_google_analytics
 * @package voskobovich\setting\migrations
 */
class add_setting_google_analytics extends SettingsMigration
{
    protected $_rows = [
        [
            self::FIELD_SECTION => 'ganalytics',
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
