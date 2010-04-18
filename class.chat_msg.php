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

// The old messages are erased
$timemoment = time();
$time_1h = $timemoment - 3600;
$ally_id  = trim(str_replace('+', 'plus', $_POST['ally_id']));
// One selects the messages present in the base of data
$q = doquery("SELECT COUNT(id) FROM {{table}} WHERE ally_id='". $ally_id ."'", 'chat');
$sq = mysql_fetch_array($q);
$num=$sq[0]-20;
if ($num<0) $num=0;
$query = doquery("SELECT * FROM {{table}} WHERE ally_id='". $ally_id ."' ORDER BY id ASC LIMIT ".$num.",22", 'chat');
while ($v = mysql_fetch_object($query))
{
	$nick = $v->user;
	$msg  = $v->message;
	$pattern = array();
	$replace = array();

	// The different fonts (bold, italics, colors, etc ...)
	$pattern[] = "#\[a=(https?|ftp|news)(.+)\](.+)\[/a\]#isU";
	$replace[] = "<a href=\"$1$2\" target=\"_blank\">$3</a>";
	
	$pattern[] = "#\[b\](.+)\[/b\]#isU";
	$replace[] = "<b>$1</b>";
	
	$pattern[] = "#\[i\](.+)\[/i\]#isU";
	$replace[] = "<i>$1</i>";
	
	$pattern[] = "#\[u\](.+)\[/u\]#isU";
	$replace[] = "<u>$1</u>";
	
	$pattern[] = "#\[c=(blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU";
	$replace[] = "<font color=\"$1\">$2</font>";

	// Smileys with their shortcuts
	$pattern[] = "#:c#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/cry.png\" align=\"absmiddle\" title=\":c\" alt=\":c\">";
	
	$pattern[] = "#(?!http):/(?!/)#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/confused.png\" align=\"absmiddle\" title=\":/\" alt=\":/\">";
	
	$pattern[] = "#o0#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/dizzy.png\" align=\"absmiddle\" title=\"o0\" alt=\"o0\">";
	
	$pattern[] = "#\^\^#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/happy.png\" align=\"absmiddle\" title=\"^^\" alt=\"^^\">";
	
	$pattern[] = "#:D#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/lol.png\" align=\"absmiddle\" title=\":D\" alt=\":D\">";
	
	$pattern[] = "#:\|#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/neutral.png\" align=\"absmiddle\" title=\":|\" alt=\":|\">";
	
	$pattern[] = "#:\)#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/smile.png\" align=\"absmiddle\" title=\":)\" alt=\":)\">";
	
	$pattern[] = "#:o#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/omg.png\" align=\"absmiddle\" title=\":o\" alt=\":o\">";
	
	$pattern[] = "#:p#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/tongue.png\" align=\"absmiddle\" title=\":p\" alt=\":p\">";
	
	$pattern[] = "#:\(#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/sad.png\" align=\"absmiddle\" title=\":(\" alt=\":(\">";
	
	$pattern[] = "#;\)#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/wink.png\" align=\"absmiddle\" title=\";)\" alt=\";)\">";
	
	$pattern[] = "#:s#isU";
	$replace[] = "<img src=\"styles/skins/evolution/smileys/shit.png\" align=\"absmiddle\" title=\":s\" alt=\":s\">";
	
	$pattern[] = "#xnova#";
	$replace[] = "<a href=\"http://xgp.twbbs.org/\">XGProyect</a>"; // xnova.fr dont work

	$msg = preg_replace($pattern, $replace, $msg);

	// Message
	$msg = "<div align=left>{$nick}&#62;{$msg}<br></div>";
	echo stripslashes($msg);
}

?>
