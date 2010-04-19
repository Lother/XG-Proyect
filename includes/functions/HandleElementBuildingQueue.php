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

	function HandleElementBuildingQueue ( $CurrentUser, &$CurrentPlanet, $ProductionTime )
	{
		global $resource;

		if ($CurrentPlanet['b_hangar_id'] != 0)
		{
			$Builded                    = array ();
			$CurrentPlanet['b_hangar'] += $ProductionTime;
			$BuildQueue                 = explode(';', $CurrentPlanet['b_hangar_id']);

			foreach ($BuildQueue as $Node => $Array)
			{
				if ($Array != '')
				{
					if(!isset($AcumTime))$AcumTime=0;
					$Item              = explode(',', $Array);
					$AcumTime		   += GetBuildingTime ($CurrentUser, $CurrentPlanet, $Item[0]);
					$BuildArray[$Node] = array($Item[0], $Item[1], $AcumTime);
				}
			}

			$CurrentPlanet['b_hangar_id'] 	= '';
			$UnFinished 					= false;

			foreach ( $BuildArray as $Node => $Item )
			{
				if (!$UnFinished)
				{
					$Element   = $Item[0];
					$Count     = $Item[1];
					$BuildTime = $Item[2];
					while ( $CurrentPlanet['b_hangar'] >= $BuildTime && !$UnFinished )
					{
						if ( $Count > 0 )
						{
							if(!isset($CurrentPlanet['b_hangar']))$CurrentPlanet['b_hangar']=0;
							$CurrentPlanet['b_hangar'] -= $BuildTime;
							if(!isset($Builded[$Element]))$Builded[$Element]=0;
							$Builded[$Element]++;
							$CurrentPlanet[$resource[$Element]]++;
							$Count--;
							if ($Count == 0)
							{
								break;
							}
						}
						else
						{
							$UnFinished = true;
							break;
						}
					}
				}
				if ( $Count != 0 )
				{
					$CurrentPlanet['b_hangar_id'] .= $Element.",".$Count.";";
				}
			}
		}
		else
		{
			$Builded                   = '';
			$CurrentPlanet['b_hangar'] = 0;
		}

		return $Builded;
	}
?>