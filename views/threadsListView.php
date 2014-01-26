
<div class="right">
    <a href="index.php">Back to topic list</a>
</div>
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
                foreach ($raw_data['threads'] as $t) {
                    echo "<tr>\n";
                    echo '<th><a href="thread.php?threadid=' . $t->getID() . '&topicid=' . $raw_data['topicid'] . '">' . $t->getName() . '</a>' . "</th>\n";
                    echo "<th>" . $t->getCreator() . "</th>\n";
                    echo "<th>" . $t->getPostCount()  . "</th>\n";
                    echo "<th>" . $t->getNewMessagesPosted()  . "</th>\n";
                    echo "</tr>\n";
                }
            ?>
        </tbody>
    </table>
</div>
