<script>
$(function() {
$( "#dateBegin" ).datepicker();
});

$(function() {
$( "#dateEnd" ).datepicker();
});

</script>

<div class="container">
  <h1 class="center">Search</h1>
  <h3 class="center">Search parameters need to be 3 characters or longer</h3>
  <form class="form-horizontal" role="form" action="search.php?submit=1" method="POST">
    <div class="form-group">
      <label for="username" class="col-md-2 control-label">Username</label>
      <div class="col-md-10">
        <input type="text" name="username" class="form-control" placeholder="Username">
      </div>
    </div>
    <div class="form-group">
      <label for="text" class="col-md-2 control-label">Text</label>
      <div class="col-md-10">
        <input type="text" name="text" class="form-control" placeholder="Text to search in post">
      </div>
    </div>
    <div class="form-group">
      <label for="dateBegin" class="col-md-2 control-label">Begin date (optional)</label>
      
      <div class="col-md-10">
        <input type="text" class="form-control" name="dateBegin" id="dateBegin" placeholder="Date">
      </div>
      
    </div>  
    <div class="form-group">
      <label for="dateEnd" class="col-md-2 control-label">End date (optional)</label>
      <div class="col-md-10">
        <input type="text" class="form-control" name="dateEnd" id="dateEnd" placeholder="Date">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <button type="submit" class="btn btn-default">Search</button>
      </div>
    </div>
  </form>
</div>

