<?php namespace RemiDeltombe\Page;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = ['RemiDeltombe.Esport'];

    public function registerComponents()
    {
        return [
            'RemiDeltombe\Page\Components\Detail' => 'pageDetail'
        ];
    }
}

