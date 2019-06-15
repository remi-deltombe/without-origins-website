<?php namespace RemiDeltombe\Analytics\Components;

use RemiDeltombe\Analytics\Models\Settings as Settings;

class GA extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'Google analytis tracking tags',
            'description' => ''
        ];
    }

    public function trackId()
    {   
        return Settings::get('track_id');
    }
}