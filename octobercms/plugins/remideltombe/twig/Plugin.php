<?php namespace RemiDeltombe\Twig;

use System\Classes\PluginBase;
use Input;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'input' => function($name, $default="") { return Input::get($name, $default); }
            ]
        ];
    }
}
