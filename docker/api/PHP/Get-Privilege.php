<?php

require 'CheckUser.php';
header('Content-Type: application/json');
#$files = scandir("../admin");
$results = new stdClass();


//$user = strtolower($_SERVER['AUTH_USER']);
$user = strtolower(GetCurrentUser(GetGraphToken()));

if(strpos($user, '@') !== false)
{
    //$user = strtolower(GetCurrentUser());
}

chdir('../');
$Directories = array_filter(glob('*'), 'is_dir');


$response = new StdClass();
$ArrayItems = array();

$DirectoriesExlude = array("PHP","css","js","fontawsome","bootstrap-icons", "api");




foreach ($Directories as $Dirkey => $Dirvalue) {

    if(in_array($Dirvalue, $DirectoriesExlude)) {

        continue;
    }
    $accessValues = new StdClass();
    $accessValues->Folder = $Dirvalue;
    
    $isMember = true;
    
    $accessValues->isMember = $isMember;
    array_push($ArrayItems, $accessValues);
    
}

    echo json_encode($ArrayItems, JSON_PRETTY_PRINT);


?>