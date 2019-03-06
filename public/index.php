<?php
system("stty -icanon");

// This makes our life easier when dealing with paths. Everything is relative
// to the application root now.
chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

system("stty sane");