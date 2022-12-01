<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
    ->withServiceAccount('barangay-santol-qc-firebase-adminsdk-a8dep-b1b47aef25.json')
    ->withDatabaseUri('https://barangay-santol-qc-default-rtdb.asia-southeast1.firebasedatabase.app/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();
?>