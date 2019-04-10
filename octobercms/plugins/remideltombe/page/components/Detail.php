<?php namespace RemiDeltombe\Page\Components;

use RemiDeltombe\Page\Models\Page;

class Detail extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [
            'id' => [
                 'title'             => 'Id of the page',
                 'description'       => 'The id of the page to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'Id must be a number'
            ],
            'url' => [
                 'title'             => 'Url of the page',
                 'description'       => 'The url of the page to display',
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
            'name' => 'Page detail',
            'description' => 'Displays the detail of a page.'
        ];
    }

    public function page()
    {
        if(strlen($this->property('url')))
        {
            return Page::where('url', '/'.$this->property('url'))->first();
        }
        return Page::find($this->property('id'));
    }
}