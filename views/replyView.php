       
        <div class ="right">
            <a href="thread.php?threadid=<?php echo $raw_data['threadid']; ?>&topicid=<?php echo $raw_data['topicid']; ?>">Back</a>
        </div>
        <div class="container">
            <h1><?php echo $raw_data['title'] ?></h1>
            <br>
            <form action="reply.php?submit=1&threadid=<?php echo $raw_data['threadid']; ?>&topicid=<?php echo $raw_data['topicid']; if (!empty($raw_data['postid'])) { echo '&postid=' . $raw_data['postid']; } ?>" method="POST">

                    <textarea rows="5" cols="80" name="textarea" ></textarea>
                    <br><br>
                    <input class="btn btn-default" type="submit"  value="Submit">

            </form>
        <div>