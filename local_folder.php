<?php

$LOCAL_FOLDER = !strpos($_SERVER['HTTP_HOST'], 'localhost') ?
    __DIR__.'\\gallos_fotos\\' 
    : "https:\\".$_SERVER['HTTP_HOST']."\\wp-content\\themes\\twentytwentythree\\gallos_fotos\\";


$ONLINE_PATH = strpos($_SERVER['HTTP_HOST'], 'localhost') ? 
'https://'.$_SERVER['HTTP_HOST'].'/'
: 'http://'.$_SERVER['HTTP_HOST'].'/wordpress/wp-content/themes/twentytwentythree/gallos_fotos/';