<?php  ?>



<?php get_template_part('templates/content-single', get_post_type()); ?>
<?php debug(get_post_meta(get_the_id())); ?>
<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
      <?php
      $video_post = get_post_meta(get_the_id());
      $video = $video_post['video_drafts_0_video'];
      $directors_notes = $video_post['video_drafts_0_directors_notes'];
      $type =  $video_post['video_drafts_0_video_type'];
			$num_video =  $video_post['video_drafts'][0] ;
			$the_id =  explode('v=',$video[0])[1];
      ?>

       <ul>
       	<li><?php echo $video[0]; ?></li>
       	<li><?php echo $directors_notes[0]; ?></li>
       	<li><?php echo $type[0]; ?></li>
       	<li><?php echo $num_video ?></li>
				<li><?php echo $the_id; ?></li>
				<li><?php echo $the_id; ?></li>

				<li><?php // WP_Query arguments
				// $the_id = get_the_id();
				$args = array (
					'post_type'              => 'comment',
					'meta_query'             => array(
						array(
							'key'       => 'video_id',
							'value'     => $the_id,
						),
					),
				);

				// The Query
				$query_comments = new WP_Query( $args );

				// The Loop
				if ( $query_comments->have_posts() ) {
					while ( $query_comments->have_posts() ) {
						$query_comments->the_post();
						$comment = get_post_meta(get_the_id());




						//debug(get_post_meta(get_the_id()));
					}
				} else {
					// no posts found
				}

				// Restore original Post Data
				wp_reset_postdata();
				 ?></li>
       </ul>
			<?php var_dump(checkuser()); ?>
      <div id="primary" class="content-area">

  		<div id="content" class="site-content" role="main">

				<?php //get_template_part('templates/timeline-comment','form' ?>




  		</div><!-- #content -->
  	</div><!-- #primary -->
