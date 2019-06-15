<?php namespace RemiDeltombe\News\Components;

use RemiDeltombe\News\Models\Item;
use RemiDeltombe\News\Models\Category;
use RemiDeltombe\Esport\Models\Game;

use Input;

class Items extends \Cms\Classes\ComponentBase
{
    private $query;

    public function init()
    {
        $this->query =  Item::where('is_active', true)->orderBy('publication_date', 'DESC');
        if($game = Game::context())
        {
            $this->query = $this->query->where('game_id', '=', $game->id);
        }
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
            ],
            'display_categories' => [
                 'title'             => 'Display categories menu ',
                 'description'       => 'Should the category menu being display?',
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
        if(Input::has('category'))
        {
            $category = Category::where('name', Input::get('category'))->first();
            $this->query = $this->query->where('category_id', $category->id);
        }
        return $this->query->paginate($this->property('count'));
    }

    public function categories()
    {
        return Category::all();
    }
}