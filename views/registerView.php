<p class="right">
    <a href="index.php">Return to main page</a>
</p>
<div class="container">
  <h1 class ="center">Create your account</h1>
  <form class="form-horizontal" role="form" action="register.php" method="POST">
    <div class="form-group">
      <label for="inputUserName" class="col-md-2 control-label">User name</label>
      <div class="col-md-10">
        <input type="text" name="username" class="form-control" id="inputUserName1" placeholder="User name">
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-md-2 control-label">Email</label>
      <div class="col-md-10">
        <input type="email" name="email" class="form-control" id="email" placeholder="Email">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-md-2 control-label">Password</label>
      <div class="col-md-10">
        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword_retype" class="col-md-2 control-label">Retype the password</label>
      <div class="col-md-10">
        <input type="password" name="password_retype" class="form-control" id="inputPassword_retype" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <button type="submit" class="btn btn-default">Create an account</button>
      </div>
    </div>
</form>

</div>