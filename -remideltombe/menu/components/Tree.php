<?php namespace RemiDeltombe\Menu\Components;

use RemiDeltombe\Menu\Models\Menu;

class Tree extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [
            'id' => [
                 'title'             => 'Id of the menu',
                 'description'       => 'The id of the menu to display',
                 'default'           => 0,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'Id must be a number'
            ]
        ];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'Menu tree',
            'description' => 'Displays a menu as a dom tree.'
        ];
    }

    public function item()
    {
        return Menu::find($this->property('id'));
    }
}