<?php namespace RemiDeltombe\Events\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Events extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'remideltombe.events.edit_event' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RemiDeltombe.Events', 'events', 'event');
    }
}
