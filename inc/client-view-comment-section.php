<div id="changes_required">
    <label class="title label_stop_float" for="" id="Feedbackarea">Your Feedback</label>
 
    <?php
     if(strlen(implode(" ",$current_draft_comments_column))>0 or strlen($last_video_a_request_row['voice_comment'])) {
    ?>
    <p>Thank you for submitting your comments on the current draft. We will notify you when the next draft is uploaded.</p>
    <?php
        }
           else {
    ?>
       <!-- <p class=" label_stop_float" for="">Overall Comments</p> -->
        <span>Let us know your thoughs on the video as a whole. (Eg: music, sound effects, shot used, etc)</span>
    <ul id="comments-general" class="container">
        <li>
            <textarea name="voice_comment" id="general-comment" class="sixteen columns" cols="30" rows="10" placeholder="Your Feedback"><?php
            echo $last_video_a_request_row['voice_comment']; ?></textarea>
        </li>
    </ul>
<div id="timeline_comments_section">
    <div class="timeline-title">
        <p>Timecode</p>
        <span>Please use the timestamp on the video to indicate at what point you would like changes</span>
    </div>
    <div class="timeline-comments-title">
         <p>Comments</p>
        <span>Please use the box below to add your comments corresponding with the timecode entered on the left.</span>
    </div>
    <div style="clear: both;"></div>
    <ul id="time-comments">
        <script>NewTimelineComment();</script>
        <script>NewTimelineComment();</script>
        <script>NewTimelineComment();</script>

    </ul>
    <div class="submit-actions">
        <a href="javascript:void(0)" onClick="NewTimelineComment()" class="btn blue columns alpha"><span>Add More Comments</span><i class="fa fa-plus"></i></a>
        <a class="btn yellow columns alpha" href="#" id="first_submit_step"><span>Submit All Comments</span><i class="fa fa-check"></i></a>
    </div>
    <?php
                }
    ?>
</div>
</div>