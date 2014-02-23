<?php 
    $thread_topic_url_raw = "?threadid=" . $raw_data['threadid'] . "&topicid=" . $raw_data['topicid']
         . "&page="; 
    $thread_topic_url =  $thread_topic_url_raw . $raw_data['page'];
?>
<div class="right">
    <?php if ($raw_data['showThreadLinks']) { ?>
    <a href="readers.php<?php echo $thread_topic_url; ?>">Readers</a>
    <?php } ?>
</div>
        
<div class="left-margin">
    <?php if ($raw_data['showThreadLinks']) { ?>
    <h3><a href="threads.php?topicid=<?php echo $raw_data['topicid']; ?>">Back to topic</a></h3>
    <?php } ?>
    
    <h1><?php echo $raw_data['title'];?></h1>
    
        <?php if (empty($raw_data['posts'])) {
            echo "No messages";
        } ?>
        <?php foreach ($raw_data['posts'] as $p) { 
            $postid = $p['postdata']->getPostID();
            $posterid = $p['postdata']->getPosterID();
            $postername = $p['postdata']->getPosterName();
            $thread_topic_post_url = $thread_topic_url . "&postid=" . $p['postdata']->getPostID();
            $thread_topic_poster_url = $thread_topic_url . "&userid=" . $posterid;
            
            ?>
        <div class='panel panel-default'>
            <div class='panel-body'>
                <a id="<?php echo $p['postdata']->getPostID() ?>"></a>
                <div>
                    <p>
                        <b><?php if (!empty($raw_data['showPrivateUrl']) && getUser()->getID() !== $posterid) { 
                                // only show link if user is logged in
                                echo '<a href="private_message.php';    
                                if ($raw_data['privateMessageRedirect']) {
                                    echo "?userid=" . $posterid . "&redirect=privatemessagelist";
                                } else {
                                    echo $thread_topic_poster_url . "&redirect=thread"; 
                                }
                                echo '" >';
                            }
                            echo $postername; 
                            if (!empty($raw_data['showPrivateUrl']) && getUser()->getID() !== $posterid) { 
                                echo '</a>';
                            } ?>
                            </b>
                        Posted on <?php echo $p['postdata']->getPostDate(); ?>
                    </p>
                    <!-- quote -->
                    <?php if (!empty($p['quote'])) { ?>
                    <p class="alert-info">
                        <a href="thread.php?threadid=<?php echo $raw_data['threadid']?>&topicid=<?php echo $raw_data['topicid']?>&postid=<?php echo $p['quote']->getPostID(); ?>"><b>Quoting <?php echo $p['quote']->getPosterName()?></b><br><?php echo $p['quote']->getFormattedPostText(); ?></a>
                    </p>
                    <?php } ?>
                    <!-- message -->
                    <p><?php echo $p['postdata']->getFormattedPostText(); ?></p>
                    <!-- buttons -->
                    <div class="right">
                    <?php if (!empty($p['showdelete'])) { ?>
                        <button type="button" onclick="confirm_post_delete(<?php echo $postid ?>)"  class="btn btn-default">Delete</button>

                    <?php } if (!empty($p['showedit'])) { ?>
                        <button type="button" onclick="openWindow('edit.php<?php echo $thread_topic_post_url; ?>')" class="btn btn-default">Edit</button>

                    <?php } if (!empty($p['showquote'])) { ?>
                        <button type="button" onclick="openWindow('quote.php<?php echo $thread_topic_post_url ?>')" class="btn btn-default">Quote</button>
                        <?php } ?>
                    </div>
                </div>    
            </div>    
        </div>
                
        <?php }?>
  
        <?php if (!empty($raw_data['showreply'])) { ?>
        <div class ="right">
            <div>
                <button type="button" onclick="openWindow('reply.php<?php echo $thread_topic_url; ?>')" class="btn btn-default">Reply</button>
                <br><br>
            </div>
        <?php } ?>
            <div>
            <?php
            if ($raw_data['page'] > 1) { ?>
                <a href="<?php echo $thread_topic_url_raw . ($raw_data['page'] - 1)?>">Previous page</a>
            <?php   } 
            if ($raw_data['page'] < $raw_data['pages']) { ?>
                <a href="<?php echo $thread_topic_url_raw . ($raw_data['page'] + 1)?>">Next page</a>
            <?php   } ?>   
            </div>
        </div>
