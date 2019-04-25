<?php namespace Xeor\ContentType;

use Event;
use Request;
use Response;
use BackendAuth;
use Cms\Classes\Page;
use System\Classes\PluginBase;
use Cms\Models\MaintenanceSetting;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'xeor.contenttype::lang.plugin.name',
            'description' => 'xeor.contenttype::lang.plugin.description',
            'author' => 'Sozonov Alexey',
            'icon' => 'icon-file-code-o'
        ];
    }

    public function boot()
    {
        Event::listen('backend.form.extendFields', function ($formWidget) {
            if ($formWidget->model instanceof \Cms\Classes\Page) {
                $formWidget->addFields(
                    [
                        'settings[contentType]' => [
                            'tab' => 'xeor.contenttype::lang.settings.tab',
                            'type' => 'dropdown',
                            'default' => 'html',
                            'options' => [
                                'html' => 'html',
                                'json' => 'json',
                                'xml' => 'xml',
                                'txt' => 'text',
                                'pdf' => 'pdf',
                                'js' => 'javascript',
                                'css' => 'css',
                            ],
                            'span' => 'left',
                            'comment' => 'xeor.contenttype::lang.settings.content_type_comment'
                        ],
                        'settings[customContentType]' => [
                            'tab' => 'xeor.contenttype::lang.settings.tab',
                            'placeholder' => 'xeor.contenttype::lang.settings.custom_content_type_placeholder',
                            'span' => 'right',
                            'comment' => 'xeor.contenttype::lang.settings.custom_content_type_comment',
                        ],
                        'settings[force_show]' => [
                            'tab' => 'xeor.contenttype::lang.settings.tab',
                            'label' => 'xeor.contenttype::lang.settings.custom_content_force_show',
                            'type' => 'checkbox',
                            'span' => 'left',
                            'comment' => 'xeor.contenttype::lang.settings.custom_content_force_show_comment',
                        ],
                    ],
                    'primary'
                );
            }
        });

        Event::listen('cms.page.beforeDisplay', function ($controller, $url, $page) {

            /*
             * Maintenance mode
             */
            if (
                MaintenanceSetting::isConfigured() &&
                MaintenanceSetting::get('is_enabled', false) &&
                !BackendAuth::getUser()
            ) {
                $currentPage = $controller->getRouter()->findByUrl($url);
                if ($currentPage && isset($currentPage->force_show) && $currentPage->force_show && !$currentPage->is_hidden) {
                    $controller->setStatusCode(200);
                    $page = $currentPage;
                }

            }

            return $page;

        });

        Event::listen('cms.page.display', function ($controller, $url, $page, $result) {

            if (!is_string($result))
                return $result;

            $type = null;
            $headers = [];
            $types = array(
                'html' => 'text/html',
                'json' => 'application/json',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'pdf' => 'application/pdf',
                'txt' => 'text/plain',
                'xml' => 'application/xml'
            );

            if (isset($page->settings['contentType']) && !empty($page->settings['contentType']))
                $type = $types[$page->settings['contentType']];

            if (isset($page->settings['customContentType']) && !empty($page->settings['customContentType']))
                $type = $page->settings['customContentType'];

            if (!is_null($type))
                $headers = ['Content-Type' => $type];

            return Response::make($result, $controller->getStatusCode(), $headers);

        });
    }

}