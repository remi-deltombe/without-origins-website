<?php namespace RemiDeltombe\Events\Components;

use RemiDeltombe\Events\Models\Event as EventsEvent;

class Event extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [
            'id' => [
                 'title'             => 'Id of the events',
                 'description'       => 'The id of the events to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'Id must be a number'
            ],
            'slug' => [
                 'title'             => 'Slug of the events',
                 'description'       => 'The slug of the events to display',
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
            'name' => 'Events detail',
            'description' => 'Displays the detail of an events.'
        ];
    }

    public function event()
    {
        if(strlen($this->property('slug')))
        {
            $item = EventsEvent::where('slug', $this->property('slug'))->first();
        }
        else
        {
            $item = EventsEvent::find($this->property('id'));
        }
        if($item)
        {
            return $item;
        }
        header('Location: /404');
        die;
    }
}