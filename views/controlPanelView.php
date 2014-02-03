            <h1>Control panel</h1>
            <table class="table">
                <tbody>
                    <?php if ($raw_data['showPrivateMessages']) { ?>
                    <tr>
                        <th><a href="private_message_list.php">Private messages</a></th>
                    </tr> 
                    <tr>
                        <th><a href="user_management.php">User list</a></th>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>