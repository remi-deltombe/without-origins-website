<?php namespace RemiDeltombe\Minify;

use System\Classes\PluginBase;
use Input;
use Event;

class Plugin extends PluginBase
{
    public function boot()
    {
        if(Models\Settings::instance()->is_active)
        {
            Event::listen('cms.page.display', function ($controller, $url, $page, $result) {
                return $this->minify($result);
            });
        }
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Minify Settings',
                'description' => 'Manage minify based settings.',
                'icon'        => 'icon-wrench',
                'class'       => 'RemiDeltombe\Minify\Models\Settings',
                'order'       => 500,
                'keywords'    => 'security location',
                'permissions' => ['remideltombe.minify.manage']
            ]
        ];
    }

    private function minify($html)
    {
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        return preg_replace($search, $replace, $html);
    }
}
