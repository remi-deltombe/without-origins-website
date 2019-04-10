<?php namespace RemiDeltombe\Page;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'RemiDeltombe\Page\Components\Detail' => 'pageDetail'
        ];
    }
}

