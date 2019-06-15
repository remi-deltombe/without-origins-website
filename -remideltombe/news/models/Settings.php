<?php namespace RemiDeltombe\News\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'remideltombe_news_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
