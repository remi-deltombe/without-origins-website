<?php namespace RemiDeltombe\SocialNetworks\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'remideltombe_socialnetworks_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
