<?php namespace RemiDeltombe\Sitemap;

use System\Classes\PluginBase;
use RemiDeltombe\Sitemap\Models\Game;
use RemiDeltombe\Sitemap\Models\Settings;
use RemiDeltombe\Menu\Models\Menu;

use App;
use Request;
use Route;

class Plugin extends PluginBase
{
    public $require = [
        'RemiDeltombe.News',
        'RemiDeltombe.Page',
    ];

    public function registerComponents()
    {
        return [
            'RemiDeltombe\Sitemap\Components\Sitemap' => 'sitemap'
        ];
    }
}
