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

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false)
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

includeLang('chat');
$body = gettemplate('chat_body');

$nick  = $user['username'];
$parse = $lang;

$page = parsetemplate($body, $parse);
display($page, $lang['Chat'], false);

?>

