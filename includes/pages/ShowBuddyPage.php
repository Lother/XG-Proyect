<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowBuddyPage($CurrentUser)
{
	global $lang;

	foreach($_GET as $name => $value)
	{
		$$name = intval( $value );
	}
	switch($mode)
	{
		case 1:
			switch($sm)
			{
				case 1:
					doquery("DELETE FROM {{table}} WHERE `id`='{$bid}'","buddy");
					header("location:game.php?page=buddy");
				break;

				case 2:
					doquery("UPDATE {{table}} SET `active` = '1' WHERE `id` ='{$bid}'","buddy");
					header("location:game.php?page=buddy");
				break;

				case 3:
					$test = doquery("SELECT `id` FROM {{table}} WHERE `sender`='{$CurrentUser[id]}' AND `owner`='{$_POST}' OR `owner`='{$CurrentUser[id]}' AND `sender`='{$_POST[u]}'","buddy",true);
					if($test == array())
					{
						$text = mysql_escape_string( strip_tags( $_POST['text'] ) );
						doquery("INSERT INTO {{table}} SET `sender`='{$CurrentUser[id]}' ,`owner`='{$_POST[u]}' ,`active`='0' ,`text`='{$text}'","buddy");
						header("location:game.php?page=buddy");
					}
					else
					{
						message($lang['bu_request_exists'], 'game.php?page=buddy',2 );
					}
				break;
			}
		break;

		case 2:
			if($u==$CurrentUser['id'])
			{
				message($lang['bu_cannot_request_yourself'],'game.php?page=buddy',2);
			}
			else
			{
				$player=doquery("SELECT `username` FROM {{table}} WHERE `id`='{$u}'","users",true);
				$page="<script src=scripts/cntchar.js type=text/javascript></script>
				<center>
				<form action=game.php?page=buddy&mode=1&sm=3 method=post>
				<input type=hidden name=u value={$u}>
				<div id=\"content\"><table width=520>
				<tr><td class=c colspan=2>".$lang['bu_request_message']."</td></tr>
				<tr><th>".$lang['bu_player']."</th><th>{$player[username]}</th></tr>
				<tr><th>".$lang['bu_request_text']." (<span id=cntChars>0</span> / 5000 ".$lang['bu_characters'].")</th><th><textarea name=text cols=60 rows=10 onKeyUp=javascript:cntchar(5000)></textarea></th></tr>
				<tr><td class=c><a href=javascript:back();>".$lang['bu_back']."</a></td><td class=c><input type=submit value=\"".$lang['bu_send']."\"></td></tr>
				</table></form></div>";
				display ($page);
			}
		break;
		default:

			$liste=doquery("SELECT * FROM {{table}} WHERE `sender`='{$CurrentUser[id]}' OR `owner`='{$CurrentUser[id]}'","buddy");

			while($buddy	=	mysql_fetch_assoc($liste))
			{
				if($buddy['active']	==0)
				{
					if($buddy['sender']==$CurrentUser['id'])
					{
						$owner=doquery("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='{$buddy[owner]}'","users",true);
						$myrequest.="<tr><th><a href=game.php?page=messages&mode=write&id={$owner[id]}>{$owner[username]}</a></th>
						<th><a href=game.php?page=alliance&mode=ainfo&a={$owner[ally_id]}>{$owner[ally_name]}</a></th>
						<th><a href=game.php?page=galaxy&mode=3&galaxy={$owner[galaxy]}&system={$owner[system]}>{$owner[galaxy]}:{$owner[system]}:{$owner[planet]}</a></th>
						<th>{$buddy[text]}</th>
						<th><a href=game.php?page=buddy&mode=1&sm=1&bid={$buddy[id]}>".$lang['bu_cancel_request']."</a></th></tr>";
					}
					else
					{
						$sender=doquery("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='{$buddy[sender]}'","users",true);
						$outrequest.="<tr><th><a href=game.php?page=messages&mode=write&id={$sender[id]}>{$sender[username]}</a></th>
						<th><a href=game.php?page=alliance&mode=ainfo&a={$sender[ally_id]}>{$sender[ally_name]}</a></th>
						<th><a href=game.php?page=galaxy&mode=3&galaxy={$sender[galaxy]}&system={$sender[system]}>{$sender[galaxy]}:{$sender[system]}:{$sender[planet]}</a></th>
						<th>{$buddy[text]}</th>
						<th><a href=game.php?page=buddy&mode=1&sm=2&bid={$buddy[id]}>".$lang['bu_accept']."</a><br><a href=game.php?page=buddy&mode=1&sm=1&bid={$buddy[id]}>".$lang['bu_decline']."</a></th></tr>";
					}
				}
				else
				{
					if($buddy['sender']==$CurrentUser['id'])
						$owner = doquery("SELECT `id`, `username`, `onlinetime`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='{$buddy[owner]}'","users",true);
					else
						$owner = doquery("SELECT `id`, `username`, `onlinetime`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='{$buddy[sender]}'","users",true);

						$myfriends.="<tr><th><a href=game.php?page=messages&mode=write&id={$owner[id]}>{$owner[username]}</a></th>
						<th><a href=game.php?page=alliance&mode=ainfo&a={$owner[ally_id]}>{$owner[ally_name]}</a></th>
						<th><a href=game.php?page=galaxy&mode=3&galaxy={$owner[galaxy]}&system={$owner[system]}>{$owner[galaxy]}:{$owner[system]}:{$owner[planet]}</a></th>
						<th><font color=".(( $owner["onlinetime"] + 60 * 10 >= time() )?"lime>".$lang['bu_connected']."":(( $owner["onlinetime"] + 60 * 15 >= time() )?"yellow>".$lang['bu_fifteen_minutes']."":"red>".$lang['bu_disconnected'].""))."</font></th>
						<th><a href=game.php?page=buddy&mode=1&sm=1&bid={$buddy[id]}>".$lang['bu_delete']."</a></th></tr>";
				}
			}

			$myfriends=($myfriends!='')?$myfriends:'<th colspan=6></th>';
			$nor='<th colspan=6></th>';
			$outrequest=($outrequest!='')?$outrequest:$nor;
			$myrequest=($myrequest!='')?$myrequest:$nor;
			$page="<br/><div id=\"content\"><table width=520>
			<tr><td class=c colspan=6>".$lang['bu_buddy_list']."</td></tr>
			<tr><td class=c colspan=6><center>".$lang['bu_requests']."</a></td></tr>
			<tr><td class=c>".$lang['bu_player']."</td>
			<td class=c>".$lang['bu_alliance']."</td>
			<td class=c>".$lang['bu_coords']."</td>
			<td class=c>".$lang['bu_text']."</td>
			<td class=c>".$lang['bu_action']."</td>
			</tr>
			<tr>{$outrequest}</tr>
			<tr><td class=c colspan=6><center>".$lang['bu_my_requests']."</a></td></tr>
			<tr><td class=c>".$lang['bu_player']."</td>
			<td class=c>".$lang['bu_alliance']."</td>
			<td class=c>".$lang['bu_coords']."</td>
			<td class=c>".$lang['bu_text']."</td>
			<td class=c>".$lang['bu_action']."</td>
			</tr>
			<tr>{$myrequest}</tr>
			<tr><td class=c colspan=6><center>".$lang['bu_partners']."</a></td></tr>
			<tr><td class=c>".$lang['bu_player']."</td>
			<td class=c>".$lang['bu_alliance']."</td>
			<td class=c>".$lang['bu_coords']."</td>
			<td class=c>".$lang['bu_estate']."</td>
			<td class=c>".$lang['bu_action']."</td>
			</tr>
			<tr>{$myfriends}</tr>
			</table></div>";

			display ($page);

		break;
	}
}
?>