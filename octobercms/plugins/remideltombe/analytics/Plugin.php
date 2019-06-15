<?php namespace RemiDeltombe\Analytics;

use System\Classes\PluginBase;
use Input;
use Event;

class Plugin extends PluginBase
{
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Analytics Settings',
                'description' => 'Manage analytics based settings.',
                'icon'        => 'icon-wrench',
                'class'       => 'RemiDeltombe\Analytics\Models\Settings',
                'order'       => 500,
                'keywords'    => 'security location',
                'permissions' => ['remideltombe.analytics.manage']
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'RemiDeltombe\Analytics\Components\GA' => 'analyticsGA'
        ];
    }


}
