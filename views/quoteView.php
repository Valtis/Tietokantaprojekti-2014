
        <div class="container">
           <h1>Quote</h1>
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <p>
                        <b><a href="private_message.php?userid=<?php echo $raw_data['post']->getPosterID() ?>"><?php echo $raw_data['post']->getPosterName(); ?></a></b>
                        Posted on <?php echo $raw_data['post']->getPostDate(); ?>
                    </p>
                    
                    <p><?php echo $raw_data['post']->getPostText(); ?></p>
                </div>
            </div>
 
            <br>
            <form action="quote.php?submit=1&threadid=<?php echo $raw_data['threadid']; ?>&topicid=<?php echo $raw_data['topicid']; ?>&postid=<?php echo $raw_data['postid'];  ?>" method="POST">

                    <textarea rows="5" cols="80" name="textarea" ></textarea>
                    <br><br>
                    <input class="btn btn-default" type="submit"  value="Submit">

            </form>
        <div>
            