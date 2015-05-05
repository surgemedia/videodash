
					<?php
					acf_form(array(
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'comment',
						'post_status'		=> 'publish'
					),
					'submit_value'		=> 'Make a Comment'
				));
				?>
