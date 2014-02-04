

<div class="container">
  <h1 class="center">Search</h1>
  <form class="form-horizontal" role="form" action="search.php?submit=1" method="POST">
    <div class="form-group">
      <label for="inputUserName" class="col-md-2 control-label">Username</label>
      <div class="col-md-10">
        <input type="text" name="username" class="form-control" id="inputUserName1" placeholder="Username">
      </div>
    </div>
    <div class="form-group">
      <label for="inputText" class="col-md-2 control-label">Text</label>
      <div class="col-md-10">
        <input type="text" name="text" class="form-control" id="inputText" placeholder="Text to search in post">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <button type="submit" class="btn btn-default">Search</button>
      </div>
    </div>
  </form>
</div>

