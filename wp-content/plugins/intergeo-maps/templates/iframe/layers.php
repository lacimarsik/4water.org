<h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Layers', INTERGEO_PLUGIN_NAME ) ?></h3>
<ul class="intergeo_tlbr_ul_li_ul">
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Traffic layer', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="layer_traffic" value="0">
					<input type="checkbox" name="layer_traffic" value="1" <?php checked( isset( $json['layer']['traffic'] ) ? $json['layer']['traffic'] == 1 : false ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php printf( esc_html__( 'Allows you to add real-time traffic information (where supported) to your map. Traffic information is provided for the time at which the request is made. Consult %s this spreadsheet %s to determine traffic coverage support.', INTERGEO_PLUGIN_NAME ), '<a href="http://gmaps-samples.googlecode.com/svn/trunk/mapcoverage_filtered.html" target="_blank">', '</a>' ) ?>
			</p>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Bicycling layer', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="layer_bicycling" value="0">
					<input type="checkbox" name="layer_bicycling" value="1" <?php checked( isset( $json['layer']['bicycling'] ) ? $json['layer']['bicycling'] == 1 : false ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'Allows you to add bicycle information to your map. It renders a layer of bike paths, suggested bike routes and other overlays specific to bicycling usage on top of the given map. Additionally, the layer alters the style of the base map itself to emphasize streets supporting bicycle routes and de-emphasize streets inappropriate for bicycles.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Weather & Cloud layers', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="layer_cloud" value="0">
					<input type="checkbox" name="layer_cloud" value="1" <?php checked( isset( $json['layer']['cloud'] ) ? $json['layer']['cloud'] == 1 : false ) ?>>
					<?php esc_html_e( 'Enabled cloud', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'Allows you to add the display of cloud imagery on your map. Enabling the cloud layer will add cloud coverage imagery to your map, visible at low zoom levels.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="layer_weather" value="0">
					<input type="checkbox" name="layer_weather" value="1" <?php checked( isset( $json['layer']['weather'] ) ? $json['layer']['weather'] == 1 : false ) ?>>
					<?php esc_html_e( 'Enabled weather', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'Allows you to add the display of weather data on your map. Enabling the weather layer will show current weather conditions from weather.com on your map, including icons that denote sun, clouds, rain and so on.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="weather_temperatureUnits">
							<option value="">
								<?php esc_html_e( 'temperature units', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="CELSIUS" <?php selected( isset( $json['weather']['temperatureUnits'] ) ? $json['weather']['temperatureUnits'] == 'CELSIUS' : false ) ?>>
								<?php esc_html_e( 'Celsius', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="FAHRENHEIT" <?php selected( isset( $json['weather']['temperatureUnits'] ) ? $json['weather']['temperatureUnits'] == 'FAHRENHEIT' : false ) ?>>
								<?php esc_html_e( 'Fahrenheit', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="weather_windSpeedUnits">
							<option value="">
								<?php esc_html_e( 'wind speed units', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="KILOMETERS_PER_HOUR" <?php selected( isset( $json['weather']['windSpeedUnits'] ) ? $json['weather']['windSpeedUnits'] == 'KILOMETERS_PER_HOUR' : false ) ?>>
								<?php esc_html_e( 'kilometers per hour', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="METERS_PER_SECOND" <?php selected( isset( $json['weather']['windSpeedUnits'] ) ? $json['weather']['windSpeedUnits'] == 'METERS_PER_SECOND' : false ) ?>>
								<?php esc_html_e( 'meters per second', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="MILES_PER_HOUR" <?php selected( isset( $json['weather']['windSpeedUnits'] ) ? $json['weather']['windSpeedUnits'] == 'MILES_PER_HOUR' : false ) ?>>
								<?php esc_html_e( 'miles per hour', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Panoramio layer', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="layer_panoramio" value="0">
					<input type="checkbox" name="layer_panoramio" value="1" <?php checked( isset( $json['layer']['panoramio'] ) ? $json['layer']['panoramio'] == 1 : false ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'Allows you to add photos from Panoramio as a layer to your map. It renders a layer of geotagged photo icons from Panoramio on the map as a series of large and small photo icons.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<?php esc_html_e( 'Restricting photos by tag', INTERGEO_PLUGIN_NAME ) ?>
				<input type="text" name="panoramio_tag" class="intergeo_tlbr_cntrl_txt intergeo_tlbr_cntrl_onkeyup" value="<?php echo isset( $json['panoramio']['tag'] ) ? esc_attr( $json['panoramio']['tag'] ) : ''  ?>">
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'Allows you to restrict the set of photos to display on the map to those matching a certain textual tag.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<?php esc_html_e( 'Restricting photos by user id', INTERGEO_PLUGIN_NAME ) ?>
				<input type="text" name="panoramio_userId" class="intergeo_tlbr_cntrl_txt intergeo_tlbr_cntrl_onkeyup" value="<?php echo isset( $json['panoramio']['userId'] ) ? esc_attr( $json['panoramio']['userId'] ) : ''  ?>">
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'Allows you to restrict the set of photos to display on the map to those matching a particular user.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
		</div>
	</li>

<?php
    // Added by Ash/Upwork
    if( defined( 'IntergeoMaps_Pro' ) ){
        global $IntergeoMaps_Pro;
        $IntergeoMaps_Pro->addForm("layers", $json);
    }else{
?>
    <li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Custom layer', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
                <p class="intergeo_tlbr_grp_dsc">
                    <a>Custom Layers are available in the PRO version</a>
                </p>
            </div>
        </div>
    </li>
<?php
    }
    // Added by Ash/Upwork
?>
</ul>