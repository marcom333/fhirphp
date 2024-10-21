<?php
require_once 'vendor/autoload.php';

use App\Fhir\Resource\Bundle;


$bundle = new Bundle();

if(!$bundle->validate()){
    echo "Failed has expected\n";
}
$bundle->resourceType = "potato";
if(!$bundle->validate()){
    echo "Failed has expected\n";
}
$bundle->id = "";
if(!$bundle->validate()){
    echo "Failed has expected\n";
}
$bundle->type = "none";
if(!$bundle->validate()){
    echo "Failed has expected\n";
}

$bundle->resourceType = "Bundle";
$bundle->id = hash("md5", "testing");
$bundle->type = "history";

if($bundle->validate()){
    echo "Working has Expected\n";
}