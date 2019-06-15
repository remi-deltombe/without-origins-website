<?php namespace RemiDeltombe\Page\Models;

use Model;
use RemiDeltombe\Esport\Models\Game;

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
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'remideltombe_page_page';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'game' => ['RemiDeltombe\Esport\Models\Game']
    ];

    public function link()
    {
        $url = '/' . $this->slug;
        if($this->game)
        {
            $url = $this->game->link() . $this->slug;
        }
        return $url;
    }
}

