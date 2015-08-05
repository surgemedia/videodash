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

$(".cloasesubmit").click(function(){
    $("#request_confirm_form").addClass("disable_input");
    $("#request_confirm_form").removeClass("display_input");
});

$('#first_submit_step').click(function(){
    var commentsAvailable = "";
    $('#changes_required').find('textarea').each(function(){
      var comment = $(this).val();
      if (comment.length>0) {
        commentsAvailable = 1;
      }
    });
    if(commentsAvailable==1) {
      $("#request_confirm_form").removeClass("disable_input");
      $("#request_confirm_form").addClass("display_input");
    }
    else {
      alert('Please enter the comments to submit');
      $('html, body').animate({
          scrollTop: $("#Feedbackarea").offset().top
      }, 500);
    }
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
      // $('#brandusb').removeClass("disable_input");
      // $('#brandusb').addClass("display_input");
      // $('#plainusb').removeClass("display_input");
      // $('#plainusb').addClass("disable_input");
      // $('#brandusb_btn').removeClass("disable_input");
      // $('#brandusb_btn').addClass("display_input");
      // $('#plainusb_btn').removeClass("display_input");
      // $('#plainusb_btn').addClass("disable_input");
    }else{
      // $('#plainusb').removeClass("disable_input");
      // $('#plainusb').addClass("display_input");
      // $('#brandusb').removeClass("display_input");
      // $('#brandusb').addClass("disable_input");
      // $('#plainusb_btn').removeClass("disable_input");
      // $('#plainusb_btn').addClass("display_input");
      // $('#brandusb_btn').removeClass("display_input");
      // $('#brandusb_btn').addClass("disable_input");
    }
});

/*====================================
=            Smooth Scroll            =
====================================*/
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

/*====================================
=  Marketing form validation         =
====================================*/
function validationCheck() {
  var validationStatus = 0,
      element = "",
      isNoThanks = "";
      $('.required').each(function(){
        $(this).removeClass('warning');
        var checked = $(this).find('input:checked').length;
        if(checked>0) {
          validationStatus = 1;
          isNoThanks = $(this).find('input:checked').closest('li').text().indexOf('No Thanks.');
          $(this).find('input:checked').closest('li').find('select').each(function(){
              if($(this).val() != "" ) {
                validationStatus = 1;
              }
              else {
                validationStatus = 0;
                element = $(this);
                return false;
              }
          });
          if(validationStatus==0 && element != "") {
            return false;
          }
        }
        else {
          validationStatus = 0;
          element = $(this);
          return false;
        }
        // console.log("validationStatus is "+checked);
      });
       // console.log("value f element"+element);
       return [validationStatus,element,isNoThanks]
}
function MarketingFormValidation(){
    var validateReturn = validationCheck();
    var validationStatus = validateReturn[0],
        element = validateReturn[1],
        isNoThanks = validateReturn[2]
       if (validationStatus>0 && isNoThanks<0) {
         document.getElementById('addition_request_form').submit();
       }
       else {
         if(element=="") {
           $('.btn.green.shake').css('display','inline-block');
           $('.btn.green.shake').css('visibility','visible');
           $('.pre-download-text').hide();
           $('html, body').animate({
                scrollTop: $('.btn.green.shake').offset().top - 10
           }, 500);
         }
         else {
           element.closest('ul.required').addClass('warning');
           $('html, body').animate({
                scrollTop: element.offset().top - 200
           }, 500);
         }
         // if (isNoThanks>=0) {
         //       $('.btn.blue.newline').hide();
         //    }
         //    else {
         //       $('.btn.blue.newline').show();
         // }
       }

  // document.getElementById('addition_request_form').submit();

}
$(document).ready(function(){

  $('.required input,select').each(function(){
    $(this).change(function(){
        var validateReturn = validationCheck();
        var validationStatus = validateReturn[0],
        element = validateReturn[1],
        isNoThanks = validateReturn[2]
       if (validationStatus>0 && isNoThanks<0) {
         // document.getElementById('addition_request_form').submit();
       }
       else {
         if(element=="") {
           $('.btn.green.shake').addClass('show-inline');
           $('.btn.green.shake').css('visibility','visible');
           $('.pre-download-text').hide();
           $('html, body').animate({
                scrollTop: $('.btn.green.shake').offset().top - 10
           }, 500);
         }
         else {
           element.closest('ul.required').addClass('warning');
           $('html, body').animate({
                scrollTop: element.offset().top - 200
           }, 500);
         }
         // if (isNoThanks>=0) {
         //       $('.btn.blue.newline').hide();
         //    }
         //    else {
         //       $('.btn.blue.newline').show();
         // }
       }
            
    });
  });
});
  