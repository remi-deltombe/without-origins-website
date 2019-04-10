<?php namespace RemiDeltombe\News\Models;

use Model;
use Input;
use Validator;

/**
 * Model
 */
class Item extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'remideltombe_news_item';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'url' => 'required|unique:remideltombe_news_item'
    ];

    public $belongsTo = [
        'category' => ['RemiDeltombe\News\Models\Category'],
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
}
