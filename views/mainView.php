<div>
    <h1>Topics</h1>
    <table class="table ">
        <thead>
          <tr>
            <th>Topic</th>
            <th>Threads</th>
          </tr>
        </thead>
        <tbody>
            <?php // create topic links
                foreach ($raw_data['topics'] as $t) { ?>
                    <tr>
                    <th><a href="threads.php?topicid=<?php echo $t->getID(); ?>"> <?php echo $t->getName(); ?>  </a> </th>
                    <th><?php echo $t->getThreadCount(); ?></th>
            
                    
                        <?php if (!empty($raw_data['showTopicButtons'])) { 
                            
                            $jsparam = $t->getID() . ', ' . "'" . $t->getName() . "'";
                            ?>
                            <th class="right">
                                <button class="btn btn-default" onclick="ask_new_topic_name(<?php echo $jsparam; ?>)">Rename topic</button>
                                <button class="btn btn-default" onclick="confirm_topic_delete(<?php echo $jsparam; ?>)">Delete topic</button>
                            </th>
                        <?php } ?>
                    
                    </tr>


             <?php } ?>
        </tbody>
    </table>
    <?php if (!empty($raw_data['showTopicButtons'])) { ?>
        <div class="right"> 
             <button class="btn btn-default" type="button" onclick="create_new_topic()">Create new topic</div>
        </div>
    <?php } ?>    
</div>
