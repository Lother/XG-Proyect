<br />
<div id="content">
    <table width="519">
        <tr>
        	<td class="c" colspan="4"><a href="game.php?page=overview&mode=renameplanet" title="{Planet_menu}">{ov_planet} "{planet_name}"</a> ({user_username})</td>
        </tr>
            {Have_new_message}
        <tr>
        	<th>{ov_server_time}</th>
        	<th colspan="3">{date_time}</th>
        </tr>
		<tr>
        	<td colspan="4" align=center>
				<div onClick="config.style.display=config.style.display=='none'?'':'none';notice.style.display='none'">
					<b><font color=#FFFFFF style="font-size=20;text-decoration:underline;">
						{ov_server_config}
					</font></b>
				</div>
				<div id="config" style="display:none;"><HR>
				{config_page}
				</div>
			</td>
        </tr>
        <tr>
        	<th>{ov_server_notice}</th>
        	<th colspan="3">{server_notice}</th>
        </tr>
        <tr>
        	<td colspan="4" class="c">{ov_events}</td>
        </tr>
        	{fleet_list}
        <tr>
        	<th>{moon_img}<br>{moon}</th>
        	<th colspan="2"><img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200"><br>{building}</th>
        	<th class="s">
            	<table class="s" align="top" border="0">
                	<tr>{anothers_planets}</tr>
               </table>
            </th>
        </tr>
        <tr>
            <th>{ov_diameter}</th>
            <th colspan="3">{planet_diameter} {ov_distance_unit} (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> {fields})</th>
        </tr>
        <tr>
            <th>{ov_temperature}</th>
            <th colspan="3">{ov_aprox} {planet_temp_min}{ov_temp_unit} {ov_to} {planet_temp_max}{ov_temp_unit}</th>
        </tr>
        <tr>
            <th>{ov_position}</th>
            <th colspan="3"><a href="game.php?page=galaxy&mode=0&galaxy={galaxy_galaxy}&system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a></th>
        </tr>
        <tr>
            <th>{ov_points}</th>
            <th colspan="3">{user_rank}</td>
        </tr>
    </table>
</div>