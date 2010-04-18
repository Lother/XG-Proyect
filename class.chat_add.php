<?php
/**
 * Shoutbox
 * @author e-Zobar
 * 
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);


// One recovers information of the message and the sender
if (isset($_POST['msg']) && isset($user['username']))
{
	$nick = trim(str_replace('+', 'plus', $user['username']));
	$msg  = trim(str_replace('+', 'plus', $_POST['msg']));
	$ally_id  = trim(str_replace('+', 'plus', $_POST['ally_id']));
	//$msg  = addslashes($_POST['msg']);
	//$nick = addslashes($user['username']);
}
else
{
	$msg = '';
	$nick = '';
	$ally_id='0';
}

// Addition of the message in the database
if ($msg != '' && $nick != '')
{
	$query = doquery("INSERT INTO {{table}} (user, message, timestamp, ally_id) VALUES ('".mysql_escape_string($nick)."', '".mysql_escape_string($msg)."', '".time()."', '" . $ally_id ."')", "chat");
}

?>
