        <h1>Search results</h1>
        <?php if (empty($raw_data)) {
            echo "No posts matched the search parameters";
        } ?>
        <?php foreach ($raw_data as $p) {
            
            $postid = $p['post']->getPostID();
            $postername = $p['post']->getPosterName();
            $url_param = "?threadid=" . $p['threadid'] . "&topicid=" . $p['topicid'] . "#" . $postid;
            ?>
        <div class='panel panel-default'>
            <div class='panel-body'>
                <div>
                    <p>
                        <b><a href="#" onclick="window.open('thread.php<?php echo $url_param;?>')"><?php echo $postername;?></b></a>
                        Posted on <?php echo $p['post']->getPostDate(); ?>
                    </p>
                    <!-- quote -->
                    <?php if (!empty($p['quote'])) { ?>
                    <p class="alert-info">
                        <b>Quoting <?php echo $p['quote']->getPosterName()?></b><br><?php echo $p['quote']->getFormattedPostText(); ?>
                    </p>
                    <?php } ?>
                    <!-- message -->
                    <p><?php echo $p['post']->getFormattedPostText(); ?></p>

                </div>    
            </div>    
        </div>

        <?php }?>