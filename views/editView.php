
        
        <div class="container">
            <h1>Edit</h1>
            <form action="edit.php?submit=1&threadid=<?php echo $raw_data['threadid']; ?>&topicid=<?php echo $raw_data['topicid']; ?>&postid=<?php echo $raw_data['postid'];  ?>" method="POST">

                    <textarea rows="5" cols="80" name="textarea" ><?php echo $raw_data['text']; ?></textarea>
                    <br><br>
                    <input class="btn btn-default" type="submit"  value="Submit">

            </form>
        <div>
            