<?php

$dictionary = file_get_contents("https://api.dictionaryapi.dev/api/v2/entries/en/Hello");
$json = json_decode($dictionary, TRUE);

$definition = $json[0]["meanings"][1]["definitions"][0]["definition"];

$definition = str_ireplace("hello"," ",$definition);
echo $definition;

?>