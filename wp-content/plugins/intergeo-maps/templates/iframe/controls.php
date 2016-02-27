
<h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Controls', INTERGEO_PLUGIN_NAME ) ?></h3>
<ul class="intergeo_tlbr_ul_li_ul">
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Zoom control', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_zoomControl" value="0">
					<input type="checkbox" name="map_zoomControl" value="1" <?php checked( isset( $json['map']['zoomControl'] ) ? $json['map']['zoomControl'] == 1 : true ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The Zoom control displays a slider (for large maps) or small "+/-" buttons (for small maps) to control the zoom level of the map. This control appears by default in the top left corner of the map on non-touch devices or in the bottom left corner on touch devices.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_zoomControlOptions_position">
							<option value=""><?php esc_html_e( 'default position', INTERGEO_PLUGIN_NAME ) ?></option>
							<option value="TOP_LEFT" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'TOP_LEFT' : false ) ?>>
								<?php esc_html_e( 'Top Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_CENTER" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'TOP_CENTER' : false ) ?>>
								<?php esc_html_e( 'Top Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_RIGHT" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'TOP_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Top Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_TOP" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'RIGHT_TOP' : false ) ?>>
								<?php esc_html_e( 'Right Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_CENTER" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'RIGHT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Right Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_BOTTOM" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'RIGHT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Right Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_RIGHT" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'BOTTOM_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Bottom Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_CENTER" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'BOTTOM_CENTER' : false ) ?>>
								<?php esc_html_e( 'Bottom Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_LEFT" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'BOTTOM_LEFT' : false ) ?>>
								<?php esc_html_e( 'Bottom Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_BOTTOM" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'LEFT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Left Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_CENTER" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'LEFT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Left Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_TOP" <?php selected( isset( $json['map']['zoomControlOptions']['position'] ) ? $json['map']['zoomControlOptions']['position'] == 'LEFT_TOP' : false ) ?>>
								<?php esc_html_e( 'Left Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_zoomControlOptions_style">
							<option value="DEFAULT">
								<?php esc_html_e( 'default style', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="SMALL" <?php selected( isset( $json['map']['zoomControlOptions']['style'] ) ? $json['map']['zoomControlOptions']['style'] == 'SMALL' : false ) ?>>
								<?php esc_html_e( 'small', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LARGE" <?php selected( isset( $json['map']['zoomControlOptions']['style'] ) ? $json['map']['zoomControlOptions']['style'] == 'LARGE' : false ) ?>>
								<?php esc_html_e( 'large', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Pan control', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_panControl" value="0">
					<input type="checkbox" name="map_panControl" value="1" <?php checked( isset( $json['map']['panControl'] ) ? $json['map']['panControl'] == 1 : true ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The Pan control displays buttons for panning the map. This control appears by default in the top left corner of the map on non-touch devices. The Pan control also allows you to rotate 45° imagery, if available.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_panControlOptions_position">
							<option value=""><?php esc_html_e( 'default position', INTERGEO_PLUGIN_NAME ) ?></option>
							<option value="TOP_LEFT" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'TOP_LEFT' : false ) ?>>
								<?php esc_html_e( 'Top Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_CENTER" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'TOP_CENTER' : false ) ?>>
								<?php esc_html_e( 'Top Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_RIGHT" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'TOP_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Top Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_TOP" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'RIGHT_TOP' : false ) ?>>
								<?php esc_html_e( 'Right Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_CENTER" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'RIGHT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Right Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_BOTTOM" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'RIGHT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Right Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_RIGHT" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'BOTTOM_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Bottom Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_CENTER" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'BOTTOM_CENTER' : false ) ?>>
								<?php esc_html_e( 'Bottom Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_LEFT" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'BOTTOM_LEFT' : false ) ?>>
								<?php esc_html_e( 'Bottom Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_BOTTOM" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'LEFT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Left Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_CENTER" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'LEFT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Left Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_TOP" <?php selected( isset( $json['map']['panControlOptions']['position'] ) ? $json['map']['panControlOptions']['position'] == 'LEFT_TOP' : false ) ?>>
								<?php esc_html_e( 'Left Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">&nbsp;</td>
				</tr>
			</table>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Scale control', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_scaleControl" value="0">
					<input type="checkbox" name="map_scaleControl" value="1" <?php checked( isset( $json['map']['scaleControl'] ) ? $json['map']['scaleControl'] : false ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The Scale control displays a map scale element. This control is not enabled by default.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_scaleControlOptions_position">
							<option value=""><?php esc_html_e( 'default position', INTERGEO_PLUGIN_NAME ) ?></option>
							<option value="TOP_LEFT" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'TOP_LEFT' : false ) ?>>
								<?php esc_html_e( 'Top Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_CENTER" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'TOP_CENTER' : false ) ?>>
								<?php esc_html_e( 'Top Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_RIGHT" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'TOP_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Top Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_TOP" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'RIGHT_TOP' : false ) ?>>
								<?php esc_html_e( 'Right Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_CENTER" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'RIGHT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Right Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_BOTTOM" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'RIGHT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Right Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_RIGHT" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'BOTTOM_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Bottom Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_CENTER" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'BOTTOM_CENTER' : false ) ?>>
								<?php esc_html_e( 'Bottom Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_LEFT" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'BOTTOM_LEFT' : false ) ?>>
								<?php esc_html_e( 'Bottom Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_BOTTOM" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'LEFT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Left Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_CENTER" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'LEFT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Left Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_TOP" <?php selected( isset( $json['map']['scaleControlOptions']['position'] ) ? $json['map']['scaleControlOptions']['position'] == 'LEFT_TOP' : false ) ?>>
								<?php esc_html_e( 'Left Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">&nbsp;</td>
				</tr>
			</table>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'MapType control', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_mapTypeControl" value="0">
					<input type="checkbox" name="map_mapTypeControl" value="1" <?php checked( isset( $json['map']['mapTypeControl'] ) ? $json['map']['mapTypeControl'] : true ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The MapType control lets the user toggle between map types (such as roadmap and satellite). This control appears by default in the top right corner of the map.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_mapTypeControlOptions_position">
							<option value=""><?php esc_html_e( 'default position', INTERGEO_PLUGIN_NAME ) ?></option>
							<option value="TOP_LEFT" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'TOP_LEFT' : false ) ?>>
								<?php esc_html_e( 'Top Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_CENTER" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'TOP_CENTER' : false ) ?>>
								<?php esc_html_e( 'Top Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_RIGHT" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'TOP_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Top Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_TOP" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'RIGHT_TOP' : false ) ?>>
								<?php esc_html_e( 'Right Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_CENTER" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'RIGHT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Right Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_BOTTOM" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'RIGHT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Right Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_RIGHT" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'BOTTOM_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Bottom Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_CENTER" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'BOTTOM_CENTER' : false ) ?>>
								<?php esc_html_e( 'Bottom Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_LEFT" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'BOTTOM_LEFT' : false ) ?>>
								<?php esc_html_e( 'Bottom Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_BOTTOM" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'LEFT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Left Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_CENTER" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'LEFT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Left Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_TOP" <?php selected( isset( $json['map']['mapTypeControlOptions']['position'] ) ? $json['map']['mapTypeControlOptions']['position'] == 'LEFT_TOP' : false ) ?>>
								<?php esc_html_e( 'Left Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_mapTypeControlOptions_style">
							<option value="DEFAULT">
								<?php esc_html_e( 'default style', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="DROPDOWN_MENU" <?php selected( isset( $json['map']['mapTypeControlOptions']['style'] ) ? $json['map']['mapTypeControlOptions']['style'] == 'DROPDOWN_MENU' : false ) ?>>
								<?php esc_html_e( 'dropdown menu', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="HORIZONTAL_BAR" <?php selected( isset( $json['map']['mapTypeControlOptions']['style'] ) ? $json['map']['mapTypeControlOptions']['style'] == 'HORIZONTAL_BAR' : false ) ?>>
								<?php esc_html_e( 'horizontal bar', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
				</tr>
			</table>
			<div class="intergeo_tlbr_cntrl_item">
				<b><?php esc_html_e( 'Map types:', INTERGEO_PLUGIN_NAME ) ?></b>
			</div>
			<div class="intergeo_tlbr_cntrl_item">
				<label title="<?php esc_attr_e( 'This map type displays a normal street map.', INTERGEO_PLUGIN_NAME ) ?>">
					<input type="checkbox" name="map_mapTypeControlOptions_mapTypeIds[]" value="ROADMAP" <?php checked( isset( $json['map']['mapTypeControlOptions']['mapTypeIds'] ) ? in_array( 'ROADMAP', $json['map']['mapTypeControlOptions']['mapTypeIds'] ) : true ) ?>>
					<?php esc_html_e( 'Road map', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<div class="intergeo_tlbr_cntrl_item">
				<label title="<?php esc_attr_e( 'This map type displays maps with physical features such as terrain and vegetation.', INTERGEO_PLUGIN_NAME ) ?>">
					<input type="checkbox" name="map_mapTypeControlOptions_mapTypeIds[]" value="TERRAIN" <?php checked( isset( $json['map']['mapTypeControlOptions']['mapTypeIds'] ) ? in_array( 'TERRAIN', $json['map']['mapTypeControlOptions']['mapTypeIds'] ) : true ) ?>>
					<?php esc_html_e( 'Terrain', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<div class="intergeo_tlbr_cntrl_item">
				<label title="<?php esc_attr_e( 'This map type displays satellite images.', INTERGEO_PLUGIN_NAME ) ?>">
					<input type="checkbox" name="map_mapTypeControlOptions_mapTypeIds[]" value="SATELLITE" <?php checked( isset( $json['map']['mapTypeControlOptions']['mapTypeIds'] ) ? in_array( 'SATELLITE', $json['map']['mapTypeControlOptions']['mapTypeIds'] ) : true ) ?>>
					<?php esc_html_e( 'Satellite', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<div class="intergeo_tlbr_cntrl_item">
				<label title="<?php esc_attr_e( 'This map type displays a transparent layer of major streets on satellite images.', INTERGEO_PLUGIN_NAME ) ?>">
					<input type="checkbox" name="map_mapTypeControlOptions_mapTypeIds[]" value="HYBRID" <?php checked( isset( $json['map']['mapTypeControlOptions']['mapTypeIds'] ) ? in_array( 'HYBRID', $json['map']['mapTypeControlOptions']['mapTypeIds'] ) : true ) ?>>
					<?php esc_html_e( 'Hybrid', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Street View control', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_streetViewControl" value="0">
					<input type="checkbox" name="map_streetViewControl" value="1" <?php checked( isset( $json['map']['streetViewControl'] ) ? $json['map']['streetViewControl'] == 1 : true ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The Street View control contains a Pegman icon which can be dragged onto the map to enable Street View. This control appears by default in the top left corner of the map.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_streetViewControlOptions_position">
							<option value=""><?php esc_html_e( 'default position', INTERGEO_PLUGIN_NAME ) ?></option>
							<option value="TOP_LEFT" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'TOP_LEFT' : false ) ?>>
								<?php esc_html_e( 'Top Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_CENTER" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'TOP_CENTER' : false ) ?>>
								<?php esc_html_e( 'Top Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_RIGHT" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'TOP_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Top Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_TOP" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'RIGHT_TOP' : false ) ?>>
								<?php esc_html_e( 'Right Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_CENTER" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'RIGHT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Right Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_BOTTOM" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'RIGHT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Right Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_RIGHT" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'BOTTOM_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Bottom Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_CENTER" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'BOTTOM_CENTER' : false ) ?>>
								<?php esc_html_e( 'Bottom Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_LEFT" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'BOTTOM_LEFT' : false ) ?>>
								<?php esc_html_e( 'Bottom Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_BOTTOM" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'LEFT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Left Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_CENTER" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'LEFT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Left Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_TOP" <?php selected( isset( $json['map']['streetViewControlOptions']['position'] ) ? $json['map']['streetViewControlOptions']['position'] == 'LEFT_TOP' : false ) ?>>
								<?php esc_html_e( 'Left Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">&nbsp;</td>
				</tr>
			</table>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Rotate control', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_rotateControl" value="0">
					<input type="checkbox" name="map_rotateControl" value="1" <?php checked( isset( $json['map']['rotateControl'] ) ? $json['map']['rotateControl'] == 1 : true ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The Rotate control contains a small circular icon which allows you to rotate maps containing oblique imagery. This control appears by default in the top left corner of the map.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<select class="intergeo_tlbr_cntrl_slct" name="map_rotateControlOptions_position">
							<option value=""><?php esc_html_e( 'default position', INTERGEO_PLUGIN_NAME ) ?></option>
							<option value="TOP_LEFT" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'TOP_LEFT' : false ) ?>>
								<?php esc_html_e( 'Top Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_CENTER" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'TOP_CENTER' : false ) ?>>
								<?php esc_html_e( 'Top Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="TOP_RIGHT" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'TOP_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Top Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_TOP" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'RIGHT_TOP' : false ) ?>>
								<?php esc_html_e( 'Right Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_CENTER" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'RIGHT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Right Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="RIGHT_BOTTOM" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'RIGHT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Right Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_RIGHT" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'BOTTOM_RIGHT' : false ) ?>>
								<?php esc_html_e( 'Bottom Right', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_CENTER" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'BOTTOM_CENTER' : false ) ?>>
								<?php esc_html_e( 'Bottom Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="BOTTOM_LEFT" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'BOTTOM_LEFT' : false ) ?>>
								<?php esc_html_e( 'Bottom Left', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_BOTTOM" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'LEFT_BOTTOM' : false ) ?>>
								<?php esc_html_e( 'Left Bottom', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_CENTER" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'LEFT_CENTER' : false ) ?>>
								<?php esc_html_e( 'Left Center', INTERGEO_PLUGIN_NAME ) ?>
							</option>
							<option value="LEFT_TOP" <?php selected( isset( $json['map']['rotateControlOptions']['position'] ) ? $json['map']['rotateControlOptions']['position'] == 'LEFT_TOP' : false ) ?>>
								<?php esc_html_e( 'Left Top', INTERGEO_PLUGIN_NAME ) ?>
							</option>
						</select>
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">&nbsp;</td>
				</tr>
			</table>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Overview Map control', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_overviewMapControl" value="0">
					<input type="checkbox" name="map_overviewMapControl" value="1" <?php checked( isset( $json['map']['overviewMapControl'] ) ? $json['map']['overviewMapControl'] == 1 : false ) ?>>
					<?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The Overview Map control displays a thumbnail overview map reflecting the current map viewport within a wider area. This control appears by default in the bottom right corner of the map, and is by default shown in its collapsed state.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<label>
					<input type="hidden" name="map_overviewMapControlOptions_opened" value="0">
					<input type="checkbox" name="map_overviewMapControlOptions_opened" value="1" <?php checked( isset( $json['map']['overviewMapControlOptions']['opened'] ) ? $json['map']['overviewMapControlOptions']['opened'] == 1 : false ) ?>>
					<?php esc_html_e( 'Opened', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
		</div>
	</li>
</ul>