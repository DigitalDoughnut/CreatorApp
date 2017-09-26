<?php 
  session_start();

  echo "<!DOCTYPE html>\n<html><head>";

  require_once 'functions.php';

  $userstr = ' (Guest)';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;

  echo "<title>$appname$userstr</title><link rel='stylesheet' " .
       "href='node_modules/bootstrap/dist/css/bootstrap.min.css' type='text/css'>"                     .
       "<meta charset='UTF-8'>"              .
       "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"             .
       "<script src='node_modules/jquery/dist/jquery.min.js'></script>"                  .
       "<script src='node_modules/popper.js/dist/popper.min.js'></script>"                  .
       "<script src='node_modules/bootstrap/dist/js/bootstrap.min.js'></script>"                  .
       "<script src='javascript.js'></script>";

  if ($loggedin)
  {  
  echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">

<a class="navbar-brand d-lg-none d-block" href="#">Logo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item  d-none d-lg-block">
        <a class="nav-link navbar-brand" href="members.php?view=$user">Logo <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="members.php?view=$user">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php">Members</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="messages.php">Messages</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Edit Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log out</a>
      </li>
    </ul>
<!--    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
  </div>
</nav>';
  }

  else
  {
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">

<a class="navbar-brand d-lg-none d-block" href="#">Logo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item  d-none d-lg-block">
        <a class="nav-link navbar-brand" href="index.php">Logo <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signup.php">Sign up</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
    </ul>
<!--    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
  </div>
</nav>';
  }
  
  echo '<div class="container">
<div class="row">
<div class="col-sm-6"></div>
</div>
  </div>'
?>
