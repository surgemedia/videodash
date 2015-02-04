<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>My Dashboard</title>
        <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
                <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">
                <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js">
                <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.0/animate.min.css">
                <link rel="stylesheet" href="/css/layout.css">
                <link rel="stylesheet" href="/css/skeleton.css">
                <link rel="stylesheet" href="/css/style.css">
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <script type="text/javascript" src="/js/jquery.backgroundvideo.min.js"></script>
                <script type="text/javascript" src="/js/wow.min.js"></script>
                <script type="text/javascript" src="/js/website.js"></script>
            </head>
            <body class="">
                <header>
                    <div class="center wow fadeInDown">
                        <div class="logo"><img src="" alt=""></div>
                        <nav>
                            <ul class="nav">
                                <li><a href="/home_video.html">Home</a></li>
                                <li><a href="/home_video.html">Clients</a></li>
                                <li><a href="/home_video.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </header>
                <main>
                <section class="center">
                    <h1 class="">My Dashboard</h1>
                    <div id="preproduction">
                        <h2>Preproduction</h2>
                        <ul>
                            <li class="section">
                                <div>
                                    <span>Page Content</span>
                                    <ul>
                                        <li><span>PDF/Word</span><input type="file"></li>
                                    
                                    </ul>
                                </div>
                                <div>
                                    <span>Logos and Images</span>
                                    <ul>
                                        <li><span>Images</span><input type="file"></li>
                                        <li><span>Logo (EPS,AI)</span><input type="file"></li>
                                    </ul>
                                </div>
                            </li>
                        
                            <li class="section contact">
                                <span>Contact Info</span>
                                <input type="text">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                            </li>
                        </ul>
                    </div>
               






                    <h1 class="">Project Timeline</h1>
                    <div  id="preproduction">
                    
                        <?php
$checklists = file_get_contents('https://api.trello.com/1/boards/PIpXt5Kz/checklists?key=358f7cdd91bf13e75d6d417179393a4b&token=0a0d6dceed73313300b84455202dcff10bac92afc69cbe8a2a907d7e26b8368b');
$checklists_json = json_decode($checklists, true);
$cards = file_get_contents("https://api.trello.com/1/boards/PIpXt5Kz/cards?key=358f7cdd91bf13e75d6d417179393a4b&token=0a0d6dceed73313300b84455202dcff10bac92afc69cbe8a2a907d7e26b8368b");
$cards_json = json_decode($cards, true);
$current_url = $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
$current_card_url = split('=', $current_url);
$current_card = $current_card_url[1];
$checklist_id = array();
foreach ($cards_json as $key => $value) {
    if ($value[shortLink] == $current_card) {
        echo "<div class='card'>";
        echo "<p>" . $value[name] . "</p>";
        //echo "<p>" . $value[shortLink] . "</p>";
        $id_list = $value[idChecklists];
        foreach ($id_list as $id_key => $id_value) {
            array_push($checklist_id,$id_value);
        }
        get_checklist($checklist_id[0], $checklists_json, $current_card);
        get_checklist($checklist_id[1], $checklists_json, $current_card);
        get_checklist($checklist_id[2], $checklists_json, $current_card);
        get_checklist($checklist_id[3], $checklists_json, $current_card);
        get_checklist($checklist_id[4], $checklists_json, $current_card);
        get_checklist($checklist_id[5], $checklists_json, $current_card);
        get_checklist($checklist_id[6], $checklists_json, $current_card);
        get_checklist($checklist_id[7], $checklists_json, $current_card);
        get_checklist($checklist_id[8], $checklists_json, $current_card);
        get_checklist($checklist_id[9], $checklists_json, $current_card);
       


        echo '</div>';
    }
}

function get_checklist($checklist_postion, $json, $card_name) {
    $checklist = array();
    foreach ($json as $key => $value) {
    if($value[id] == $checklist_postion){
    if($value[name] != "ADMIN ACTIONS"){
        $checklist = $value[checkItems];
        echo  '<strong>'.$value[name]."</strong>";
    } 
    }
    }
    foreach ($checklist as $items => $item_value) {
            echo "<p>" . $item_value[name] . " " . $item_value[state] . "</p>";
    }

}



?>
</div>
                </section>
                </main>
                <footer>
                    <div class="logo"><img src="" alt=""></div>
                    <nav>
                        <ul class="nav">
                            <li>
                                <a href="#"></a>
                                <a href="#"></a>
                                <a href="#"></a>
                                <a href="#"></a>
                                <a href="#"></a>
                            </li>
                        </ul>
                    </nav>
                </footer>
            </body>
        </html>