<?php namespace RemiDeltombe\Page\Models;

use Model;

/**
 * Model
 */
class Page extends Model
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
    public $table = 'remideltombe_page_page';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
