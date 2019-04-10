<?php namespace RemiDeltombe\SocialNetworks\Components;

use RemiDeltombe\SocialNetworks\Models\Settings;

class Tv extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Twitch embedded tv',
            'description' => 'Displays an embedded twitch stream player.'
        ];
    }

    public function onRun()
    {
        $settings = Settings::instance();

        $channel = $settings->twitch_link;
        if(strlen($channel))
        {
            $channel = explode('?', $channel)[0];
            $channel = explode('/', $channel);
            $channel = count($channel > 1) ? $channel[1] : '';
        }
        
        $this->page['twitch_channel']  = $channel;
        $this->page['twitch_link']  = $settings->twitch_link;
    }
}