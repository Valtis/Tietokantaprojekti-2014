
<p class="right">
    <?php
        // create login\register\logout-links
        foreach ($raw_data['links'] as $key => $value) {
            echo '<a href="' . $value . '">' . $key . '</a>' . "\n";
        }
    ?>
</p>
<div>
    <h1>Aihealueet</h1>
    <table class="table">
        <thead>
          <tr>
            <th>Topic</th>
            <th>Threads</th>
          </tr>
        </thead>
        <tbody>
            <?php
                require_once 'libs/models/topic.php';
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
