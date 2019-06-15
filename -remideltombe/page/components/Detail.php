<?php namespace RemiDeltombe\Page\Components;

use RemiDeltombe\Page\Models\Page;
use RemiDeltombe\Esport\Models\Game;
use Redirect;

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
            'slug' => [
                 'title'             => 'Slug of the page',
                 'description'       => 'The slug of the page to display',
                 'default'           => '',
                 'type'              => 'string',
                 'validationPattern' => '^/[^\/]{1,}',
                 'validationMessage' => 'Slug must be valid'
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

    public function item()
    {
        if(strlen($this->property('slug')))
        {
            $page = Page::where('game_id', Game::contextId())
                        ->where('slug', $this->property('slug'))
                        ->first();
        }
        else
        {
            $page = Page::find($this->property('id'));
        }
        if($page && $page->is_active)
        {
            return $page;
        }
        header('Location: /404');
        die;
    }
}