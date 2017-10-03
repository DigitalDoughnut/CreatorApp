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
  
/* ---------------------  SECTIONS -------------------------- */

function createDashboardSection ($table_name , $sectionID, $optionArray, $subsectionsArray){
global $user;

    if (isset($_POST["$sectionID-Type"]) &&
        isset($_POST["$sectionID-Name"]) &&
        isset($_POST["$sectionID-Desc"]))
  {
    $Type = sanitizeString($_POST["$sectionID-Type"]);
    $Name = sanitizeString($_POST["$sectionID-Name"]);
    $Desc = sanitizeString($_POST["$sectionID-Desc"]);
    
    $_POST["$sectionID-Type"] = "";
    $_POST["$sectionID-Name"] = "";
    $_POST["$sectionID-Desc"] = ""; 

    if ($Type != "Select $table_name" && $Name != "" && $Desc != "")
    {
      $time = time();
      queryMysql("INSERT INTO $table_name VALUES('$Name',
        '$Type', '$user', '$Desc')");
      $Desc = $Name = $Type = "";
    }
  }

$query = "SELECT userID FROM $table_name WHERE userID='$user'";
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
                    <a class='CollapseCaret' data-toggle='collapse' href='#$sectionID' aria-expanded='false' aria-controls='$sectionID'><h4>$table_name" . "s ($rows) <i class='fa fa-caret-right'></i></h4></a>
                 </div>
                 </div> 
                 <div class=' p-2 dashboard-header4 rounded-bottom no_underline2'>
                 <div class='collapse' id='$sectionID'>";



/* ------  ADD SECTION ------ */

echo                 "<a class='CollapseCaret' data-toggle='collapse' href='#$sectionID-Form' aria-expanded='false' aria-controls='$sectionID-Form'>Add $table_name <i class='fa fa-caret-right'></i></a>
                     <div class='collapse' id='$sectionID-Form'>
                     <form method='post' action='dashboard.php'>
                     <div class='form-group'>
                     <label for='$sectionID-Type'>$table_name Type: </label>
                     <select type='text' class='form-control' id='$sectionID-Type' name='$sectionID-Type'>
                     <option>Select $table_name</option>";

$optionCount = count($optionArray);
for ($j=0; $j<$optionCount ; ++$j){
    echo "<option>$optionArray[$j]</option>";
}

echo                "
                     </select>
                     </div> 
                     <div class='form-group'>
                     <label for='$sectionID-Name'>$table_name Name: </label>
                     <input type='text' class='form-control' id='$sectionID-Name' name='$sectionID-Name'>
                     </div>
                     <div class='form-group'>
                     <label for='$sectionID-Desc'>$table_name Description: </label>
                     <textarea name='$sectionID-Desc' placeholder='Type or paste $table_name description here' class='form-control' id='$sectionID-Desc' rows='6' class='d-block'></textarea>
                     </div>
                     <div>
                     <button type='submit' class='my-2 btn btn-primary'>Add $table_name</button>
                     </div>
                     </form>
                     </div>
                     <hr>";

/* ------  SUBSECTIONS HARMONISED ------ */





$subSectionCount = count($subsectionsArray);



for ($sub=0 ; $sub<$subSectionCount ; ++$sub){
$subsectionName = $subsectionsArray[$sub][0];
$subsectionNameIDArray = explode (" " , $subsectionName);
$subsectionNameID = $subsectionNameIDArray[0];
$subsectionCategoryCount = count ($subsectionsArray[$sub]);

        
echo  "<h4>$subsectionName" . "<span data-toggle='tooltip' data-placement='top' title='worlds, countries, cities etc'> &nbsp; <i class='fa fa-question-circle-o'></i> </span> </h4>";

$querySection = "";

for ($j=1 ; $j<$subsectionCategoryCount ; ++$j) {
    
$subsectionCategory = $subsectionsArray[$sub][$j];
$querySection .= "userID='$user' && " . $sectionID . "type='$subsectionCategory'";

if ($j<$subsectionCategoryCount-1) {
    $querySection .= " || ";
}
}

$query = "SELECT * FROM $table_name WHERE " . $querySection;
$result = queryMysql($query);
$rows = $result->num_rows;

if ($rows) {
    $nameExt = $sectionID . "name";
    $typeExt = $sectionID . "type";
    $descExt = $sectionID . "desc";
    
for ($j = 0; $j<$rows ; ++$j){
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $Name = $row["$nameExt"];
    $Type = $row["$typeExt"];
    $Desc = $row["$descExt"];
    echo "<div><a class='CollapseCaret' data-toggle='collapse' href='#" . $subsectionNameID . "$sectionID" . "$j' aria-expanded='false' aria-controls='" . $subsectionNameID . "$sectionID" . "$j'>$Name ($Type) <i class='fa fa-caret-right'></i></a></div>";
    echo "<div class='collapse' id='" . $subsectionNameID . "$sectionID" . "$j'>";
    echo "<div>$Desc</div></div>";
}
}
else {
echo "<p>You do not currently have any Macro " . $table_name ."s</p>";



}

}
 

/* ------  MACRO SECTION ------ */
/*
echo                 "<h4>Macro $table_name" . "s <span data-toggle='tooltip' data-placement='top' title='worlds, countries, cities etc'> &nbsp; <i class='fa fa-question-circle-o'></i> </span> </h4>";

$query = "SELECT * FROM $table_name WHERE userID='$user' && " . $sectionID . "type='City' || userID='$user' && " . $sectionID . "type='World' || userID='$user' && " . $sectionID . "type='Region' || userID='$user' && " . $sectionID . "type='Other Macro'";
$result = queryMysql($query);
$rows = $result->num_rows;

if ($rows) {
    $nameExt = $sectionID . "name";
    $typeExt = $sectionID . "type";
    $descExt = $sectionID . "desc";
for ($j = 0; $j<$rows ; ++$j){
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $Name = $row["$nameExt"];
    $Type = $row["$typeExt"];
    $Desc = $row["$descExt"];
    echo "<div><a class='CollapseCaret' data-toggle='collapse' href='#Mac" . "$sectionID" . "$j' aria-expanded='false' aria-controls='Mac" . "$sectionID" . "$j'>$Name ($Type) <i class='fa fa-caret-right'></i></a></div>";
    echo "<div class='collapse' id='Mac" . "$sectionID" . "$j'>";
    echo "<div>$Desc</div></div>";
}
}
else {

  
echo "<p>You do not currently have any Macro " . $table_name ."s</p>";}

/* ------  MICRO SECTION ------ 

echo "<hr><h4>Micro " . $table_name . "s <span data-toggle='tooltip' data-placement='top' title='buildings, arenas, rooms etc'> &nbsp; <i class='fa fa-question-circle-o'></i> </span></h4>";
$query = "SELECT * FROM $table_name WHERE userID='$user' && " . $sectionID . "type='Building' || userID='$user' && " . $sectionID . "type='Other Ext Micro' || userID='$user' && " . $sectionID . "type='Other Int Micro'";
$result = queryMysql($query);
$rows = $result->num_rows;

if ($rows) {
    $nameExt = $sectionID . "name";
    $typeExt = $sectionID . "type";
    $descExt = $sectionID . "desc";    
for ($j = 0; $j<$rows ; ++$j){
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $Name = $row["$nameExt"];
    $Type = $row["$typeExt"];
    $Desc = $row["$descExt"];
    echo "<div><a class='CollapseCaret' data-toggle='collapse' href='#Mic" . $sectionID . $j . "' aria-expanded='false' aria-controls='Mic" . $sectionID. $j . "'>$Name ($Type) <i class='fa fa-caret-right'></i></a></div>";
    echo "<div class='collapse' id='Mic" . $sectionID . $j ."'>";
    echo "<div>$Desc</div></div>";
}
}
else {

  
echo "<p>You do not currently have any Micro $table_name" . "s</p>";

}

 */
}


$envSubsections = array (
    array('Macro Environments' , 'World' , 'Region' , 'City' , 'Other Macro'),
    array('Micro Environments' , 'Building' , 'Other Ext Micro' , 'Other Int Micro')
    );



createDashboardSection ('Environment' , 'Env', ['World' , 'Region'
    , 'City' , 'Building' , 'Other Macro' , 'Other Ext Micro' , 'Other Int Micro']
    , [['Macro Environments' , 'World' , 'Region' , 'City' , 'Other Macro'] ,
    ['Micro Environments' , 'Building' , 'Other Ext Micro' , 'Other Int Micro']]);

echo "</div></div></div>";

createDashboardSection ('Player' , 'Player', ['Protagonist' , 'Anti-Hero'] , $envSubsections );

echo "</div></div></div>";

    echo   "  <div class='col-sm-6 dashboard2 py-3 pr-2'>
                 <div class='dashboard-header2 p-2 rounded'>
                <h4>Other categories </h4>
                <p>You do not currently have any other categories</p>
                 </div>
               </div>
            </div>
        </div>";

echo "<script>$('.CollapseCaret').on('click', function() {
    $(this).find('i').toggleClass('fa fa-caret-right');
    $(this).find('i').toggleClass('fa fa-caret-down');
})</script>
    </body>
</html>";

?>