<?php

function cleanYoutubeLink($link){
	parse_str( parse_url( $link, PHP_URL_QUERY ), $my_array_of_vars );
	return $my_array_of_vars['v'];
}

?>