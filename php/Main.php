<?php

require_once("SpiderSintegra.php");

$spider = new SpiderSintegra();

$json = $spider->search('31.804.115-0002-43');

echo $json;
