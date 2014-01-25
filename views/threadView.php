
<p class="right">
    <?php
        if (!empty($raw_data['links'])) {
            foreach ($raw_data['links'] as $key => $value) {
                echo '<a href="' . $value . '">' . $key . '</a>' . "\n";
            }
        }
    ?>
</p>
<div>
    <h1>Aihealueet</h1>
    <table class="table">
        <thead>
          <tr>
            <th>Aihealue</th>
            <th>Ketjuja</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <th><a href="ketjut.html">Aihealue1</a></th>
                <th>123</th>
            </tr>
            <tr>
                <th><a href="ketjut.html">Aihealue2</a></th>
                <th>4565</th>
            </tr>
        </tbody>
    </table>
</div>
