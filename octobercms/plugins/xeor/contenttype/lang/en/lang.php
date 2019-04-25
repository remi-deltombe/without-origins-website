<?php

return [
    'plugin' => [
        'name' => 'Content Type',
        'description' => 'Assign custom content types to CMS pages.',
    ],
    'settings' => [
        'tab' => 'Content Type',
        'content_type_comment' => 'Select the content type',
        'custom_content_type_placeholder' => 'e.g., text/cache-manifest',
        'custom_content_type_comment' => 'or enter your own',
        'custom_content_force_show' => 'Force visible',
        'custom_content_force_show_comment' => 'Page is accessible when maintenance mode is activated.',
    ],
];