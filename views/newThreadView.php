

<div class="container">
  <h1 class="center">New thread</h1>
  <form class="form-horizontal" role="form" action="new_thread.php?topicid=<?php echo $raw_data['topicid']; ?>&submit=1" method="POST">
    <div class="form-group">
      <div class="col-md-offset-2 col-md-8">
        <input type="text" name="threadtitle" class="form-control" placeholder="Thread title">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-2 col-md-8">
        <textarea class="form-control" rows="5" cols="80" name="textarea" ></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-2 col-md-8">
        <button type="submit" class="btn btn-default">Post thread</button>
      </div>
    </div>
  </form>
</div>

