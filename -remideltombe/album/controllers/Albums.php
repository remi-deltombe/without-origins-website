<?php namespace RemiDeltombe\Album\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use RemiDeltombe\Album\Models\Album;

class Albums extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'remideltombe.album.edit' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('RemiDeltombe.Album', 'main-menu-item');
    }

    public function list()
    {
        $this->suppressLayout = true;
        return Album::all()->toArray();
    }
}
