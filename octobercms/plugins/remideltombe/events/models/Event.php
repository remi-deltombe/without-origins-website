<?php namespace RemiDeltombe\Events\Models;

use Model;
use Input;
use Validator;

/**
 * Model
 */
class Event extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'remideltombe_events_event';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'slug' => 'required|unique:remideltombe_events_event'
    ];

    public $belongsTo = [
        'category' => ['RemiDeltombe\Events\Models\Category'],
        'game' => ['RemiDeltombe\Esport\Models\Game']
    ];

    public function scopeByCategory($query, $status = 'approved', $onlyMine = false, $due = null)
    {
        if ($category = Category::where('name', Input::get($status, ''))->first())
        {
            $query = $query->where('category_id', $category->id);
        }
        return $query->where('is_active', true);
    }

    public function scopeLatest($query, $status = 'approved', $onlyMine = false, $due = null)
    {
        return $query->where('is_active', true)->limit(4)->orderBy('publication_date', 'DESC');
    }

    public function link()
    {
        $url = Settings::get('detail_slug').'/' . $this->slug;
        if($this->game)
        {
            $url = $this->game->link() . $url;
        }
        else
        {
            $url = '/'.$url;
        }
        return $url;
    }
}
