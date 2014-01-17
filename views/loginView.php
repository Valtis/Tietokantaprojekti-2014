<!DOCTYPE html>
<html>
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Please log in</title>
    </head>
    <body>
        <?php if (!empty($data->error)): ?>
           <div class="alert alert-danger">
        <?php echo $data->error; ?></div>
        <?php endif; ?>
          
        <div class="container">
          <h1>Log in</h1>
          <form class="form-horizontal" role="form" action="login.php" method="POST">
            <div class="form-group">
              <label for="inputUserName" class="col-md-2 control-label">Username</label>
              <div class="col-md-10">
                <input type="text" name="username" class="form-control" id="inputUserName1" placeholder="Username">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="col-md-2 control-label">Password</label>
              <div class="col-md-10">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-2 col-md-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Remember me
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Log in</button>
              </div>
            </div>
          </form>
        </div>
    </body>
</html>
