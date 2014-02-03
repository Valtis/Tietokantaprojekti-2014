<h1>List of users</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Users</th>
                
            </tr>
            
        </thead>
        <tbody>
            <?php foreach ($raw_data['users'] as $u) { 
                $showlink = isLoggedIn() && getUser()->getID() !== $u->getID(); 
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
                        ?><a href="private_message.php?userid=<?php echo $u->getID(); ?>"><?php } 
                        echo $u->getName(); 
                            if ($showlink) {
                        ?></a><?php
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

