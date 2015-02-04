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
     
<?php
$checklists = file_get_contents('https://api.trello.com/1/boards/PIpXt5Kz/checklists?key=358f7cdd91bf13e75d6d417179393a4b&token=0a0d6dceed73313300b84455202dcff10bac92afc69cbe8a2a907d7e26b8368b');
$checklists_json = json_decode($checklists, true);
$cards = file_get_contents("https://api.trello.com/1/boards/PIpXt5Kz/cards?key=358f7cdd91bf13e75d6d417179393a4b&token=0a0d6dceed73313300b84455202dcff10bac92afc69cbe8a2a907d7e26b8368b");
$cards_json = json_decode($cards, true);
$current_url = $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
$current_card_url = split('=', $current_url);
$current_card = $current_card_url[1];
$checklist_id = array();
$number_limt = 100;
$stage_completed = array('0','1','2');
$complete_count = 0;

foreach ($cards_json as $key => $value) {
    if ($value[shortLink] == $current_card) {
        $id_list = $value[idChecklists];
        foreach ($id_list as $id_key => $id_value) {
            array_push($checklist_id, $id_value);
        }
    }
}

function get_checklist($stage, $json, $card_name, $number_limt, $checklist_id) {
    $checklist_master = $checklist_id;
    $checklist = array();
    
    $final_html;
    foreach ($json as $key => $value) {
        $id_check = $value[id];
        
        if (in_array($id_check, $checklist_master)) {
            
            if (strpos($value[name], '#') !== false) {
               $check = explode("#",$value[name]);
               
                //print_r($check);
                if ($check[1] == $stage) {
                    $checklist = $value[checkItems];
                }
            }
        }
    }
    foreach ($checklist as $items => $item_value) {
            if($item_value[state] == "complete"){
                $complete_count++;
            }

            if($complete_count == sizeof($checklist)){
                $stage_class = "stage_".$stage;
                array_push($stage_completed, $stage_class);
        
            }
            echo $stage_completed[0];
            echo "<li class='".$item_value[state]."'>" . $item_value[name] ."</li>";
            }
        
    }
?>





                    <h1 class="">Project Timeline</h1>
                    <div id="timeline">
                        <div id="warning_bucket">
                            <span><!-- Issuess go here --></span>
                        </div>
                        
                            

                        <div id="clientbar"  class="stage_1 timeline">
                            
                            <i class="fa fa-folder-open"></i>
                            <i class="fa fa-thumbs-o-up"></i>
                            <i class="fa fa-star-half-full"></i>
                           <i class="fa fa-rocket"></i>
                           <i class="fa fa-credit-card"></i>
                        <span class="unload"></span>
                         <div class="popup">
                         <h3>Your Checklist</h3>
                         <i class="tri"></i>
                           <ul>
                            <?php
    
    //$client_list = get_checklist($checklist_id[6], $checklists_json, $current_card,3);
    
    // Client Action
    
?>
                            </ul>
                           
                        </div>
                        </div>
                    
                        <div id="surgebar" class="stage_1 timeline">
                            <i class="fa fa-paper-plane"></i>
                             <i class="fa fa-code"></i>
                              <i class="fa fa-star-half-full"></i>
                              <i class="fa fa-bug"></i>
                               <i class="fa fa-rocket"></i>
                    <span class="unload"></span>
                    <div class="popup">
                    <h3>Surge's Checklist</h3>
                    <i class="tri"></i>
                    <ul>
                    <?php
    get_checklist('1', $checklists_json, $current_card, $number_limt, $checklist_id);
   print_r($stage_completed);


    
    get_checklist('2', $checklists_json, $current_card, $number_limt, $checklist_id);
    get_checklist('3', $checklists_json, $current_card, $number_limt, $checklist_id);

?>
                          </ul>
                    </div>
                    </div>
                    

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