<?php namespace RemiDeltombe\News;

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
            'RemiDeltombe\News\Components\Item' => 'newsItem',
            'RemiDeltombe\News\Components\Items' => 'newsItems'
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'News',
                'description' => 'News settings.',
                'icon'        => 'icon-newspaper-o',
                'class'       => 'RemiDeltombe\News\Models\Settings',
                'order'       => 500,
                'category'    => 'Content',
                'permissions' => ['cms.manage_pages']
            ]
        ];
    }
}
