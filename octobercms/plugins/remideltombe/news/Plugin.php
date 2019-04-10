<?php namespace RemiDeltombe\News;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'RemiDeltombe\News\Components\Listing' => 'newsListing',
            'RemiDeltombe\News\Components\Detail' => 'newsDetail'
        ];
    }
}
