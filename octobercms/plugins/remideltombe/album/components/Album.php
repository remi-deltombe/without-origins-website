<?php namespace RemiDeltombe\Album\Components;

use RemiDeltombe\Album\Models\Album as AlbumModel;

class Album extends \Cms\Classes\ComponentBase
{
    public function defineProperties()
    {
        return [
            'id' => [
                 'title'             => 'Id of the album',
                 'description'       => 'The id of the album to display',
                 'default'           => -1,
                 'type'              => 'string',
                 'validationPattern' => '^[0-9]+$',
                 'validationMessage' => 'Id must be a number'
            ]
        ];
    }

    public function componentDetails()
    {   
        return [
            'name' => 'Album image list',
            'description' => 'Displays the images of an album.'
        ];
    }

    public function item()
    {
        $item= AlbumModel::find($this->property('id'));
        return $item;
    }
}