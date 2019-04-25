<?php namespace RemiDeltombe\SocialNetworks;

use System\Classes\PluginBase;
use RemiDeltombe\SocialNetworks\Models\Settings;

class Plugin extends PluginBase
{
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Social networks',
                'description' => 'Social network settings.',
                'icon'        => 'oc-icon-exchange',
                'class'       => 'RemiDeltombe\SocialNetworks\Models\Settings',
                'order'       => 500,
                'category'    => 'Content',
                'permissions' => ['remideltombe.socialnetworks.manage']
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'RemiDeltombe\SocialNetworks\Components\Menu' => 'socialNetworksMenu',
            'RemiDeltombe\SocialNetworks\Components\Tweets' => 'socialNetworksTweets',
            'RemiDeltombe\SocialNetworks\Components\Tv' => 'socialNetworksTv'
        ];
    }
}


