<?php
require_once 'vendor/autoload.php';

try {
    $hitBeeObj = new App\Classes\HitBee();
    $pointsObj = new App\Classes\Points();
    
    // Load the instance of the hive
    $hive = new App\Classes\Hive($hitBeeObj, $pointsObj);
    $hive->addBee(App\Factory\BeeFactory::make('Queen', 100, 8, 5, true, 1));
    $hive->addBee(App\Factory\BeeFactory::make('Worker', 75, 10, 3, false, 5));
    $hive->addBee(App\Factory\BeeFactory::make('Drone', 50, 12, 4, false, 8));
    $hive->calcBeePoints();
    
    // Load the application instance
    $app = new App\Classes\Application($hive, null);
    $app->echoGameIntro();
    return $app->run();

} catch (\Exception $e) {
    print $e->getMessage();
}