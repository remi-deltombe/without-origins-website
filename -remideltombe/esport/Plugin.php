<?php namespace RemiDeltombe\Esport;

use System\Classes\PluginBase;
use RemiDeltombe\Esport\Models\Game;
use RemiDeltombe\Esport\Models\Settings;
use RemiDeltombe\Menu\Models\Menu;

use App;
use Request;
use Route;

class Plugin extends PluginBase
{
    public $require = ['RemiDeltombe.Menu'];

    public function boot()
    {
        // Prefix route with game on front
        if(!App::runningInBackend())
        {
            $slug = Request::segment(1);
            $game = Game::where('is_active', true)->where('slug', '=', $slug)->first();
            if($game)
            {
                Game::setContext($game);
                Route::group(['prefix' => $slug, 'middleware' => 'web'], function() {
                    Route::get('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
                    Route::get('', 'Cms\Classes\CmsController@run');
                });

                Route::get('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
            }
        }
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'esport_menu_id' => function()
                {
                    $settings = Settings::instance();
                    $id = 1;
                    if($settings->default_menu) 
                    {
                        $id = $settings->default_menu;
                    }
                    if($game = Game::context()) 
                    {
                        $id = $game->menu_id;
                    }
                    return $id;
                },
                'esport_context' => function()
                {
                    return Game::context();
                },
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'RemiDeltombe\Esport\Components\Games' => 'esportGames',
            'RemiDeltombe\Esport\Components\Result' => 'esportResult',
            'RemiDeltombe\Esport\Components\Results' => 'esportResults'
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Esport',
                'description' => 'Esport settings.',
                'icon'        => 'icon-gamepad',
                'class'       => 'RemiDeltombe\Esport\Models\Settings',
                'order'       => 500,
                'category'    => 'Content',
                'permissions' => ['cms.manage_pages']
            ]
        ];
    }
}
