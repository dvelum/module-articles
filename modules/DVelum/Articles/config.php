<?php
return [
    'id' => 'dvelum_articles',
    'version' => '1.0',
    'author' => 'Kirill Egorov',
    'name' => 'DVelum Articles',
    'configs' => './configs',
    'locales' => './locales',
    'resources' =>'./resources',
    'templates' => './templates',
    'vendor'=>'Dvelum',
    'autoloader'=> [
        './classes'
    ],
    'objects' =>[
        'dvelum_article',
        'dvelum_article_category',
    ],
    'post-install'=>'Dvelum_Backend_Articles_Installer'
];