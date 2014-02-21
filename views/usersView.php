<?php if ($raw_data['pagetype'] === "readers") {
  $thread_topic_page_url = "threadid=" . $raw_data['threadid'] . "&topicid=" . $raw_data['topicid'] . "&page=" . $raw_data['page'];
  echo '<h2><a href="thread.php?' . $thread_topic_page_url . '">Back to thread</a></h2>';
} else if ($raw_data['pagetype'] === "userlist") {?>
<h2><a href="control_panel.php">Back to control panel</a></h2>
<?php
}
?>
<h1><?php echo $raw_data['title']; ?></h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Users</th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach ($raw_data['users'] as $u) { 
                $showlink = isLoggedIn() && !getUser()->isBanned() && getUser()->getID() !== $u->getID(); 
                $access = "";
                if ($u->isBanned()) {
                    $access = "Banned";
                } 
                if ($u->hasNormalAccess()) {
                    $access = "Normal";
                } 
                if ($u->hasModeratorAccess()) {
                    $access = "Moderator";
                } 
                if ($u->hasAdminAccess()) {
                    $access = "Admin";
                } 
                
                
                
                ?><tr>
                    <th><?php
                         if ($showlink) {
                             echo '<a href="private_message.php?';
                             if ($raw_data['pagetype'] === "readers") {
                                 echo  $thread_topic_page_url . "&userid=" . $u->getID() . "&redirect=readers"; 
                             } else if ($raw_data['pagetype'] === "userlist") {
                                 echo "userid=" . $u->getID() . "&redirect=userlist";
                             }
                             echo '">';
                        }
                        
                        echo $u->getName();
                        
                        if ($showlink) {
                            echo '</a>';
                        }
                       
                    ?></th><th class="right">    <?php 
                        if ($showlink && (getUser()->hasAdminAccess() || 
                                (getUser()->hasModeratorAccess() && !$u->hasModeratorAccess()))) { 
                        $name = "roles" . $u->getID(); 
                    ?>                 
                        <select id="<?php echo $name ?>" onchange="handleRoleChange('<?php echo $name ?>', <?php echo $u->getID(); ?>)">
                            <option <?php if ($access === "Normal") { echo "selected"; } ?>>Normal</option>
                            <?php if (getUser()->hasAdminAccess()) { ?>
                            <option <?php if ($access === "Moderator") { echo "selected"; }?>>Moderator</option>
                            <option <?php if ($access === "Admin") { echo "selected"; }?>>Admin</option>
                            <?php } ?>
                            <option <?php if ($access === "Banned") { echo "selected"; }?>>Banned</option>
                        </select>                     
                    <?php
                     } 
                ?></th></tr><?php
             } 
        ?></tbody>
    </table>

