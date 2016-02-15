<?php
$show_form = false;
if ($downloadfile_message):
if($downloadfile_message==1) {
//Final Video is ready
?>
<h2 class="sub-title">
    Your final video is ready!
</h2>
<p>
    Before you download your video please have a think about:
</p>
<?php $show_form = true;
//show form when download is ready
?>
<?php  } else {
?>
<h2 class="sub-title">
    Thank you, your video has been approved. Your final video is being processed.
</h2>
<p>
    You will be notified by email once it is ready for download from this page.
</p>
<?php $show_form = false; ?>
<?php } endif; ?>
<?php if ($overdeadline_message): ?>
<?php  if(strlen(implode(" ",$current_draft_comments_column))>
0 or strlen($last_video_a_request_row['voice_comment'])) {
?>
<p>
    Thank you for submitting your comments on the current draft. We will notify you when the next draft is uploaded.
</p>
<?php
}
?>
<?php
endif; ?>
