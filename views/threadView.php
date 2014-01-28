<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="js/utility.js"></script>
<div class="right">
    <a href="readers.html?threadid=<?php echo $raw_data['threadid']; ?>">Readers</a>
    <a href="threads.php?topicid=<?php echo $raw_data['topicid']; ?>">Takaisin</a>
</div>
        
<div class="left-margin">
    <h1>Messages</h1>
    
        <?php 
            $thread_topic_url = "?threadid=" . $raw_data['threadid'] . "&topicid=" . $raw_data['topicid'];
        ?>

        <?php foreach ($raw_data['posts'] as $p) { 
            $postid = $p['postdata']->getPostID();
            $posterid = $p['postdata']->getPosterID();
            $postername = $p['postdata']->getPosterName();
            $thread_topic_post_url = $thread_topic_url . "&postid=" . $p['postdata']->getPostID();
            
            ?>
        <div class='panel panel-default'>
            <div class='panel-body'>
                <a id="<?php echo $p['postdata']->getPostID() ?>"></a>
                <div>
                    <p>
                        <b><a href="private_message.php?userid=<?php echo $posterid; ?>"><?php echo $postername; ?></a></b>
                        Posted on <?php echo $p['postdata']->getPostDate(); ?>
                    </p>
                    <!-- quote -->
                    <?php if (!empty($p['quote'])) { ?>
                    <p class="alert-info">
                        <a href="#<?php echo $p['quote']->getPostID(); ?>"><b>Quoting <?php echo $p['quote']->getPosterName()?></b><br><?php echo $p['quote']->getFormattedPostText(); ?></a>
                    </p>
                    <?php } ?>
                    <!-- message -->
                    <p><?php echo $p['postdata']->getFormattedPostText(); ?></p>
                    <!-- buttons -->
                    <div class="right">
                    <?php if (!empty($p['showdelete'])) { ?>
                        <button type="button" onclick="confirm_delete(<?php echo $postid ?>)"  class="btn btn-default">Delete</button>

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
                <button type="button" onclick="openWindow('reply.php<?php echo $thread_topic_url; ?>')" class="btn btn-default">Reply</button>
                <br><br>
        </div>
        <?php } ?>

    