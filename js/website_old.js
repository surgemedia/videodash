/*====================================
=            GLOBAL INITS            =
====================================*/
 new WOW().init();
/*================================
=    Buttons (Client View)        =
================================*/
$(document).ready(function($) {
	

$('#required_button').click(function() {
	$('#videos div.actions').addClass('popup');
	$('#videos #changes_required').addClass('popup');
});


function get_video(input,iframe){
  $(input).focusout(function() {
   var val = $(input).val();
	$(iframe).attr("src","http://player.vimeo.com/video/"+val);
});
}

});
/*====================================
=            Expand Video            =
====================================*/
function expandCard(element){
	
		if(! element.hasClass('open_card')){
			$('li').removeClass('open_card');
			$(element).addClass('open_card');
			$('#overlay_wrapper').addClass('show');
			$('#videos').focus();
		} else {
			// $('li').removeClass('open_card');
			// $('#overlay_wrapper').removeClass('show');
		}
	
}
function closeAllCards(){
	$('li').removeClass('open_card');
	$('#overlay_wrapper').removeClass('show');
}
function DisableScroll(id){
$(id).hover(function() {
    $(document).bind('mousewheel DOMMouseScroll',function(){ 
        stopWheel(); 
    });
}, function() {
    $(document).unbind('mousewheel DOMMouseScroll');
});


function stopWheel(e){
    if(!e){ /* IE7, IE8, Chrome, Safari */ 
        e = window.event; 
    }
    if(e.preventDefault) { /* Chrome, Safari, Firefox */ 
        e.preventDefault(); 
    } 
    e.returnValue = false; /* IE7, IE8 */
}
}
DisableScroll('#videos .pasttimestamps');

function NewTimelineComment(){
  var output;
  var comments = $('li');
  var i = comments.length;
  var li_open = ' <li id="notes_comment_'+i+'">';
  var start = '<input name="time_start_'+i+'" value="0:00">';
  var end = '<input value="0:00" name="time_end_'+i+'" >';
  var textarea = '<textarea placeholder="Please provide a details change for this section of time" name="feedback_'+i+'" cols="30" rows="5"></textarea>';
  var select = '<select name="type_of_'+i+'" id="type_of_'+i+'"><option>changes to video</option><option>changes to audio</option><option>Other</option></select>';
  output = li_open+'<div class="timestamping"><h2 class="timestamp_details">Timestamp of Change:</h2><span class="timeline_picker"><label for="start">Start</label>'+start+'</span><span class="timeline_picker end"><label for="start">End</label>'+end+'</span> <div class="small_spacer"></div><h2 class="change_type">Type of Change Required:</h2>'+select+'</div>'+textarea+'</li>';
  $(output).appendTo('#time-comments');
}
