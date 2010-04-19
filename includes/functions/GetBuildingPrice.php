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

	function GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false)
	{
		global $pricelist, $resource;

		if ($Incremental)
		{
			if(!isset($CurrentPlanet[$resource[$Element]]))$CurrentPlanet[$resource[$Element]]=0;
			if(!isset($CurrentUser[$resource[$Element]]))$CurrentUser[$resource[$Element]]=0;
			$level = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];
		}

		$array = array('metal', 'crystal', 'deuterium', 'energy_max');
		foreach ($array as $ResType)
		{
			if(!isset($pricelist[$Element][$ResType]))$pricelist[$Element][$ResType]=0;
			if ($Incremental)
				$cost[$ResType] = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			else
				$cost[$ResType] = floor($pricelist[$Element][$ResType]);

			if ($ForDestroy == true)
			{
				$cost[$ResType]  = floor($cost[$ResType]) / 2;
				$cost[$ResType] /= 2;
			}
		}

		return $cost;
	};
	
	function GetRestPrice ($user, $planet, $Element, $userfactor = true)
	{
		global $pricelist, $resource, $lang;

		if ($userfactor)
		{
			if(!isset($user[$resource[$Element]]))$user[$resource[$Element]]=0;
			if(!isset($planet[$resource[$Element]]))$planet[$resource[$Element]]=0;
			$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
		}

		$array = array(
		'metal'      => $lang['Metal'],
		'crystal'    => $lang['Crystal'],
		'deuterium'  => $lang['Deuterium'],
		'energy_max' => $lang['Energy']
		);

		$text  = "<br><font color=\"#7f7f7f\">" . $lang['bd_remaining'] . ": ";
		foreach ($array as $ResType => $ResTitle)
		{
			if (isset($pricelist[$Element][$ResType]))
			{
				$text .= $ResTitle . ": ";
				if ($userfactor)
				{
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				else
				{
					$cost = floor($pricelist[$Element][$ResType]);
				}
				if ($cost > $planet[$ResType])
				{
					$text .= "<b style=\"color: rgb(127, 95, 96);\">". pretty_number($planet[$ResType] - $cost) ."</b> ";
				}
				else
				{
					$text .= "<b style=\"color: rgb(95, 127, 108);\">". pretty_number($planet[$ResType] - $cost) ."</b> ";
				}
			}
		}
		$text .= "</font>";

		return $text;
	}
?>
