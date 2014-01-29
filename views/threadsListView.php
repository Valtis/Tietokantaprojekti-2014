
<div>
    <table class="table ">
        <thead>
          <tr>
            <th>Thread</th>
            <th>Created by</th>
            <th>Messages</th>      
            <th>New messages since last reading?</th>
          </tr>
        </thead>
        <tbody>
            <?php
                // create topic links
                foreach ($raw_data['threads'] as $t) { ?>
                    <tr>
                    <th><a href="thread.php?threadid=<?php echo $t->getID()?>&topicid=<?php echo $raw_data['topicid']?>"><?php echo $t->getName() ?> </a></th>
                    <th> <?php echo $t->getCreator() ?> </th>
                    <th> <?php echo $t->getPostCount() ?> </th>
                    <th> <?php echo $t->getNewMessagesPosted() ?> </th>
                    <th> <?php if (!empty($raw_data['buttons'])) { ?>
                            <button class="btn btn-default">Rename thread</button>
                            <button class="btn btn-default" onclick="confirm_thread_delete(<?php echo $t->getID(); ?>, '<?php echo $t->getName(); ?>')">Delete thread</button>
                        <?php } ?>
                    </th>
                    </tr>
              <?php  } ?>
        </tbody>
    </table>
    <?php if ($raw_data['shownewthread']) { ?>
    <div class="right">
        <button type="button" class="btn btn-default" onclick="openWindow('new_thread.php?topicid=<?php echo $raw_data['topicid']; ?>')">Post new thread</button>

    </div>
    <?php } ?>
</div>