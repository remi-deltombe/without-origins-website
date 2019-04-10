<?php namespace RemiDeltombe\Menu\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Menus extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'remideltombe.menu.edit_menu' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RemiDeltombe.Menu', 'main-menu-item');
    }
}
