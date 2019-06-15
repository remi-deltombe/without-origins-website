<?php namespace RemiDeltombe\Twig;

use System\Classes\PluginBase;
use Input;
use Request;

class Plugin extends PluginBase
{
    private static $meta_title = "";
    private static $meta_desc = "";
    private static $og_url = "";
    private static $og_title = "";
    private static $og_desc = "";
    private static $og_image = "";

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'input' => function($name, $default="") { return Input::get($name, $default); },
                'link'  => function($path) { return 'hello'; },
                'meta'  => function()
                {
                    $meta  ='<title>'.Plugin::$meta_title.'</title>'."\n";
                    $meta .='<meta name="description" content="'.Plugin::$meta_desc.'" />'."\n";
                    $meta .='<meta property="og:type" content="article"/>'."\n";
                    $meta .='<meta property="og:title" content="'.Plugin::$og_title.'" />'."\n";
                    $meta .='<meta property="og:description" content="'.Plugin::$og_desc.'" />'."\n";
                    $meta .='<meta property="og:url" content="'.Plugin::$og_url.'" />'."\n";
                    $meta .='<meta property="og:image" content="'.Plugin::$og_image.'" />'."\n";
                    return $meta;
                },
                'describe' => function($title="", $desc="")
                {
                    Plugin::$meta_title = $title;
                    Plugin::$meta_desc = $desc;
                    return '';
                },
                'share_as' => function($url, $title="", $desc="", $image="")
                {
                    Plugin::$og_url = $url;
                    Plugin::$og_title = $title;
                    Plugin::$og_desc = $desc;
                    Plugin::$og_image = $image;
                    return '';
                },
                'current_url' => function($args=[], $remove=[])
                {
                    $params = '';
                    
                    if($remove !== true)
                    {
                        $inputs = Input::all();
                        foreach ($args as $key => $value) {
                            $inputs[$key] = $value;
                        }
                        foreach ($inputs as $key => $value) {
                            if(!in_array($key, $remove))
                            {
                                $params .= '&'.$key;
                                if(strlen($value))
                                    $params .= '='.$value;
                            }
                        }
                        if(strlen($params))
                        {
                            $params[0] = '?';
                        }
                    }
                    return Request::url() . $params;
                },
                
                'current_path' => function($args=[], $remove=[])
                {
                    $params = '';
                    
                    if($remove !== true)
                    {
                        $inputs = Input::all();
                        foreach ($args as $key => $value) {
                            $inputs[$key] = $value;
                        }
                        foreach ($inputs as $key => $value) {
                            if(!in_array($key, $remove))
                            {
                                $params .= '&'.$key;
                                if(strlen($value))
                                    $params .= '='.$value;
                            }
                        }
                        if(strlen($params))
                        {
                            $params[0] = '?';
                        }
                    }
                    return '/'.Request::path() . $params;
                },
            ],
            'filters'=>[
                'slice_dot' => function($content, $length)
                {
                    if(strlen($content)<=$length) return $content;
                    return substr($content, 0, $length) . '...';
                }
            ]
        ];
    }
}
