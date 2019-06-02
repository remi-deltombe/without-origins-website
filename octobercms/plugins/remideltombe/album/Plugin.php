<?php namespace RemiDeltombe\Album;

use System\Classes\PluginBase;

use Backend\FormWidgets\RichEditor;
use Cms\Classes\Controller;

class Plugin extends PluginBase
{
    public function boot()
    {
        RichEditor::extend(function($widget) {
            $widget->addJs('/plugins/remideltombe/album/assets/js/froala.album.js');
        });
    }


    // Within my plugin
    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'album' => function($content)
                { 
                    $controller = Controller::getController();
                    $controller->addComponent('RemiDeltombe\Album\Components\Album', 'album', [], false);
                    $parts = preg_split( "/(<!-- \[\[ALBUM:START]] -->|<!-- \[\[ALBUM:END]] -->)/", $content );
                    for($i=1; $i<count($parts); $i+=2)
                    {
                        $matches = [];
                        preg_match("/<!-- \[\[ID:([0-9]*)]] -->/", $parts[$i], $matches);
                        $id = explode(']] -->', explode('<!-- [[ID:', $matches[0])[1])[0];
                        $parts[$i] = $controller->renderComponent('album', ['id'=>$id]);
                    }
                    return implode($parts);
                },
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'RemiDeltombe\Album\Components\Album' => 'album',
        ];
    }
}
