
<div>
    <table class="table ">
        <thead>
          <tr>
            <th>Thread</th>
            <th>Created by</th>
            <th>Messages</th>      
            <th>Latest post</th>
            <?php if ($raw_data['loggedin']) { ?>
            <th>Unread posts</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
            <?php
                // create topic links
                foreach ($raw_data['threads'] as $t) { 
                    $thread_url = 'thread.php?threadid=' . $t['thread']->getID() . '&topicid=' . $raw_data['topicid'];
                    ?>
                    <tr>
                    <th><a href="<?php echo $thread_url?>"> <?php echo $t['thread']->getName() ?> </a></th>
                    <th> <?php echo $t['thread']->getCreator() ?> </th>
                    <th> <?php echo $t['thread']->getPostCount() ?> </th>
                    <th> <?php echo $t['thread']->getLastPostDate() ?> </th>
                    <?php if ($raw_data['loggedin']) { ?>
                    <th> <a href="<?php echo $thread_url . "#" . $t['lastreadid']; ?>"> <?php echo $t['lastreadtext']; ?> </a> </th>
                    <?php } ?>
                    <?php if (!empty($raw_data['buttons'])) {
                                $jsparam = $t['thread']->getID(). ", '" . $t['thread']->getName() . "'"; 
                                ?>
                        <th class="right"> 
                        
                            <button class="btn btn-default" onclick="ask_new_thread_name(<?php echo $jsparam ?>)">Rename thread</button>
                            <button class="btn btn-default" onclick="confirm_thread_delete(<?php echo $jsparam ?>)">Delete thread</button>
                        </th>
                        <?php } ?>
                    
                    
                    </tr>
              <?php  } ?>
        </tbody>
    </table>
    <?php if ($raw_data['loggedin']) { ?>
    <div class="right">
        <button type="button" class="btn btn-default" onclick="openWindow('new_thread.php?topicid=<?php echo $raw_data['topicid']; ?>')">Post new thread</button>

    </div>
    <?php } ?>
</div>