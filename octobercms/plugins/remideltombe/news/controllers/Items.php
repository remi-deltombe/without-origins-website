<?php namespace RemiDeltombe\News\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Items extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'remideltombe.news.edit_item' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RemiDeltombe.News', 'news', 'item');
    }
}
