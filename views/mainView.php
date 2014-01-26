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
            <?php
                // create topic links
                foreach ($raw_data['topics'] as $t) {
                    echo "<tr>\n";
                    echo '<th><a href="threads.php?topicid=' . $t->getID() . '">' . $t->getName() . '</a>' . "</th>\n";
                    echo "<th>" . $t->getThreadCount()  . "</th>\n";
                    echo "</tr>\n";
                }
            ?>
        </tbody>
    </table>
</div>
