<?php namespace RemiDeltombe\Esport;

use System\Classes\PluginBase;

use Event;

class Plugin extends PluginBase
{
    public $require = ['RemiDeltombe.Menu'];

    public function boot()
    {
        Event::listen('cms.router.beforeRoute', function ($url, $router) {
            $reflection = new \ReflectionClass($router);
            $property = $reflection->getProperty('url');
            $property->setAccessible(true);
            $property->setValue($router, '/news/test');
        });
    }
}
