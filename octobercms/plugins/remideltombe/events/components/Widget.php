<?php namespace RemiDeltombe\Events\Components;

use RemiDeltombe\Events\Models\Event;
use RemiDeltombe\Events\Models\Category;
use RemiDeltombe\Esport\Models\Game;

use Input;

class Widget extends \Cms\Classes\ComponentBase
{
    private $query;

    public function init()
    {
        $this->query =  Event::where('is_active', true)->orderBy('date', 'DESC');
        if($game = Game::context())
        {
            $this->query = $this->query->where('game_id', '=', $game->id);
        }
    }

    public function defineProperties()
    {
        return [
            'count' => [
                 'title'             => 'Event displayed ',
                 'description'       => 'The total of events displayed in the list',
                 'default'           => 10,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'The Max Events property can contain only numeric symbols'
            ]
        ];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'Events list',
            'description' => 'Displays a list of events.'
        ];
    }

    public function events()
    {
        return $this->query->orderBy('date', 'DESC')->paginate($this->property('count'));
    }

    public function categories()
    {
        return Category::all();
    }
}