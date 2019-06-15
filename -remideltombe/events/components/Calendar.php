<?php namespace RemiDeltombe\Events\Components;

use Carbon\Carbon;

use RemiDeltombe\Events\Models\Event;
use RemiDeltombe\Events\Models\Category;
use RemiDeltombe\Esport\Models\Game;

use Input;

class Calendar extends \Cms\Classes\ComponentBase
{
    private $query;

    public function init()
    {
        $this->query =  Event::where('is_active', true);
        if($game = Game::context())
        {
            $this->query = $this->query->where('game_id', '=', $game->id);
        }

        if(Input::has('category'))
        {
            $category = Category::where('name', Input::get('category'))->first();
            $query = $this->query->where('category_id', $category->id);
        }
    }

    public function defineProperties()
    {
        return [
            'day' => [
                 'title'             => 'Day to display',
                 'description'       => 'The day to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]{1-2}$',
                 'validationMessage' => 'Day must be a number'
            ],
            'month' => [
                 'title'             => 'Month to display',
                 'description'       => 'The month to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]{1-2}$',
                 'validationMessage' => 'Month must be a number'
            ],
            'year' => [
                 'title'             => 'Year to display',
                 'description'       => 'The year to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]{1-2}$',
                 'validationMessage' => 'Year must be a number'
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

    public function events($day=null)
    {
        $query = clone $this->query;
        if($day)
        {
            $date = Carbon::create(
                $this->yearNumber(),
                $this->monthNumber(),
                $day, 
                0,
                0,
                0,
                'Europe/Luxembourg'
            );
            $to = $date->copy()->addDay();
            $query = $query->whereBetween('date', [$date, $to]);
        }
        return $query->orderBy('date', 'DESC')->get();
    }

    public function categories()
    {
        return Category::all();
    }

    public function year()
    {
        return intval($this->yearNumber());
    }

    public function month()
    {
        $monthNumber = Carbon::create(0, $this->monthNumber(), 1, 0, 0, 0, 'Europe/Luxembourg')->month;
        $months = [
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre',
        ];
        return $months[$monthNumber-1];
    }

    public function previousMonth()
    {
        $prev = Carbon::create(
            $this->yearNumber(),
            $this->monthNumber(),
            1,
            0, 
            0,
            0,
            'Europe/Luxembourg'
        )->addMonth(-1);
        $month=$prev->month;
        $year=$prev->year;
        return "?month=$month&year=$year";
    }

    public function nextMonth()
    {
        $next = Carbon::create(
            $this->yearNumber(),
            $this->monthNumber(),
            1, 
            0, 
            0,
            0,
            'Europe/Luxembourg'
        )->addMonth();
        $month=$next->month;
        $year=$next->year;
        return "?month=$month&year=$year";
    }

    private function monthNumber()
    {
        $month = intval(Input::get('month' , Carbon::now()->month));
        if($month < 1 || $month > 12 ) return Carbon::now()->month;
        return $month;
    }

    private function yearNumber()
    {
        $year = intval(Input::get('year' , Carbon::now()->year));
        if($year < 1 ) return Carbon::now()->year;
        return $year;
    }
}