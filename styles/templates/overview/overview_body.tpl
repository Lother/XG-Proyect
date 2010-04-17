<br />
<div id="content">
    <table width="600">
        <tr>
        	<td class="c" colspan="4"><a href="game.php?page=overview&mode=renameplanet" title="{Planet_menu}">{ov_planet} "{planet_name}"</a> ({user_username})</td>
        </tr>
            {Have_new_message}
        <tr>
        	<th width="96">{ov_server_time}</th>
        	<th colspan="3">{date_time}</th>
        </tr>
		<tr>
        	<td class="c" colspan="4" >
				{ov_server_config}
			<td>
        </tr>
		<tr>
			<td align=center>{ov_general_speed}</td>
			<td align=center>{game_speed}{ov_x}</td>
			<td align=center>{ov_resources_producion_speed}</td>
			<td align=center>{resource_multiplier}{ov_x}</td>
		</tr>
		<tr>
			<td align=center>{ov_fleet_speed}</td>
			<td align=center>{fleet_speed}{ov_x}</td>
			<td align=center>{ov_Cdr}</td>
			<td align=center>{Fleet_Cdr}/{Defs_Cdr}</td>
		</tr>
		<tr>
			<td align=center>{ov_time_between_updates}</td>
			<td align=center>{stat_update_time}{ov_n}</th>
			<td align=center>{ov_time_last_updates}</td>
			<td align=center>{stat_last_update}</td>
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