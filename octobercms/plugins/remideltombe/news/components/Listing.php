<?php namespace RemiDeltombe\News\Components;

use RemiDeltombe\News\Models\Item;

class Listing extends \Cms\Classes\ComponentBase
{
    private $query;

    public function init()
    {
        $this->query =  Item::where('is_active', true);
    }

    public function defineProperties()
    {
        return [
            'count' => [
                 'title'             => 'Item displayed ',
                 'description'       => 'The total of news displayed in the list',
                 'default'           => 10,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'The Max Items property can contain only numeric symbols'
            ],
            'is_paginated' => [
                 'title'             => 'Display pagination ',
                 'description'       => 'Should the pagination being display if needed?',
                 'default'           => true,
                 'type'              => 'checkbox'
            ]
        ];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'News list',
            'description' => 'Displays a list of news.'
        ];
    }

    public function items()
    {
        return $this->query->limit($this->property('count'))->get();
    }
}