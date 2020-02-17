<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakePdf' => $baseDir . '/vendor/friendsofcake/cakepdf/',
        'Cake/ElasticSearch' => $baseDir . '/vendor/cakephp/elastic-search/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Josegonzalez/Upload' => $baseDir . '/vendor/josegonzalez/cakephp-upload/',
        'Media' => $baseDir . '/plugins/Media/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Search' => $baseDir . '/vendor/friendsofcake/search/',
        'SuperUpload' => $baseDir . '/plugins/SuperUpload/',
        'TinyAuth' => $baseDir . '/vendor/dereuromark/cakephp-tinyauth/',
        'Utils' => $baseDir . '/vendor/cakemanager/cakephp-utils/',
        'Xety/Cake3Upload' => $baseDir . '/vendor/xety/cake3-upload/'
    ]
];