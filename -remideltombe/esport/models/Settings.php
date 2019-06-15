<?php namespace RemiDeltombe\Esport\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'remideltombe_esport_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
