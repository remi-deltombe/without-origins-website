<?php namespace RemiDeltombe\Menu;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'RemiDeltombe\Menu\Components\Tree' => 'menuTree'
        ];
    }
}
