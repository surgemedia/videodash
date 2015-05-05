<?php 
/*=========================================
=            Pretty Meta Debug            =
=========================================*/
function debug($data) {
//makes debuging easier with clear values
    echo '<pre>';
    print_r($data); 
    echo '</pre>';
}