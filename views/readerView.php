    <?php 
        $thread_topic_url = "?threadid=" . $raw_data['threadid'] . "&topicid=". $raw_data['topicid'];
        
    ?>
    <div class ="right"> 
        <a href="thread.php<?php echo $thread_topic_url; ?>">Thread</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Readers</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($raw_data['users'] as $t) { 
                $thread_topic_user_url = $thread_topic_url . "&userid=" . $t->getID();
                ?>
                <tr>
                <th>
                    <a href="private_message.php<?php echo $thread_topic_user_url; ?>"><?php echo $t->getName(); ?></a>
                </th>
                </tr>
            <?php } ?>
        </tbody>
    </table>