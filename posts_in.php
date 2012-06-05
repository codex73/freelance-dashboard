<?php
/**
 * @package Freelance Dashboard
 * @version 1
 * @author Francis Suarez [@codex73]
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

#load config / db
//include ('config.php');
#mailer class
//require_once('inc/class.phpmailer.php');

#db connnection
mysql_connect('localhost','root','');
mysql_select_db('multido') or die(mysql_error());

#post
$action = trim(strip_tags($_POST['action'])); 
$cid = trim(strip_tags($_POST['cid']));
$bid = trim(strip_tags($_POST['bid']));
$altstatus = trim(strip_tags($_POST['altstatus'])); 
$content = trim(strip_tags($_POST['content'])); 
$prj = trim(strip_tags($_POST['prj']));
$uid = trim(strip_tags($_POST['uid']));
$typerec = trim(strip_tags($_POST['typerec']));

//New Board
if($action=='new_asset'&&$typerec=='new_board'){
	$query = "INSERT INTO boards (bid,bname) values (null,'".$content."');";
	$result = mysql_query($query);
	$cid = mysql_insert_id();
}

//New Box
if($action=='new_asset'&&$typerec=='new_box'){
	$query = "INSERT INTO box (rname,bdate,fbid) values ('".$content."',NOW(),'".$prj."');";
	$result = mysql_query($query);
	$cid = mysql_insert_id();
	$query = "INSERT INTO box_perm (fkuid,fkbox) values ('".$uid."','".$cid."');";
	$result = mysql_query($query);
}

//New Entry
if($action=='new_tk'){
	$query = "INSERT INTO box_cont (cname,fkid,cdate,status) values ('".$content."', '".$cid."',NOW(),1);";
	$result = mysql_query($query);
	$cid = mysql_insert_id();
}

//Update Status of Item
if($action=='status_up'){
	$query = "UPDATE box_cont SET status = '".$altstatus."' where cid = '".$cid."';";
	$result = mysql_query($query);
}

//Remove Task
if($action=='rem_tsk'){
	$query = "DELETE from box_cont where cid = '".$cid."';";
	$result = mysql_query($query);
}

//Remove Task
if($action=='rem_box'){
	$query = "DELETE from box where id = '".$bid."';";
	$result = mysql_query($query);
}

$php_array_result = array($action,$cid,$content,$bid);
// Send the correct MIME header and echo out the JSON string
header("Content-type: application/json");
echo json_encode($php_array_result);    
exit();

?>