<?php namespace RemiDeltombe\Faker\Models;

use Model;
use Carbon\Carbon;

use RemiDeltombe\Menu\Models\Menu;
use RemiDeltombe\Esport\Models\Game;
use RemiDeltombe\Page\Models\Page;
use RemiDeltombe\News\Models\Category as NewsCategory;
use RemiDeltombe\News\Models\Item as NewsItem;
use RemiDeltombe\Events\Models\Category as EventCategory;
use RemiDeltombe\Events\Models\Event;
use RemiDeltombe\Esport\Models\Result as EsportResult;

/**
 * Model
 */
class Generation extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'remideltombe_faker_generation';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $defaultPages =     [
        ["name"=>"La team", "slug"=>"la-team"],
        ["name"=>"Contact", "slug"=>"contact"]
    ];


    public $defaultGames = [
        [ 
            "name" => "Heroes of the Storm", 
            "slug" => "hots", 
            "pages"=>[
                ["name"=>"Line-up", "slug"=>"line-up"], 
                ["name"=>"Builds", "slug"=>"builds"]
            ]
        ],
        [ 
            "name" => "Starcraft 2", 
            "slug" => "sc2", 
            "pages"=>[
                ["name"=>"Line-up", "slug"=>"line-up"], 
                ["name"=>"Builds", "slug"=>"builds"]
            ]
        ],
        [ 
            "name" => "World of Warcraft", 
            "slug" => "wow", 
            "pages"=>[
                ["name"=>"Line-up", "slug"=>"line-up"], 
                ["name"=>"Builds", "slug"=>"builds"]
            ]
        ]
    ];

    public $defaultMenu = [
        [
            'name' => 'Actus',
            'link' => '/news'
        ]
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->generate();
        });

        self::deleting(function($model){
            $model->ungenerate();
        });
    }

    private function generate()
    {
        $result = [];
        $categories = [];

        // Generate main menu if not exists
        $menu = Menu::find(1);
        if(!$menu)
        {
            $newsCategories = $this->generateNewsCategories();
            $eventsCategories = $this->generateEventCategories();

            // Main menu
            $menu = $this->generateMenu('Main menu', false, $this->defaultPages);
            $this->generatePages($this->defaultPages, null);
            $this->generateNews($newsCategories,null);
            $this->generateEvents($eventsCategories,null);
        }

        // Generate game and their content if not exists
        $game = Game::find(1);
        if(!$game)
        {
            foreach ($this->defaultGames as $defaultGame)
            {
                $game = new Game;
                $game->name = $defaultGame['name'];
                $game->slug = $defaultGame['slug'];
                $game->races = /*json_encode(*/[
                    [ "name" => "Zerg", "image"=>"no-image.png"],
                    [ "name" => "Protoss", "image"=>"no-image.png"],
                    [ "name" => "Terran", "image"=>"no-image.png"]
                ];//, JSON_UNESCAPED_SLASHES);
                $game->menu = $this->generateMenu($game->name.' menu', $game->slug, $defaultGame['pages']);
                $game->save();

                $this->generatePages($defaultGame['pages'], $game);
                $this->generateNews($newsCategories, $game);
                $this->generateEvents($eventsCategories,$game);
                $this->generateResults($game);
            }
        }
        $this->generated = json_encode($result, JSON_UNESCAPED_SLASHES);

    }

    private function ungenerate()
    {

    }

    private function generateMenu($name, $slug, $pages)
    {
        $items = $this->defaultMenu;

        if($slug)
        {
            foreach ($items as &$item) {
                $item['link'] =  '/'. $slug . $item['link'];
            }
        }

        foreach ($pages as $page)
        {
            $items[] = [
                'name' => $page['name'],
                'link' => ($slug ? ('/'.$slug) : '') . '/' . $page['slug']
            ];
        }


        $menu = new Menu();
        $menu->name = $name;
        $menu->items = $items;
        $menu->save();
        return $menu;
    }

    private function generatePages($pages, $game)
    {
        $faker = $faker = \Faker\Factory::create();

        foreach ($pages as $_page) {
            $page = new Page();

            $image = 'no-image.jpg';
            $description= $faker->text();
            $html = '<h1>'.$_page['name'].'</h1>';
            for($i=$faker->numberBetween(2,4); $i>=0; --$i)
            {
                $h = $faker->numberBetween(2,3);
                $html .= '<h'.$h.'>'.$faker->sentence().'</h'.$h.'>';
                $html .= '<p>'.$faker->paragraph().'</p>';
            }

            $page->game               = $game;
            $page->title              = $_page['name'];
            $page->slug               = $_page['slug'];
            $page->is_active          = true;

            $page->image              = $image;
            $page->content            = $html;
            $page->social_title       = $_page['name'];
            $page->social_description = $description;
            $page->social_image       = $image;
            $page->seo_title          = $_page['name'];
            $page->seo_description    = $description;

            $page->save();
        }
    }

    private function generateNewsCategories()
    {
        $faker = $faker = \Faker\Factory::create();
        $categories = [];

        for($i=5; $i>=0; --$i)
        {
            $category = new NewsCategory();
            $category->name = $faker->word;
            $category->save();
            $categories[] = $category;
        }
        return $categories;
    }

    private function generateEventCategories()
    {
        $faker = $faker = \Faker\Factory::create();
        $categories = [];

        for($i=5; $i>=0; --$i)
        {
            $category = new EventCategory();
            $category->name = $faker->word;
            $category->color=$faker->hexcolor;
            $category->save();
            $categories[] = $category;
        }
        return $categories;
    }

    private function generateNews($categories, $game)
    {
        $faker = $faker = \Faker\Factory::create();

        for($i=$faker->numberBetween(30,50); $i>=0; --$i)
        {
            $item = new NewsItem();

            $name = $faker->sentence();
            $slug = $faker->slug();
            $image = 'no-image.jpg';
            $description= $faker->text();
            $html = '<h1>'.$name.'</h1>';
            for($j=$faker->numberBetween(2,4); $j>=0; --$j)
            {
                $h = $faker->numberBetween(2,3);
                $html .= '<h'.$h.'>'.$faker->sentence().'</h'.$h.'>';
                $html .= '<p>'.$faker->paragraph().'</p>';
            }

            $item->game               = $game;
            $item->category           = $categories[$faker->numberBetween(0, 4)];
            $item->title              = $name;
            $item->slug               = $slug;
            $item->is_active          = true;

            $item->thumb              = $image;
            $item->description        = $description;
            $item->publication_author = $faker->name();
            $item->publication_date   = $faker->dateTime();

            $item->image              = $image;
            $item->content            = $html;
            $item->social_title       = $name;
            $item->social_description = $description;
            $item->social_image       = $image;
            $item->seo_title          = $name;
            $item->seo_description    = $description;

            $item->save();
        }
    }

    private function generateResults($game)
    {
        $faker = $faker = \Faker\Factory::create();

        for($i=$faker->numberBetween(10,20); $i>=0; --$i)
        {
            $item = new EsportResult();

            $name = $faker->sentence();
            $slug = $faker->slug();
            $image = 'no-image.jpg';
            $description= $faker->text();
            $html = '<h2>'.$name.'</h2>';
            
            for($j=$faker->numberBetween(1,2); $j>=0; --$j)
            {
                $h = $faker->numberBetween(2,3);
                $html .= '<p>'.$faker->paragraph().'</p>';
            }

            $players = [[],[]];
            for($j=($faker->numberBetween(1,5) * 2)+1; $j>=0; --$j)
            {
                $players[$j%2][] = [
                    "name"=>$faker->word,
                    "race_id"=>$faker->numberBetween(0,2).''
                ];
            }

            $matches = [];
            for($j=$faker->numberBetween(1, 5); $j>=0; --$j)
            {
                $matches[] = $this->generateMatch($players[0], $players[1]);
            }

            $item->game               = $game;
            $item->title              = $name;
            $item->slug               = $slug;
            $item->is_active          = true;

            $item->team_a_name        = $faker->word;
            $item->team_b_name        = $faker->word;

            $item->team_a_logo        = $image;
            $item->team_b_logo        = $image;

            $item->team_a_color        = $faker->hexcolor;
            $item->team_b_color        = $faker->hexcolor;

            

            //$item->matches            = json_encode($matches, JSON_UNESCAPED_SLASHES);
            $item->matches            = $matches;
            $item->thumb              = $image;
            $item->description        = $description;
            $item->image              = $image;

            $item->publication_author = $faker->name();
            $item->publication_date   = $faker->dateTime();
            $item->content            = $html;
            $item->social_title       = $name;
            $item->social_description = $description;
            $item->social_image       = $image;
            $item->seo_title          = $name;
            $item->seo_description    = $description;

            $item->save();
        }
    }

    private function generateMatch($playersA=[], $playersB=[])
    {
        $faker = $faker = \Faker\Factory::create();

        $item = new EsportResult();

        $image = 'no-image.jpg';
        $html = '<h2>'.$faker->word.'</h2>';

        for($j=$faker->numberBetween(1,2); $j>=0; --$j)
        {
            $h = $faker->numberBetween(2,3);
            $html .= '<p>'.$faker->paragraph().'</p>';
        }

        return [
            "winner" => $faker->numberBetween(1,2).'',
            "description" => $html,
            "team_a_players" => $playersA,
            "team_b_players" => $playersB,
            "map_name" => $faker->word,
            "map_image" => $image
        ];
    }


    private function generateEvents($categories, $game)
    {
        $faker = $faker = \Faker\Factory::create();

        for($i=$faker->numberBetween(1,10); $i>=0; --$i)
        {
            $item = new Event();

            $name = $faker->sentence();
            $slug = $faker->slug();
            $image = 'no-image.jpg';
            $description= $faker->text();
            $html = '<h1>'.$name.'</h1>';
            $item->date = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp()) ;

            for($j=$faker->numberBetween(2,4); $j>=0; --$j)
            {
                $h = $faker->numberBetween(2,3);
                $html .= '<h'.$h.'>'.$faker->sentence().'</h'.$h.'>';
                $html .= '<p>'.$faker->paragraph().'</p>';
            }

            $item->game               = $game;
            $item->category           = $categories[$faker->numberBetween(0, 4)];
            $item->title              = $name;
            $item->slug               = $slug;
            $item->is_active          = true;

            $item->thumb              = $image;
            $item->description        = $description;
            $item->publication_author = $faker->name();

            $item->image              = $image;
            $item->content            = $html;
            $item->social_title       = $name;
            $item->social_description = $description;
            $item->social_image       = $image;
            $item->seo_title          = $name;
            $item->seo_description    = $description;

            $item->save();
        }
    }


}
