<?php namespace RemiDeltombe\Esport\Components;

use RemiDeltombe\Esport\Models\Result;
use RemiDeltombe\Esport\Models\Game;

use Input;

class Results extends \Cms\Classes\ComponentBase
{
    private $query;

    public function init()
    {
        $this->query =  Result::where('is_active', true)->orderBy('publication_date', 'DESC');
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
            ]
        ];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'Esport result list',
            'description' => 'Displays a list of result.'
        ];
    }

    public function items()
    {
        return $this->query->paginate($this->property('count'));
    }
}