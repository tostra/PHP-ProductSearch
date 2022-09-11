<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$productlist=array();
$myshops=array();
//system SETTINGS start
include_once("vars.php");
//
//system SETTINGS end
include_once("functions.php");
//we require cookies
if (!isset($_COOKIE["chkcookie"])) {
$months = 6 * 60 * 60 * 24 * 60 + time(); 
$arr_cookie_options = array (
                'expires' => $months,
                'path' => '/',
                'domain' => ''.$system_domain.'', 
                'secure' => true,     
                'httponly' => true,   
                'samesite' => 'None' // None || Lax  || Strict
                );
setcookie('chkcookie', 1, $arr_cookie_options);
}
$keyword="";
$sites="";
$result="";
$last_request=0;
if (isset($_GET['keyword']) and isset($_GET['sites']) and !empty(trim($_GET['keyword']))) {
$keyword=$_GET['keyword'];
$sites=$_GET['sites'];
//limit requests
$actime = time(); 
if (isset($_SESSION["lastrequest"])) {
$last_request=$_SESSION["lastrequest"];
}
$last_request=$actime-$last_request;
//
if ($limit_requests <= $last_request){
$_SESSION["lastrequest"]=time();
foreach ($sites as $site) {
	$result=performsearch($keyword, $site);
 }
	}
//
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=0, maximum-scale=1">
<link href="styles.css" rel="stylesheet" type="text/css" />
<script> function showLoading() {
     document.getElementById("results").innerHTML = '<div class="loading">Please stand by getting results...</div>';
}
</script>
</head>
<body>
<div id="body">
<div class="sbcont"></div>
<div class="searchbox"> 
<form id="searchform" action="<?php echo''.$system_url.''; ?>" method="get">
 <input name="keyword" autocomplete="off" maxlength="60" placeholder="Your search" type="text" value="<?php echo htmlspecialchars($keyword,ENT_QUOTES,"UTF-8"); ?>"/>
			  <input class="submitbutton" type="submit" value="Search" onclick="showLoading()" alt="Search" />
	<div class="cbx">		  <?php 
foreach ($myshops as $so) {
	if (isset($_GET['sites'])) {
		if (in_array($so, $_GET['sites'])) {
 echo'<input type="checkbox" name="sites[]" value="'.$so.'" checked="checked">'.$sitename[$so].'';
 } else {
	  echo'<input type="checkbox" name="sites[]" value="'.$so.'">'.$sitename[$so].'';
}
} else {
 echo'<input type="checkbox" name="sites[]" value="'.$so.'" checked="checked">'.$sitename[$so].'';
 }
} ?>
</div>
    </form>
</div>
<div id="results">
<ul>
<?php 
if ($productlist and isset($_GET['keyword'])) {
	//order by product name
	function sortme($a, $b)
{
    return strcasecmp($a["name"], $b["name"]);
}
	usort($productlist, "sortme");
	//
	//list all products from our array
foreach ($productlist as $row) {
	$productname=$row['name'];
	 $productprice=$row['price'];
	  $productlink=$row['link'];
	    $productcur=$row['cur'];
		 $productsite=$row['site'];
 echo'<li><a href="'.$productlink.'" target="_blank">'.$productname.'</a> <div>'.$productprice.' '.$productcur.' <span>'.$productsite.'</span></div></li>';
}
} else if (isset($_GET['keyword']) and isset($_GET['sites'])) {
	if ($last_request == 0){
		$last_request=time();
		}
	if (!isset($_COOKIE["chkcookie"])) {
		echo'<div class="loading">Please enable cookies to use this search</div>';
} else if ($limit_requests >= $last_request){
	echo'<div class="loading">Please wait and try again</div>';
} else {
	echo'<div class="loading">No results found</div>';
	}
} else if (!isset($_GET['keyword']) and !isset($_GET['sites'])) {
echo'<div class="loading">Please type something in the box above and click/tap search</div>';
}

?>
</ul>
</div>
</div>
</body>
</html>