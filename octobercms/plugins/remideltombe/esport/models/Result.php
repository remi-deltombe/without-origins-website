<?php namespace RemiDeltombe\Esport\Models;

use Model;

/**
 * Model
 */
class Result extends Model
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
    public $table = 'remideltombe_esport_result';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'game_id' => 'required',
        'slug' => 'required|unique:remideltombe_news_item'
    ];

    public $belongsTo = [
        'game' => ['RemiDeltombe\Esport\Models\Game']
    ];

    protected $jsonable = ['matches'];

    public function link()
    {
        $url = Settings::get('result_detail_slug').'/' . $this->slug;
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

    public function isMultiplayer()
    {
        return isset($this->matches[0])  && count($this->matches[0]['team_a_players']) > 1;
    }

    public function score()
    {
        $a = 0;
        $b = 0;

        foreach ($this->matches as $match) {
            if($match['winner'] == 1)
            {
                ++$a;
            }
            else
            {
                ++$b;
            }
        }

        return (object)[
            "team_a" => $a,
            "team_b" => $b,
            "winner" => $a > $b ? 1 : ($a < $b ? 2 : 0)
        ];
    }

    public function getRaceIdOptions() {
        $result = [];
        foreach ($this->game->races as $race)
        {
            $result[] = $race['name'];
        }
        return $result;
    }
}
