<?php
session_start();

#db connnection
mysql_connect('localhost','root','');
mysql_select_db('multido') or die(mysql_error());

if($_POST){
	foreach ($_POST as $key => $value) {
		$$key = $value;
	}

$query = "select * from members where uname = '".$username."' ";
$query .= "and password = '".$password."' OR email = '".$username."' and password = '".$password."';";
$result = mysql_query($query);
$thequery_rst = @mysql_result($result,0);
$grant_access = ($thequery_rst == true ? true : false);

$php_array_result = array($username,$password,$grant_access,$thequery_rst[0]);

if($grant_access==true){
	$_SESSION['logon']=true;
}else{
	$_SESSION['logon']=false;
}

$_SESSION['uid']=$thequery_rst[0];
// Send the correct MIME header and echo out the JSON string
header("Content-type: application/json");
echo json_encode($php_array_result);
}else{ 
	session_destroy();
	header("Location: logon.php"); }

exit();
?>