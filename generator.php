<?php

require_once('vendor/autoload.php');

$subclassJson = file_get_contents('subclasses.json');

$subclassList = json_decode($subclassJson);
var_dump($subclassList);

$fullList = array();
foreach($subclassList as $subClass) {
    $filmsRaw = searchBy('P31', $subClass->id);
    
    if ($filmsRaw === null) {
        continue;
    }
    
    $films = array();
    foreach ($filmsRaw as $filmRaw) {
        if ($filmRaw->id == $filmRaw->label) {
            continue;
        }
        
        $films[] = array('id' => $filmRaw->id,
        'label' => $filmRaw->label);
    }
    
    $fullList = array_merge($fullList, $films);
}

$json = json_encode($fullList, JSON_PRETTY_PRINT);

file_put_contents('fullList.json', $json);
