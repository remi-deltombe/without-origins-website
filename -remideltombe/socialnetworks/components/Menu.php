<?php namespace RemiDeltombe\SocialNetworks\Components;

class Menu extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Social network menu',
            'description' => 'Displays a list of link to the social networks.'
        ];
    }
}