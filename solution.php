<?php

include_once "autoload.php";


use Classes\PersonalIdentifier;
use Classes\UnitedStatesValidator;

array_shift($argv);
if (count($argv) == 0) {
    $argv = "php://stdin";
}

$usa_validator = new UnitedStatesValidator();
$identifier = new PersonalIdentifier($usa_validator);

$handle = fopen($argv[0], 'r');
while(($lineData = fgetcsv($handle)) !== FALSE)
{
    if($lineData[0] !== NULL)
    {
        $identifier->process($lineData);
    }
}

fclose($handle);

if (count($identifier->getEntries())) {
    echo $identifier->getResults();
}