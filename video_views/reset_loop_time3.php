<?php
    header("content-type: text/javascript");

        $obj->name = $_GET['name'];
        $obj->message = "HI " . $obj->name;

        echo $_GET['callback']. '(' . json_encode($obj) . ');';
?>