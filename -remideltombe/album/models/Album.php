<?php namespace RemiDeltombe\Album\Models;

use Model;
use RemiDeltombe\Album\Components\Album as AlbumComponent;

/**
 * Model
 */
class Album extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'remideltombe_album_album';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name'   => 'required',
        'images.*' => 'image'
    ];

    public $attachMany = [
        'images' => 'RemiDeltombe\Attach\Models\File'
    ];
}
