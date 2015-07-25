<?php

namespace voskobovich\admin\setting\migrations;

use voskobovich\admin\setting\db\SettingsMigration;
use voskobovich\admin\setting\models\Setting;

/**
 * Class add_setting_google_analytics
 * @package voskobovich\admin\setting\migrations
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
