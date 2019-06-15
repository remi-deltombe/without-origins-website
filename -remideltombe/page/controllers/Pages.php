<?php namespace RemiDeltombe\Page\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Pages extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'remideltombe.page.edit_page' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RemiDeltombe.Page', 'page');
    }
}
