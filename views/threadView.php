<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="js/utility.js"></script>
<div class="right">
    <a href="readers.html?threadid=<?php echo $raw_data['threadid']; ?>">Readers</a>
    <a href="threads.php?topicid=<?php echo $raw_data['topicid']; ?>">Takaisin</a>
</div>
        
<div class="left-margin">
    <h1>Messages</h1>
    

        <?php foreach ($raw_data['posts'] as $p) { ?>
        <div class='panel panel-default'>
            <div class='panel-body'>
                <a id="<?php echo $p['postdata']->getPostID() ?>"></a>
                <div>
                    <p>
                        <b><a href="private_message.php?userid=<?php echo $p['postdata']->getPosterID() ?>"><?php echo $p['postdata']->getPosterName(); ?></a></b>
                        Posted on <?php echo $p['postdata']->getPostDate(); ?>
                    </p>
                    <!-- quote -->
                    <?php if (!empty($p['quote'])) { ?>
                    <p class="alert-info">
                        <a href="#<?php echo $p['quote']->getPostID(); ?>"><b>Quoting <?php echo $p['quote']->getPosterName()?></b><br><?php echo $p['quote']->getPostText(); ?></a>
                    </p>
                    <?php } ?>
                    <!-- message -->
                    <p><?php echo $p['postdata']->getPostText(); ?></p>
                    <!-- buttons -->
                    <div class="right">
                    <?php if (!empty($p['showdelete'])) { ?>
                        <button type="button" onclick="confirm_delete(<?php echo $p['postdata']->getPostID()?>)"  class="btn btn-default">Delete</button>

                    <?php } if (!empty($p['showedit'])) { ?>
                        <button type="button" onclick="openWindow('edit.php?postid=<?php echo $p['postdata']->getPostID() ?>')" class="btn btn-default">Edit</button>

                    <?php } if (!empty($p['showreply'])) { ?>
                        <button type="button" onclick="openWindow('quote.php?postid=<?php echo $p['postdata']->getPostID()?>&threadid=<?php echo $raw_data['threadid']; ?>&topicid=<?php echo $raw_data['topicid']; ?>')" class="btn btn-default">Quote</button>
                        <?php } ?>
                    </div>
                </div>    
            </div>    
        </div>
                
        <?php }?>
  
        <?php if (isLoggedIn()) { ?>
        <div class ="right">
                <button type="button" onclick="openWindow('reply.php?threadid=<?php echo $raw_data['threadid']; ?>&topicid=<?php echo $raw_data['topicid']; ?>')" class="btn btn-default">Reply</button>
                <br><br>
        </div>
        <?php } ?>

    