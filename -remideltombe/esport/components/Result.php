<?php namespace RemiDeltombe\Esport\Components;

use RemiDeltombe\Esport\Models\Result as ResultModel;

class Result extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [
            'id' => [
                 'title'             => 'Id of the result',
                 'description'       => 'The id of the result to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'Id must be a number'
            ],
            'slug' => [
                 'title'             => 'Slug of the result',
                 'description'       => 'The slug of the result to display',
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
            'name' => 'result detail',
            'description' => 'Displays the detail of a result.'
        ];
    }

    public function item()
    {
        if(strlen($this->property('slug')))
        {
            $item = ResultModel::where('slug', $this->property('slug'))->first();
        }
        else
        {
            $item = ResultModel::find($this->property('id'));
        }
        if($item)
        {
            return $item;
        }
        header('Location: /404');
        die;
    }

    public function raceImage($item, $id)
    {
        return $item->game->races[$id]['image'];
    }
}