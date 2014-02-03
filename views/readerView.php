    <?php 
        $thread_topic_url = "?threadid=" . $raw_data['threadid'] . "&topicid=". $raw_data['topicid'];
        
    ?>
   
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Readers</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($raw_data['users'] as $t) { 
                $thread_topic_user_url = $thread_topic_url . "&userid=" . $t->getID();
                $showlink = isLoggedIn() && getUser()->getID() !== $t->getID();
                ?>
                <tr>
                <th>
                    <?php if ($showlink) { ?>
                    <a href="private_message.php<?php echo $thread_topic_user_url; ?>"> <?php } ?>
                        <?php echo $t->getName(); 
                            if ($showlink) {
                        ?>
                    </a>
                    <?php } ?>
                </th>
                </tr>
            <?php } ?>
        </tbody>
    </table>