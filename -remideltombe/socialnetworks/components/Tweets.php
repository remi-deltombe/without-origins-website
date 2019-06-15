<?php namespace RemiDeltombe\SocialNetworks\Components;

use RemiDeltombe\SocialNetworks\Models\Settings;

class Tweets extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Social network tweets timeline',
            'description' => 'Displays the last published tweets.'
        ];
    }

    public function onRun()
    {
        $settings = Settings::instance();
        $this->page['facebook_link'] = $settings->facebook_link;
        $this->page['facebook_api']  = $settings->facebook_api;
        $this->page['twitter_link']  = $settings->twitter_link;
        $this->page['twitter_api']   = $settings->twitter_api;
        $this->page['youtube_link']  = $settings->youtube_link;
        $this->page['youtube_api']   = $settings->youtube_api;
        $this->page['discord_link']  = $settings->discord_link;
        $this->page['discord_api']   = $settings->discord_api;
        $this->page['twitch_link']  = $settings->twitch_link;
        $this->page['twitch_api']   = $settings->twitch_api;
    }
}