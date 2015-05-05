<?php
function checkuser(){
    $url = 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
    $purl = parse_url($url)['query'];
    echo $purl;
    $allow;
    $extra_allow;
    $visitor = urldecode(explode('&user=',$purl)[1]) ;
    $video_post = get_post_meta(get_the_id())['client'][0];
    $client_post = get_post_meta($video_post);
    if($visitor == $client_post['primary_email']){$allow = true;} else {
      if(strpos($client_post['extra_emails']) > -1) {
        $extra_allow = true;
      } else {
        $extra_allow = false;
      }

    };

    return $allow;
    //$post_user = $video_post[]
}
