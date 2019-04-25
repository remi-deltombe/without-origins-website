<?php namespace RemiDeltombe\Faker\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Generation extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'remideltombe.faker.generate' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RemiDeltombe.Faker', 'main-menu-item');
    }
}
