<?php namespace RemiDeltombe\News\Components;

use RemiDeltombe\News\Models\Item as NewsItem;

class Item extends \Cms\Classes\ComponentBase
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
            'slug' => [
                 'title'             => 'Slug of the news',
                 'description'       => 'The slug of the news to display',
                 'default'           => '',
                 'type'              => 'string',
                 'validationPattern' => '^[^\/]{1,}',
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
        if(strlen($this->property('slug')))
        {
            $item = NewsItem::where('slug', $this->property('slug'))->first();
        }
        else
        {
            $item = NewsItem::find($this->property('id'));
        }
        if($item)
        {
            return $item;
        }
        header('Location: /404');
        die;
    }
}