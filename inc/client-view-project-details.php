<h1 class="">My Dashboard</h1>
                <div id="preproduction" class="container">
                    <?php
                    //Add container css class to make data display correctly
                    ?>
                    <h2>Video Project Details</h2>
                    <ul>
                        <li class="section contact five columns omega">
                            <?php
                            //Make contact data field in left side
                            ?>
                            <input value="<?php
                            echo $end_time; ?>" id="video_end_time" type="hidden">
                            <span class="small_title">Project name</span>
                            <input value="<?php
                            echo $cca_row['company_name']; ?> - <?php
                            echo $projectname_row['project_name'] ?>" disabled>
                            <?php
                            /*=======================================*/
                            /*       Change Content Details          */
                            /*=======================================*/
                            ?>
                            <span class="small_title">Contact Info</span>
                            <form action="#" method="post">
                                <input value="<?php echo $client_id; ?>" name="client_id" type="hidden">
                                <input value="<?php echo $project_id; ?>" name="project_id" type="hidden">
                                <input placeholder="Name" name="company_name" value="<?php
                                echo $cca_row['company_name']; ?>"/>
                                <input placeholder="contact name" name="contact_person" value="<?php
                                echo $cca_row['contact_person']; ?>"/>
                                <input placeholder="Phone" name="mobile_number" value="<?php
                                echo $cca_row['mobile_number']; ?>"/>
                                <input placeholder="Email" name="email" value="<?php
                                echo $cca_row['email']; ?>"/>
                                <textarea placeholder="Secondary Email (separated by comma)" name="cc_email" value=""></textarea>
                                <input class="btn yellow"  type="submit" value="Change Contact Details"/>
                            </form>
                        </li>
                        <li class="section ten columns omega alpha">
                            <?php
                            //Make introduction field in right side
                            ?>

                            <p>At Surge Media we like to make your video project experience as smooth as possible by giving you a clear overview of where we are at with your project and giving you an easy way to supply feedback and track changes.
                            </p>
                            <p>As part of your project you will receive two sets of changes before we render out the final version so it is important to make sure that you use the feedback system to your advantage.
                            </p>
                            <?php if (!$downloadfile_message) { ?>
                            <!-- <p><strong>VIDEO PROJECT FIRST DRAFT - (3 WEEKS) </strong> Provide us with a complete list of ALL requested changes. Use the video timestamp to make sure that our editors know where the changes need to be applied. -->
                            </p>
                            <!-- <p><strong>VIDEO PROJECT SECOND DRAFT - (3 WEEKS)</strong> This stage is mostly used to finetune the video before we present you with the final version. -->
                            </p>
                            <!-- <p><strong>VIDEO PROJECT FINAL</strong> - This is the final version of your project which will be available for you to download. Please note that if you still want to make additional changes, charges may apply. -->
                            </p>
                            <a class="btn blue eight  columns alpha"  href="#youtube_video_div">Preview Video</a>
                            <a class="btn green eight columns " href="#Feedbackarea">Create Feedback</a>

                            <?php } ?>

                        </li>
                    </ul>
                </div>