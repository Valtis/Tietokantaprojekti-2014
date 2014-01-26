
<div class="right">
    <a href="readers.html?threadid=<?php echo $raw_data['threadid']; ?>">Readers</a>
    <a href="threads.php?topicid=<?php echo $raw_data['topicid']; ?>">Takaisin</a>
</div>
        
<div class="left-margin">
    <h1>Viestit</h1>
    

        <?php foreach ($raw_data['posts'] as $p) { ?>
        <div class='panel panel-default'>
            <div class='panel-body'>
                <a id="<?php echo $p['postdata']->getPostID() ?>"></a>
                <div>
                    <p><b><a href="private_message.php?userid=<?php echo $p['postdata']->getPosterID() ?>"><?php echo $p['postdata']->getPosterName(); ?></a></b></p>
                    <p><?php echo $p['postdata']->getPostText(); ?></p>
                    <div class="right">
                    <?php if (!empty($p['showdelete'])) { ?>
                        <button type="button" onclick="confirm(1234)"  class="btn btn-default">Delete</button>

                    <?php } if (!empty($p['showedit'])) { ?>
                        <button type="button" onclick="window.open('edit.php?postid=<?php echo $p['postdata']->getPostID() ?>', '_self')" class="btn btn-default">Edit</button>

                    <?php } if (!empty($p['showreply'])) { ?>
                        <button type="button" onclick="window.open('quote.php?postid=<?php echo $p['postdata']->getPostID()?>', '_self')" class="btn btn-default">Quote</button>
                        <?php } ?>
                    </div>
                </div>    
            </div>    
        </div>
                
        <?php }?>
  
        <?php if (isLoggedIn()) { ?>
        <div class ="right">
                <button type="button" onclick="window.open('reply.php?threadid=<?php echo $raw_data['threadid']; ?>', '_self')" class="btn btn-default">Reply</button>
                <br><br>
        </div>
        <?php } ?>

    