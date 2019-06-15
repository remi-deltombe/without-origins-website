<?php namespace RemiDeltombe\Events;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = [
        'RemiDeltombe.Esport',
        'RemiDeltombe.Twig'
    ];

    public function registerComponents()
    {
        return [
            'RemiDeltombe\Events\Components\Calendar' => 'eventsCalendar',
            'RemiDeltombe\Events\Components\Event' => 'eventsEvent',
            'RemiDeltombe\Events\Components\Events' => 'eventsEvents',
            'RemiDeltombe\Events\Components\Widget' => 'eventsWidget'
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Events',
                'description' => 'Events settings.',
                'icon'        => 'icon-calendar',
                'class'       => 'RemiDeltombe\Events\Models\Settings',
                'order'       => 500,
                'category'    => 'Content',
                'permissions' => ['cms.manage_pages']
            ]
        ];
    }
}
