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

function ShowFleet2Page($CurrentUser, $CurrentPlanet)
{
	global $resource, $pricelist, $reslist, $phpEx, $lang;
	if(!isset($_POST['ship202']))$_POST['ship202']=0;
	if(!isset($_POST['ship203']))$_POST['ship203']=0;
	if(!isset($_POST['ship204']))$_POST['ship204']=0;
	if(!isset($_POST['ship205']))$_POST['ship205']=0;
	if(!isset($_POST['ship206']))$_POST['ship206']=0;
	if(!isset($_POST['ship207']))$_POST['ship207']=0;
	if(!isset($_POST['ship208']))$_POST['ship208']=0;
	if(!isset($_POST['ship209']))$_POST['ship209']=0;
	if(!isset($_POST['ship210']))$_POST['ship210']=0;
	if(!isset($_POST['ship211']))$_POST['ship211']=0;
	if(!isset($_POST['ship212']))$_POST['ship212']=0;
	if(!isset($_POST['ship213']))$_POST['ship213']=0;
	if(!isset($_POST['ship214']))$_POST['ship214']=0;
	if(!isset($_POST['ship215']))$_POST['ship215']=0;
	if(!isset($_POST['ship216']))$_POST['ship216']=0;
	if(!isset($_POST['ship217']))$_POST['ship217']=0;
	if(!isset($_POST['ship218']))$_POST['ship218']=0;
	if(!isset($_POST['ship219']))$_POST['ship219']=0;
	if(!isset($_POST['ship220']))$_POST['ship220']=0;
	if(!isset($_POST['ship221']))$_POST['ship221']=0;
	if(!isset($_POST['ship222']))$_POST['ship222']=0;
	if(!isset($_POST['ship223']))$_POST['ship223']=0;
	if(!isset($_POST['ship224']))$_POST['ship224']=0;
	if(!isset($_POST['ship225']))$_POST['ship225']=0;
	if(!isset($_POST['ship226']))$_POST['ship226']=0;
	$parse			= $lang;
	$galaxy     	= intval($_POST['galaxy']);
	$system     	= intval($_POST['system']);
	$planet     	= intval($_POST['planet']);
	$planettype 	= intval($_POST['planettype']);
	$fleet_group_mr = intval($_POST['fleet_group']);

	$YourPlanet 	= false;
	$UsedPlanet 	= false;
	$select       	= doquery("SELECT `id_owner`,`galaxy`,`system`,`planet`,`planet_type` FROM `{{table}}`", "planets");

	while ($row = mysql_fetch_array($select))
	{
		if ($galaxy == $row['galaxy'] && $system == $row['system'] && $planet == $row['planet'] && $planettype == $row['planet_type'])
		{
			if ($row['id_owner'] == $CurrentUser['id'])
			{
				$YourPlanet = true;
				$UsedPlanet = true;
			}
			else
				$UsedPlanet = true;

			break;
		}
	}

	if ($_POST['planettype'] == 2)
	{
		if ($_POST['ship209'] >= 1)
			$missiontype = array(8 => $lang['type_mission'][8]);
		else
			$missiontype = array();
	}
	elseif ($_POST['planettype'] == 1 or $_POST['planettype'] == 3)
	{
		if ($_POST['ship208'] >= 1 && !$UsedPlanet)
			$missiontype = array(7 => $lang['type_mission'][7]);
		elseif ($_POST['ship210'] >= 1 && !$YourPlanet)
			$missiontype = array(6 => $lang['type_mission'][6]);

		if ($_POST['ship202'] >= 1 ||
			$_POST['ship203'] >= 1 ||
			$_POST['ship204'] >= 1 ||
			$_POST['ship205'] >= 1 ||
			$_POST['ship206'] >= 1 ||
			$_POST['ship207'] >= 1 ||
			$_POST['ship210'] >= 1 ||
			$_POST['ship211'] >= 1 ||
			$_POST['ship213'] >= 1 ||
			$_POST['ship214'] >= 1 ||
			$_POST['ship215'] >= 1 ||
			$_POST['ship216'] >= 1 ||
			$_POST['ship217'] >= 1 ||
			$_POST['ship218'] >= 1 ||
			$_POST['ship219'] >= 1 ||
			$_POST['ship220'] >= 1 ||
			$_POST['ship221'] >= 1 ||
			$_POST['ship222'] >= 1 ||
			$_POST['ship223'] >= 1 ||
			$_POST['ship224'] >= 1 ||
			$_POST['ship225'] >= 1 ||
		$_POST['ship226'] >= 1) {

			if (!$YourPlanet)
				$missiontype[1] = $lang['type_mission'][1];

			$missiontype[3] = $lang['type_mission'][3];
			$missiontype[5] = $lang['type_mission'][5];
		}
	}
	elseif ($_POST['ship209'] >= 1 || $_POST['ship208'])
		$missiontype[3] = $lang['type_mission'][3];

	if ($YourPlanet)
		$missiontype[4] = $lang['type_mission'][4];

	if (($_POST['planettype'] == 3 || $_POST['planettype'] == 1) && ($fleet_group_mr > 0) && ($UsedPlanet))
	{
		$missiontype[2] = $lang['type_mission'][2];
	}

	if($_POST['planettype'] == 3 && $_POST['ship214'] >= 1 && !$YourPlanet && $UsedPlanet && $CurrentUser['rpg_empereur'] == 1)
		$missiontype[9] = $lang['type_mission'][9];

	$fleetarray    		= unserialize(base64_decode(str_rot13($_POST["usedfleet"])));
	$mission       		= $_POST['target_mission'];
	$SpeedFactor   		= $_POST['speedfactor'];
	$AllFleetSpeed 		= GetFleetMaxSpeed ($fleetarray, 0, $CurrentUser);
	$GenFleetSpeed 		= $_POST['speed'];
	$MaxFleetSpeed 		= min($AllFleetSpeed);
	$distance      		= GetTargetDistance($_POST['thisgalaxy'], $_POST['galaxy'], $_POST['thissystem'], $_POST['system'], $_POST['thisplanet'], $_POST['planet']);
	$duration      		= GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $SpeedFactor);
	$consumption   		= GetFleetConsumption($fleetarray, $SpeedFactor, $duration, $distance, $MaxFleetSpeed, $CurrentUser);
	$MissionSelector	= "";

	if (count($missiontype) > 0)
	{
		if ($planet == 16)
		{
			$MissionSelector .= "<tr height=\"20\">";
			$MissionSelector .= "<th>";
			$MissionSelector .= "<input type=\"radio\" name=\"mission\" value=\"15\" checked=\"checked\">". $lang['type_mission'][15] ."<br /><br />";
			$MissionSelector .= "<font color=\"red\">".$lang['fl_expedition_alert_message']."</font>";
			$MissionSelector .= "</th>";
			$MissionSelector .= "</tr>";
		}
		else
		{
			$i = 0;
			foreach ($missiontype as $a => $b)
			{
				$MissionSelector .= "<tr height=\"20\">";
				$MissionSelector .= "<th>";
				$MissionSelector .= "<input id=\"inpuT_".$i."\" type=\"radio\" name=\"mission\" value=\"".$a."\"". ($mission == $a ? " checked=\"checked\"":"") .">";
				$MissionSelector .= "<label for=\"inpuT_".$i."\">".$b."</label><br>";
				$MissionSelector .= "</th>";
				$MissionSelector .= "</tr>";
				$i++;
			}
		}
	}
	else
	{
		header("location:game.php?page=fleet");
	}

	if($_POST['thisplanettype'] == 1)
		$parse['title'] = "". $_POST['thisgalaxy'] .":". $_POST['thissystem'] .":". $_POST['thisplanet'] ." - ".$lang['fl_planet']."";
	elseif ($_POST['thisplanettype'] == 3)
		$parse['title'] = "". $_POST['thisgalaxy'] .":". $_POST['thissystem'] .":". $_POST['thisplanet'] ." - ".$lang['fl_moon']."";

	$parse['metal'] 			= floor($CurrentPlanet["metal"]);
	$parse['crystal'] 			= floor($CurrentPlanet["crystal"]);
	$parse['deuterium'] 		= floor($CurrentPlanet["deuterium"]);
	$parse['consumption'] 		= $consumption;
	$parse['distance']			= $distance;
	$parse['speedfactor'] 		= $_POST['speedfactor'];
	$parse['thisgalaxy'] 		= $_POST["thisgalaxy"];
	$parse['thissystem'] 		= $_POST["thissystem"];
	$parse['thisplanet'] 		= $_POST["thisplanet"];
	$parse['galaxy'] 			= $_POST["galaxy"];
	$parse['system'] 			= $_POST["system"];
	$parse['planet'] 			= $_POST["planet"];
	$parse['thisplanettype']	= $_POST["thisplanettype"];
	$parse['planettype'] 		= $_POST["planettype"];
	$parse['speedallsmin'] 		= $_POST["speedallsmin"];
	$parse['speed'] 			= $_POST['speed'];
	$parse['speedfactor'] 		= $_POST["speedfactor"];
	$parse['usedfleet'] 		= $_POST["usedfleet"];
	$parse['maxepedition'] 		= $_POST['maxepedition'];
	$parse['curepedition'] 		= $_POST['curepedition'];
	$parse['fleet_group'] 		= $_POST['fleet_group'];
	$parse['acs_target_mr'] 	= $_POST['acs_target_mr'];

	foreach ($fleetarray as $Ship => $Count)
	{
		if(!isset($input_extra))$input_extra="";
		$input_extra .= "<input type=\"hidden\" name=\"ship". $Ship ."\"        value=\"". $Count ."\" />\n";
		$input_extra .= "<input type=\"hidden\" name=\"capacity". $Ship ."\"    value=\"". $pricelist[$Ship]['capacity'] ."\" />\n";
		$input_extra .= "<input type=\"hidden\" name=\"consumption". $Ship ."\" value=\"". GetShipConsumption ( $Ship, $CurrentUser ) ."\" />\n";
		$input_extra .= "<input type=\"hidden\" name=\"speed". $Ship ."\"       value=\"". GetFleetMaxSpeed ( "", $Ship, $CurrentUser ) ."\" />\n";
	}

	$parse['input_extra'] 			= $input_extra;
	$parse['missionselector'] 		= $MissionSelector;
	if(!isset($StayBlock))$StayBlock="";
	if ($planet == 16)
	{
		$StayBlock .= "<tr height=\"20\">";
		$StayBlock .= "<td class=\"c\" colspan=\"3\">".$lang['fl_hold_time']."</td>";
		$StayBlock .= "</tr>";
		$StayBlock .= "<tr height=\"20\">";
		$StayBlock .= "<th colspan=\"3\">";
		$StayBlock .= "<select name=\"expeditiontime\" >";
		$StayBlock .= "<option value=\"1\">1</option>";
		$StayBlock .= "<option value=\"2\">2</option>";
		$StayBlock .= "</select>";
		$StayBlock .= "hora(s)";
		$StayBlock .= "</th>";
		$StayBlock .= "</tr>";
	}
	elseif($missiontype[5] != '')
	{
		$StayBlock .= "<tr height=\"20\">";
		$StayBlock .= "<td class=\"c\" colspan=\"3\">".$lang['fl_hold_time']."</td>";
		$StayBlock .= "</tr>";
		$StayBlock .= "<tr height=\"20\">";
		$StayBlock .= "<th colspan=\"3\">";
		$StayBlock .= "<select name=\"holdingtime\" >";
		$StayBlock .= "<option value=\"0\">0</option>";
		$StayBlock .= "<option value=\"1\">1</option>";
		$StayBlock .= "<option value=\"2\">2</option>";
		$StayBlock .= "<option value=\"4\">4</option>";
		$StayBlock .= "<option value=\"8\">8</option>";
		$StayBlock .= "<option value=\"16\">16</option>";
		$StayBlock .= "<option value=\"32\">32</option>";
		$StayBlock .= "</select>";
		$StayBlock .= "hora(s)";
		$StayBlock .= "</th>";
		$StayBlock .= "</tr>";
	}
	$parse['stayblock'] = $StayBlock;
	display(parsetemplate(gettemplate('fleet/fleet2_table'), $parse));
}
?>