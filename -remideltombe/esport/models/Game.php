<?php namespace RemiDeltombe\Esport\Models;

use Model;

/**
 * Model
 */
class Game extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'remideltombe_esport_game';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'menu' => ['RemiDeltombe\Menu\Models\Menu'],
    ];

    protected $jsonable = ['races'];

    public function link()
    {
        return '/' . $this->slug.'/';
    }

    /**
     * Current game context
     */
    private static $context = null;

    public static function setContext(Game $game)
    {
        static::$context = $game;
    }

    public static function context()
    {
        return static::$context;
    }

    public static function contextId()
    {
        return static::$context ? static::$context->id : null;
    }

}
