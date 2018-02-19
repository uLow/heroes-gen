<?php
$source = preg_replace('/[^-a-z]/i', '', $_GET['src'] ?? 'league-of-legends');
$sourceFile = $source . '.json';

if(file_exists($sourceFile)){
    $heroesFile = file_get_contents($sourceFile);
    $heroes = json_decode($heroesFile);

    $filterList = [
        'lowercase' => function($name){ return strtolower($name); },
        'uppercase' => function($name){ return strtoupper($name); },
        'join' => function($name){ return str_replace(' ', '-', $name); },
        'alpha' => function($name){ return preg_replace('/[^-a-z]|(?:[^a-z]$)/i', '', $name); },
    ];

    $hero = $heroes[mt_rand(0, count($heroes) - 1)];

    if(isset($_GET['filters'])){
        $filters = explode(',', $_GET['filters']);
        foreach($filters as $filter){
            if(isset($filterList[$filter])){
                // We can't do `$hero = $filterList[$filter]($hero);`
                $activeFilter = $filterList[$filter];
                $hero = $activeFilter($hero);
            }
        }
    }

    header('Content-Type: application/json');
    die(json_encode($hero));
}
