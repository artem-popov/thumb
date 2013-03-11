<?php

include_once '../src/thumb/Thumb.php';

$width = 100;

$jpg = new \thumb\Thumb("../fixtures/dog.jpg");
$png = new \thumb\Thumb("../fixtures/dog.png");
$gif = new \thumb\Thumb("../fixtures/dog.gif");
$jpg->create($width, __DIR__ . "/../fixtures/results");
// $png->create($width, __DIR__ . "/../fixtures/results");
$gif->create($width, __DIR__ . "/../fixtures/results");