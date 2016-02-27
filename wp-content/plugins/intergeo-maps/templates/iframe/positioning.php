<h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Positioning & Zooming', INTERGEO_PLUGIN_NAME ) ?></h3>
<ul class="intergeo_tlbr_ul_li_ul">
	<li class="intergeo_tlbr_ul_li_ul_li">
		<p class="intergeo_tlbr_grp_dsc">
			<?php esc_html_e( 'If you want to set specific map position and certain level of zooming, just set it up on preview map and these settings will be remembered at published map.', INTERGEO_PLUGIN_NAME ) ?>
		</p>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Positioning', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<?php esc_html_e( 'The initial map type', INTERGEO_PLUGIN_NAME ) ?>
				<select name="map_mapTypeId" class="intergeo_tlbr_cntrl_slct">
					<option value="ROADMAP" <?php selected( isset( $json['map']['mapTypeId'] ) ? $json['map']['mapTypeId'] == 'ROADMAP' : false ) ?>>
						<?php esc_html_e( 'Road map', INTERGEO_PLUGIN_NAME ) ?>
					</option>
					<option value="TERRAIN" <?php selected( isset( $json['map']['mapTypeId'] ) ? $json['map']['mapTypeId'] == 'TERRAIN' : false ) ?>>
						<?php esc_html_e( 'Terrain', INTERGEO_PLUGIN_NAME ) ?>
					</option>
					<option value="SATELLITE" <?php selected( isset( $json['map']['mapTypeId'] ) ? $json['map']['mapTypeId'] == 'SATELLITE' : false ) ?>>
						<?php esc_html_e( 'Satellite', INTERGEO_PLUGIN_NAME ) ?>
					</option>
					<option value="HYBRID" <?php selected( isset( $json['map']['mapTypeId'] ) ? $json['map']['mapTypeId'] == 'HYBRID' : false ) ?>>
						<?php esc_html_e( 'Hybrid', INTERGEO_PLUGIN_NAME ) ?>
					</option>
				</select>
			</div>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_draggable" value="0">
					<input type="checkbox" name="map_draggable" value="1" <?php checked( isset( $json['map']['draggable'] ) ? $json['map']['draggable'] : true ) ?>>
					<?php esc_html_e( 'Draggable map', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'If unchecked prevents the map from being dragged. Dragging is enabled by default.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Zooming', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<?php esc_html_e( 'Zoom range values', INTERGEO_PLUGIN_NAME ) ?>
			</div>
			<table class="intergeo_tlbr_cntrl_tbl" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<input type="number" class="intergeo_tlbr_cntrl_txt" min="0" max="19" name="map_minZoom" value="<?php echo isset( $json['map']['minZoom'] ) ? intval( $json['map']['minZoom'] ) : 0 ?>">
					</td>
					<td class="intergeo_tlbr_cntrl_tbl_clmn">
						<input type="number" class="intergeo_tlbr_cntrl_txt" min="0" max="19" name="map_maxZoom" value="<?php echo isset( $json['map']['maxZoom'] ) ? intval( $json['map']['maxZoom'] ) : 19 ?>">
					</td>
				</tr>
			</table>				
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The maximum (19) and minimum (0) zoom levels which could be displayed on the map.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="map_scrollwheel" value="0">
					<input type="checkbox" name="map_scrollwheel" value="1" <?php checked( isset( $json['map']['scrollwheel'] ) ? $json['map']['scrollwheel'] == 1 : true ) ?>>
					<?php esc_html_e( 'Scrollwheel zooming', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'Determines if scrollwheel zooming is enabled on the map.', INTERGEO_PLUGIN_NAME ) ?>
			</p>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Preview settings', INTERGEO_PLUGIN_NAME ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="checkbox" id="intergeo_map_lock_preview" value="1">
					<?php esc_html_e( 'Lock preview', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( "Lock preview map to preserve changing of the viewport bounds and zoom level. Locking affects only on preview map and won't lock embedded map.", INTERGEO_PLUGIN_NAME ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="checkbox" id="intergeo_show_map_center" value="1" <?php checked( $show_map_center ) ?>>
					<?php esc_html_e( 'Show map center', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( "Show small red circle at the center of the map. It helps you to centralize the map bounds. Note that this option won't be displayed at frontend.", INTERGEO_PLUGIN_NAME ) ?>
			</p>
		</div>
	</li>
</ul>