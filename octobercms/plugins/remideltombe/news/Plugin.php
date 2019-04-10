<?php namespace RemiDeltombe\News;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['RemiDeltombe.Esport'];

    public function registerComponents()
    {
        return [
            'RemiDeltombe\News\Components\Listing' => 'newsListing',
            'RemiDeltombe\News\Components\Detail' => 'newsDetail'
        ];
    }
}
