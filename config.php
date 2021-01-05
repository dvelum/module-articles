<?php
return [
    'id' => 'dvelum-module-articles',
    'version' => '3.0.3',
    'author' => 'Kirill Yegorov',
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
    'post-install'=>'\\Dvelum\\Articles\\Installer'
];