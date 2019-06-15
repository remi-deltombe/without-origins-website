<?php namespace RemiDeltombe\Esport\Components;

use RemiDeltombe\Esport\Models\Game;

class Games extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'Games list',
            'description' => 'Displays a list of games.'
        ];
    }

    public function games()
    {
        return Game::where('is_active', true)->get();
    }
}