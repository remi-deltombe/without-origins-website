<?php namespace RemiDeltombe\News\Components;

use RemiDeltombe\News\Models\Item;

class Detail extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [
            'id' => [
                 'title'             => 'Id of the news',
                 'description'       => 'The id of the news to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'Id must be a number'
            ],
            'url' => [
                 'title'             => 'Url of the news',
                 'description'       => 'The url of the news to display',
                 'default'           => '',
                 'type'              => 'string',
                 'validationPattern' => '^/[^\/]{1,}',
                 'validationMessage' => 'Url must be valid'
            ]
        ];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'News detail',
            'description' => 'Displays the detail of a news.'
        ];
    }

    public function item()
    {
        if(strlen($this->property('url')))
        {
            return Item::where('url', '/'.$this->property('url'))->first();
        }
        return Item::find($this->property('id'));
    }
}