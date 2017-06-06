<?php

$heroesFile = file_get_contents('heroes.json');
$heroes = json_decode($heroesFile);

header('Content-Type: application/json');
die(json_encode($heroes[mt_rand(0, count($heroes) - 1)]));
