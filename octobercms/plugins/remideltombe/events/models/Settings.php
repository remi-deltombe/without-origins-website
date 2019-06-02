<?php namespace RemiDeltombe\Events\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'remideltombe_events_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
