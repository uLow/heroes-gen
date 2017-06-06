<?php

$heroesFile = file_get_contents('heroes.json');
$heroes = json_decode($heroesFile);

$filterList = [
    'lowercase' => function($name){ return strtolower($name); }, 
    'uppercase' => function($name){ return strtoupper($name); }, 
    'alpha' => function($name){ return preg_replace('/[^a-z]/gi', '', $name); },
];

$hero = $heroes[mt_rand(0, count($heroes) - 1)];

if(isset($_GET['filters'])){
    $filters = explode(',', $_GET['filters']);
    
    foreach($filters as $filter){
        if(isset($filterList[$filter])){
            $hero = $filterList[$filter]($hero);
        }
    }
}

header('Content-Type: application/json');
die(json_encode($hero));
