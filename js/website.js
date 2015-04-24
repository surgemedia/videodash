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
  $('#changes_required').addClass('popup');
});

$("#cloasesubmit").click(function(){
    $("#request_confirm_form").addClass("disable_input");
    $("#request_confirm_form").removeClass("display_input");
});
$('#first_submit_step').click(function(){
    $("#request_confirm_form").removeClass("disable_input");
    $("#request_confirm_form").addClass("display_input");
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
  var li_open = ' <li id="notes_comment_'+i+'" class="container">';
  var start = '<input name="time_start_'+i+'" value="0:00">';
  var end = '<input name="time_end_'+i+'" value="'+$('#video_end_time').val()+'">';
  var selectoption = '<select name="comment_option_'+i+'" class="five columns">';
  selectoption += '<option value="1">Changes To Video</option>';
  selectoption += '<option value="2">Changes To Audio</option>';
  selectoption += '<option value="3">Other</option>';
  selectoption += '<select>';
  var textarea = '<textarea name="feedback_'+i+'" cols="30" rows="5" class="fourteen columns" placeholder="Your comments"></textarea>';
  output = li_open+'<div class="controls"><span class="timeline_picker "><label for="start">Start</label>'+start+'</span><span class="timeline_picker end "><label for="start">End</label>'+end+'</span>'+selectoption+'</div>'+textarea+'</li>';
  $(output).appendTo('#time-comments');
}
$(document).on('change', 'input[name="usb_option"]', function(){
    var get_usb = $(this).val();
    if(get_usb == 1){
      $('#brandusb').removeClass("disable_input");
      $('#brandusb').addClass("display_input");
      $('#plainusb').removeClass("display_input");
      $('#plainusb').addClass("disable_input");
      $('#brandusb_btn').removeClass("disable_input");
      $('#brandusb_btn').addClass("display_input");
      $('#plainusb_btn').removeClass("display_input");
      $('#plainusb_btn').addClass("disable_input");
    }else{
      $('#plainusb').removeClass("disable_input");
      $('#plainusb').addClass("display_input");
      $('#brandusb').removeClass("display_input");
      $('#brandusb').addClass("disable_input");
      $('#plainusb_btn').removeClass("disable_input");
      $('#plainusb_btn').addClass("display_input");
      $('#brandusb_btn').removeClass("display_input");
      $('#brandusb_btn').addClass("disable_input");
    }
});
 