
<div class="right">
    <a href="readers.html?threadid=<?php echo $raw_data['threadid']; ?>">Readers</a>
    <a href="threads.php?topicid=<?php echo $raw_data['topicid']; ?>">Takaisin</a>
</div>
        
<div class="left-margin">
    <h1>Viestit</h1>
    <div>
        <?php foreach ($raw_data['posts'] as $p) { ?>
        <hr>
        <a id="<?php echo $p['postdata']->getPostID() ?>"></a>
        <div>
            <p><b><a href="private_message.php?userid=<?php echo $p['postdata']->getPosterID() ?>"><?php echo $p['postdata']->getPosterName(); ?></a></b></p>
            <p><?php echo $p['postdata']->getPostText(); ?></p>
            <div class="right">
            <?php if (!empty($p['showdelete'])) { ?>
                <button type="button" onclick="confirm(1234)"  class="btn btn-default">Poista</button>
                
            <?php } if (!empty($p['showedit'])) { ?>
                <button type="button" onclick="window.open('vastaus.html?edit=1&postid=1234', '_self')" class="btn btn-default">Muokkaa</button>
                
            <?php } if (!empty($p['showreply'])) { ?>
                <button type="button" onclick="window.open('quote.php?postid=<?php echo $p['postdata']->getPostID()?>', '_self')" class="btn btn-default">Quote</button>
                <?php } ?>
            </div>
        </div>
                
        <?php }?>
        <hr>
        
        <div class ="right">
                <button type="button" onclick="window.open('reply.html?threadid=<?php echo $raw_data['threadid']; ?>', '_self')" class="btn btn-default">Vastaa</button>
                <br><br>
        </div>
    </div>