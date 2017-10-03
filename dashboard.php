<!-- Dashboard page will likely become home page -->
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
  
    if (isset($_POST['EnvType']) &&
        isset($_POST['EnvName']) &&
        isset($_POST['EnvDesc']))
  {
    $EnvType = sanitizeString($_POST['EnvType']);
    $EnvName = sanitizeString($_POST['EnvName']);
    $EnvDesc = sanitizeString($_POST['EnvDesc']);
    
    $_POST['EnvType'] = "";
    $_POST['EnvName'] = "";
    $_POST['EnvDesc'] = ""; 
    /*echo "Environment type: '$EnvType'";
    echo "Environment name: '$EnvName'";
    echo "Environment description: '$EnvDesc'";*/

    if ($EnvType != "Select environment" && $EnvName != "" && $EnvDesc != "")
    {
      $time = time();
      queryMysql("INSERT INTO environments VALUES('$EnvName',
        '$EnvType', '$user', '$EnvDesc')");
      $EnvType = "";
      $EnvName = "";
      $EnvDesc = "";
    }
  }


echo    "
        <title>$appname$userstr</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo    '<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="styles.css" type="text/css">
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="node_modules/popper.js/dist/popper.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="javascript.js"></script>
    </head>
    <body>';

/* ---------------------  NAVBAR -------------------------- */

  if ($loggedin)
  {  
  echo '<nav class="navbar navbar-expand-lg navbar-dark navbarColor1" >

            <a class="navbar-brand d-lg-none d-block" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item  d-none d-lg-block">
                        <a class="nav-link navbar-brand" href="members.php?view=$user">Logo <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
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
                    <li class="nav-item active">
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
  
/* ---------------------  ENVIRONMENTS -------------------------- */

$query = "SELECT userID FROM environments WHERE userID='$user'";
$result = queryMysql($query);
$rows = $result->num_rows;
if (!$rows){
    $rows = 0;
}
  
echo "  <div class='container'>

            <div class='row'>
               <div class='col-sm-6 dashboard2 py-3 pr-2'>
                 <div class=' p-2 dashboard-header2 rounded-top no_underline'>
                 <div class='dashboard-header2'>
                    <a class='CollapseCaret' data-toggle='collapse' href='#Env' aria-expanded='false' aria-controls='Env'><h4>Environments ($rows) <i class='fa fa-caret-right'></i></h4></a>
                 </div>
                 </div>
                 <div class=' p-2 dashboard-header4 rounded-bottom no_underline2'>
                 <div class='collapse' id='Env'>";



/* ------  ADD ENVIRONMENT ------ */

echo                 '<a class="CollapseCaret" data-toggle="collapse" href="#MacEnvForm" aria-expanded="false" aria-controls="MacEnvForm">Add Environment <i class="fa fa-caret-right"></i></a>
                     <div class="collapse" id="MacEnvForm">
                     <form method="post" action="MyEnvironments.php">
                     <div class="form-group">
                     <label for="EnvType">Environment Type: </label>
                     <select type="text" class="form-control" id="EnvType" name="EnvType">
                     <option>Select environment</option>
                     <option>World</option>
                     <option>Region</option>
                     <option>City</option>
                     <option>Building</option>
                     <option>Other Macro</option>
                     <option>Other Ext Micro</option>
                     <option>Other Int Micro</option>
                     </select>
                     </div>
                     <div class="form-group">
                     <label for="EnvName">Environment Name: </label>
                     <input type="text" class="form-control" id="EnvName" name="EnvName">
                     </div>
                     <div class="form-group">
                     <label for="EnvDesc">Environment Description: </label>
                     <textarea name="EnvDesc" placeholder="Type or paste environment description here" class="form-control" id="EnvDesc" rows="6" class="d-block"></textarea>
                     </div>
                     <div>
                     <button type="submit" class="my-2 btn btn-primary">Add Environment</button>
                     </div>
                     </form>
                     </div>
                     <hr>';

/* ------  MACRO ENVIRONMENTS ------ */

echo                 '<h4>Macro Environments <span data-toggle="tooltip" data-placement="top" title="worlds, countries, cities etc"> &nbsp; <i class="fa fa-question-circle-o"></i> </span> </h4>';

$query = "SELECT * FROM environments WHERE userID='$user' && envtype='City' || userID='$user' && envtype='World' || userID='$user' && envtype='Region' || userID='$user' && envtype='Other Macro'";
$result = queryMysql($query);
$rows = $result->num_rows;

if ($rows) {
for ($j = 0; $j<$rows ; ++$j){
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $EnvName = $row['envname'];
    $EnvType = $row['envtype'];
    $EnvDesc = $row['envdesc'];
    echo "<div><a class='CollapseCaret' data-toggle='collapse' href='#MacEnv$j' aria-expanded='false' aria-controls='MacEnv$j'>$EnvName ($EnvType) <i class='fa fa-caret-right'></i></a></div>";
    echo "<div class='collapse' id='MacEnv$j'>";
    echo "<div>$EnvDesc</div></div>";
}
}
else {

  
echo '<p>You do not currently have any macro environments</p>';}

/* ------  MICRO ENVIRONMENTS ------ */

echo '<hr><h4>Micro Environments <span data-toggle="tooltip" data-placement="top" title="buildings, arenas, rooms etc"> &nbsp; <i class="fa fa-question-circle-o"></i> </span></h4>';
$query = "SELECT * FROM environments WHERE userID='$user' && envtype='Building' || userID='$user' && envtype='Other Ext Micro' || userID='$user' && envtype='Other Int Micro'";
$result = queryMysql($query);
$rows = $result->num_rows;

if ($rows) {
for ($j = 0; $j<$rows ; ++$j){
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $EnvName = $row['envname'];
    $EnvType = $row['envtype'];
    $EnvDesc = $row['envdesc'];
    echo "<div><a class='CollapseCaret' data-toggle='collapse' href='#MicEnv$j' aria-expanded='false' aria-controls='MicEnv$j'>$EnvName ($EnvType) <i class='fa fa-caret-right'></i></a></div>";
    echo "<div class='collapse' id='MicEnv$j'>";
    echo "<div>$EnvDesc</div></div>";
}
}
else {

  
echo '<p>You do not currently have any micro environments</p>';}

    echo'      
               </div>
               </div>
               </div>
                <div class="col-sm-6 dashboard2 py-3 pr-2">
                 <div class="dashboard-header2 p-2 rounded">
                <h4>Other categories </h4>
                <p>You do not currently have any other categories</p>
                 </div>
               </div>
            </div>
        </div>';

echo "<script>$('.CollapseCaret').on('click', function() {
    $(this).find('i').toggleClass('fa fa-caret-right');
    $(this).find('i').toggleClass('fa fa-caret-down');
})</script>
    </body>
</html>";

?>