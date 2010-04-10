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

function ShowOverviewPage($CurrentUser, $CurrentPlanet)
{
	global $xgp_root, $phpEx, $dpath, $game_config, $lang, $planetrow, $user;

	include_once($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.FlyingFleetsTable.' . $phpEx);

	$FlyingFleetsTable = new FlyingFleetsTable();

	$lunarow = 	 doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$CurrentPlanet['id_owner'] . "' AND `galaxy` = '" . $CurrentPlanet['galaxy'] . "' AND `system` = '" . $CurrentPlanet['system'] . "' AND  `planet` = '" . $CurrentPlanet['planet'] . "' AND `planet_type`='3'", 'planets', true);

	if (empty($lunarow)) { unset($lunarow); }

	CheckPlanetUsedFields($lunarow);

	$parse					= $lang;
	$parse['planet_id'] 	= $CurrentPlanet['id'];
	$parse['planet_name'] 	= $CurrentPlanet['name'];
	$parse['galaxy_galaxy'] = $CurrentPlanet['galaxy'];
	$parse['galaxy_system'] = $CurrentPlanet['system'];
	$parse['galaxy_planet'] = $CurrentPlanet['planet'];

	switch ($_GET['mode'])
	{
		case 'renameplanet':

			if ($_POST['action'] == $lang['ov_planet_rename_action'])
			{
				$newname        = mysql_escape_string(strip_tags(trim($_POST['newname'])));
				
				if (preg_match("#[\\\/\:\*\?\<\>\|\"]#", $newname) == 1)
				{
					message($lang['ov_newname_error'], "game.php?page=overview&mode=renameplanet",2);
				}
				if ($newname != "")
				{
					doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `id` = '" . $CurrentUser['current_planet'] . "' LIMIT 1;", "planets");
				}
			}
			elseif ($_POST['action'] == $lang['ov_abandon_planet'])
			{
				return display(parsetemplate(gettemplate('overview/overview_deleteplanet'), $parse));
			}
			elseif ($_POST['kolonieloeschen'] == 1 && intval($_POST['deleteid']) == $CurrentUser['current_planet'])
			{
				$filokontrol = doquery("SELECT * FROM {{table}} WHERE fleet_owner = '{$user['id']}' AND fleet_start_galaxy='{$CurrentPlanet['galaxy']}' AND fleet_start_system='{$CurrentPlanet['system']}' AND fleet_start_planet='{$CurrentPlanet['planet']}'", 'fleets');

				while($satir = mysql_fetch_array($filokontrol))
				{
					$kendifilo 	= $satir['fleet_owner'];
					$digerfilo 	= $satir['fleet_target_owner'];
					$harabeyeri = $satir['fleet_end_type'];
					$mess 		= $satir['fleet_mess'];
				}

				$filokontrol = doquery("SELECT * FROM {{table}} WHERE fleet_target_owner = '{$user['id']}' AND fleet_end_galaxy='{$CurrentPlanet['galaxy']}' AND fleet_end_system='{$CurrentPlanet['system']}' AND fleet_end_planet='{$CurrentPlanet['planet']}'" , 'fleets');

				while($satir = mysql_fetch_array($filokontrol))
				{
					$kendifilo 	= $satir['fleet_owner'];
					$digerfilo 	= $satir['fleet_target_owner'];
					$gezoay 	= $satir['fleet_end_type'];
					$mess 		= $satir['fleet_mess'];
				}
				
				if ($kendifilo > 0)
				{
					message($lang['ov_abandon_planet_not_possible'], 'game.php?page=overview&mode=renameplanet');
				}
				elseif ((($digerfilo > 0) && ($mess < 1 )) && $gezoay <> 2  )
				{
					message($lang['ov_abandon_planet_not_possible'], 'game.php?page=overview&mode=renameplanet');
				}
				else
				{
					if (md5($_POST['pw']) == $CurrentUser["password"] && $CurrentUser['id_planet'] != $CurrentUser['current_planet'])
					{

						doquery("UPDATE {{table}} SET `destruyed` = '".(time()+ 86400)."' WHERE `id` = '".mysql_real_escape_string($CurrentUser['current_planet'])."' LIMIT 1;" , 'planets');
						doquery("UPDATE {{table}} SET `current_planet` = `id_planet` WHERE `id` = '". mysql_real_escape_string($CurrentUser['id']) ."' LIMIT 1", "users");
						doquery("DELETE FROM {{table}} WHERE `galaxy` = '". $CurrentPlanet['galaxy'] ."' AND `system` = '". $CurrentPlanet['system'] ."' AND `planet` = '". $CurrentPlanet['planet'] ."' AND `planet_type` = 3;", 'planets');

						message($lang['ov_planet_abandoned'], 'game.php?page=overview&mode=renameplanet');
					}
					elseif ($CurrentUser['id_planet'] == $CurrentUser["current_planet"])
					{
						message($lang['ov_principal_planet_cant_abanone'], 'game.php?page=overview&mode=renameplanet');
					}
					else
					{
						message($lang['ov_wrong_pass'], 'game.php?page=overview&mode=renameplanet');
					}
				}
			}

			return display(parsetemplate(gettemplate('overview/overview_renameplanet'), $parse));
			break;

		default:
			if ($CurrentUser['new_message'] != 0)
			{
				$Have_new_message .= "<tr>";
				if ($CurrentUser['new_message'] == 1)
				{
					$Have_new_message .= "<th colspan=4><a href=game.$phpEx?page=messages>". $lang['ov_have_new_message'] ."</a></th>";
				}
				elseif ($CurrentUser['new_message'] > 1)
				{
					$Have_new_message .= "<th colspan=4><a href=game.$phpEx?page=messages>";
					$Have_new_message .= str_replace('%m', pretty_number($CurrentUser['new_message']), $lang['ov_have_new_messages']);
					$Have_new_message .= "</a></th>";
				}
				$Have_new_message .= "</tr>";
			}

			$OwnFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . $CurrentUser['id'] . "';", 'fleets');

			$Record = 0;

			while ($FleetRow = mysql_fetch_array($OwnFleets))
			{
				$Record++;

				$StartTime 	= $FleetRow['fleet_start_time'];
				$StayTime 	= $FleetRow['fleet_end_stay'];
				$EndTime 	= $FleetRow['fleet_end_time'];
				/////// // ### LUCKY , CODES ARE BELOW
				$hedefgalaksi = $FleetRow['fleet_end_galaxy'];
				$hedefsistem = $FleetRow['fleet_end_system'];
				$hedefgezegen = $FleetRow['fleet_end_planet'];
				$mess = $FleetRow['fleet_mess'];
				$filogrubu = $FleetRow['fleet_group'];
				//////
				$Label = "fs";
				if ($StartTime > time())
				{
					$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
				}

				if(($FleetRow['fleet_mission'] <> 4) && ($FleetRow['fleet_mission'] <> 10))
				{
					$Label = "ft";

					if ($StayTime > time())
					{
						$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
					}
					$Label = "fe";

					if ($EndTime > time())
					{
						$fpage[$EndTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
					}
				}
			}
			mysql_free_result($OwnFleets);
			//iss ye katilan filo////////////////////////////////////

			// ### LUCKY , CODES ARE BELOW

			$dostfilo = doquery("SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '" . $hedefgalaksi . "' AND `fleet_end_system` = '" . $hedefsistem . "' AND `fleet_end_planet` = '" . $hedefgezegen . "' AND `fleet_group` = '" . $filogrubu . "';", 'fleets');
			$Record1 = 0;
			while ($FleetRow = mysql_fetch_array($dostfilo)) {


				$StartTime = $FleetRow['fleet_start_time'];
				$StayTime = $FleetRow['fleet_end_stay'];
				$EndTime = $FleetRow['fleet_end_time'];

				///////
				$hedefgalaksi = $FleetRow['fleet_end_galaxy'];
				$hedefsistem = $FleetRow['fleet_end_system'];
				$hedefgezegen = $FleetRow['fleet_end_planet'];
				$mess = $FleetRow['fleet_mess'];
				$filogrubu = $FleetRow['fleet_group'];
				///////
				if (($FleetRow['fleet_mission'] == 2) && ($FleetRow['fleet_owner'] != $CurrentUser['id'])) {
					$Record1++;
					//		if (($FleetRow['fleet_mission'] == 2) ){
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}

					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime] =$FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record1);
					}

					//	}
				} ///""

				if (($FleetRow['fleet_mission'] == 1) && ($FleetRow['fleet_owner'] != $CurrentUser['id']) && ($filogrubu > 0 ) ){
					$Record++;
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}
					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime] = $FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
					}

				}

			}
			mysql_free_result($dostfilo);
			//
			//////////////////////////////////////////////////

			$OtherFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '" . $CurrentUser['id'] . "';", 'fleets');

			$Record = 2000;
			while ($FleetRow = mysql_fetch_array($OtherFleets))
			{
				if ($FleetRow['fleet_owner'] != $CurrentUser['id'])
				{
					if ($FleetRow['fleet_mission'] != 8)
					{
						$Record++;
						$StartTime = $FleetRow['fleet_start_time'];
						$StayTime = $FleetRow['fleet_end_stay'];

						if ($StartTime > time())
						{
							$Label = "ofs";
							$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
						}
						if ($FleetRow['fleet_mission'] == 5)
						{
							$Label = "oft";
							if ($StayTime > time())
							{
								$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
							}
						}
					}
				}
			}
			mysql_free_result($OtherFleets);

			$planets_query = doquery("SELECT * FROM `{{table}}` WHERE id_owner='{$CurrentUser['id']}' AND `destruyed` = 0", "planets");
			$Colone  	= 1;
			$AllPlanets = "<tr>";
			while ($CurrentUserPlanet = mysql_fetch_array($planets_query))
			{
				if ($CurrentUserPlanet["id"] != $CurrentUser["current_planet"] && $CurrentUserPlanet['planet_type'] != 3)
				{
					$Coloneshow++;
					$AllPlanets .= "<th>". $CurrentUserPlanet['name'] ."<br>";
					$AllPlanets .= "<a href=\"game.php?page=overview&cp=". $CurrentUserPlanet['id'] ."&re=0\" title=\"". $CurrentUserPlanet['name'] ."\"><img src=\"". $dpath ."planeten/small/s_". $CurrentUserPlanet['image'] .".jpg\" height=\"50\" width=\"50\"></a><br>";
					$AllPlanets .= "<center>";

					if ($CurrentUserPlanet['b_building'] != 0)
					{
						UpdatePlanetBatimentQueueList ($CurrentUserPlanet, $CurrentUser);
						if ($CurrentUserPlanet['b_building'] != 0 )
						{
							$BuildQueue      = $CurrentUserPlanet['b_building_id'];
							$QueueArray      = explode ( ";", $BuildQueue );
							$CurrentBuild    = explode ( ",", $QueueArray[0] );
							$BuildElement    = $CurrentBuild[0];
							$BuildLevel      = $CurrentBuild[1];
							$BuildRestTime   = pretty_time( $CurrentBuild[3] - time() );
							$AllPlanets     .= '' . $lang['tech'][$BuildElement] . ' (' . $BuildLevel . ')';
							$AllPlanets     .= "<br><font color=\"#7f7f7f\">(". $BuildRestTime .")</font>";
						}
						else
						{
							CheckPlanetUsedFields ($CurrentUserPlanet);
							$AllPlanets     .= $lang['ov_free'];
						}
					}
					else
					{
						$AllPlanets    .= $lang['ov_free'];
					}

					$AllPlanets .= "</center></th>";

					if ($Colone <= 1)
						$Colone++;
					else
					{
						$AllPlanets .= "</tr><tr>";
						$Colone = 1;
					}
				}
			}
			mysql_free_result($planets_query);

			$AllPlanets .= "</tr>";

			if ($lunarow['id'] <> 0 && $lunarow['destruyed'] != 1 && $CurrentPlanet['planet_type'] != 3)
			{
				if ($CurrentPlanet['planet_type'] == 1 or $lunarow['id'] <> 0)
				{
					$moon = doquery ("SELECT `id`,`name`,`image` FROM {{table}} WHERE `galaxy` = '" . $CurrentPlanet['galaxy'] . "' AND `system` = '" . $CurrentPlanet['system'] . "' AND `planet` = '" . $CurrentPlanet['planet'] . "' AND `planet_type` = '3'", 'planets', true);
					$parse['moon_img'] = "<a href=\"game.php?page=overview&cp=" . $moon['id'] . "&re=0\" title=\"" . $moon['name'] . "\"><img src=\"" . $dpath . "planeten/" . $moon['image'] . ".jpg\" height=\"50\" width=\"50\"></a>";
					$parse['moon'] = $moon['name'] ." (" . $lang['fcm_moon'] . ")";
				}
				else
				{
					$parse['moon_img'] = "";
					$parse['moon'] = "";
				}
			}
			else
			{
				$parse['moon_img'] = "";
				$parse['moon'] = "";
			}

			$parse['planet_diameter'] 		= pretty_number($CurrentPlanet['diameter']);
			$parse['planet_field_current']  = $CurrentPlanet['field_current'];
			$parse['planet_field_max'] 		= CalculateMaxPlanetFields($CurrentPlanet);
			$parse['planet_temp_min'] 		= $CurrentPlanet['temp_min'];
			$parse['planet_temp_max'] 		= $CurrentPlanet['temp_max'];

			$StatRecord = doquery("SELECT `total_rank`,`total_points` FROM `{{table}}` WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $CurrentUser['id'] . "';", 'statpoints', true);

			$parse['user_username']        = $CurrentUser['username'];

			if (count($fpage) > 0)
			{
				ksort($fpage);
				foreach ($fpage as $time => $content)
				{
					$flotten .= $content . "\n";
				}
			}

			if ($CurrentPlanet['b_building'] != 0)
			{
				include($xgp_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

				UpdatePlanetBatimentQueueList ($planetrow, $user);
				if ($CurrentPlanet['b_building'] != 0)
				{
					$BuildQueue  		 = explode (";", $CurrentPlanet['b_building_id']);
					$CurrBuild 	 		 = explode (",", $BuildQueue[0]);
					$RestTime 	 		 = $CurrentPlanet['b_building'] - time();
					$PlanetID 	 		 = $CurrentPlanet['id'];
					$Build 		 		 = InsertBuildListScript ("overview");
					$Build 	   			.= $lang['tech'][$CurrBuild[0]] . ' (' . ($CurrBuild[1]) . ')';
					$Build 				.= "<br /><div id=\"blc\" class=\"z\">" . pretty_time($RestTime) . "</div>";
					$Build 				.= "\n<script language=\"JavaScript\">";
					$Build 				.= "\n	pp = \"" . $RestTime . "\";\n";
					$Build 				.= "\n	pk = \"" . 1 . "\";\n";
					$Build 				.= "\n	pm = \"cancel\";\n";
					$Build 				.= "\n	pl = \"" . $PlanetID . "\";\n";
					$Build 				.= "\n	t();\n";
					$Build 				.= "\n</script>\n";
					$parse['building'] 	 = $Build;
				}
				else
				{
					$parse['building'] = $lang['ov_free'];
				}
			}
			else
			{
				$parse['building'] = $lang['ov_free'];
			}

			$parse['fleet_list']  			= $flotten;
			$parse['Have_new_message'] 		= $Have_new_message;
			$parse['planet_image'] 			= $CurrentPlanet['image'];
			$parse['anothers_planets'] 		= $AllPlanets;
			$parse["dpath"] 				= $dpath;
			if($game_config['stat'] == 0)
				$parse['user_rank']			= pretty_number($StatRecord['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&range=".$StatRecord['total_rank']."\">".$StatRecord['total_rank']."</a> ". $lang['ov_of'] ." ".$game_config['users_amount'].")";
			elseif($game_config['stat'] == 1 && $CurrentUser['authlevel'] < $game_config['stat_level'])
				$parse['user_rank']			= pretty_number($StatRecord['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&range=".$StatRecord['total_rank']."\">".$StatRecord['total_rank']."</a> ". $lang['ov_of'] ." ".$game_config['users_amount'].")";
			else
				$parse['user_rank']			= "-";

			$parse['date_time']				= date("D M j H:i:s", time());
			$parse['server_notice']           	= stripslashes($game_config['server_notice']);
			return display(parsetemplate(gettemplate('overview/overview_body'), $parse));
			break;
	}
}
?>