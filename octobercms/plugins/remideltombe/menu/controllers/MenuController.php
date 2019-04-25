<?php namespace RemiDeltombe\Menu\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class MenuController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    public $requiredPermissions = ['remideltombe.menu.edit_menu'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('remideltombe.Menu', 'main-menu-item');
    }
}
