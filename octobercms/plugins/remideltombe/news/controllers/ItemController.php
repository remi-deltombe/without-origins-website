<?php namespace RemiDeltombe\News\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ItemController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    public $requiredPermissions = ['remideltombe.news.edit_item'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RemiDeltombe.News', 'news');
    }
}
