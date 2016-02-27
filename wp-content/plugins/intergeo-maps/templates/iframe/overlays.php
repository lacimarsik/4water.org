<h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Overlays', INTERGEO_PLUGIN_NAME ) ?></h3>
<ul class="intergeo_tlbr_ul_li_ul">
	<li class="intergeo_tlbr_li_ul_li">
		<p class="intergeo_tlbr_grp_dsc">
			<?php esc_html_e( 'Drawing tools allows you to add overlays over the map. You can add markers, polylines, polygons, circles and rectangles. To enable drawing tools just put a tick in the checkbox below.', INTERGEO_PLUGIN_NAME ) ?>
		</p>
		<p class="intergeo_tlbr_grp_dsc">
			<?php esc_html_e( 'To delete a marker, just double click on it and an item will be removed.', INTERGEO_PLUGIN_NAME ) ?>
		</p>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<div class="intergeo_tlbr_cntrl_items" style="display:block">
			<div class="intergeo_tlbr_cntrl_item">
				<label>
					<input type="checkbox" id="intergeo_tlbr_drawing_tools">
					<?php esc_html_e( 'Enable drawing tools', INTERGEO_PLUGIN_NAME ) ?>
				</label>
			</div>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<script id="intergeo_tlbr_marker_tmpl" type="text/html">
			<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_marker" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="intergeo_tlbr_marker_title_td">
						#%num% <?php esc_html_e( 'marker', INTERGEO_PLUGIN_NAME ) ?>
					</td>
					<td>
						<input type="hidden" class="intergeo_tlbr_marker_location" name="overlays_marker[%pos%][position]" data-position="%pos%">
						<input type="hidden" class="intergeo_tlbr_marker_title" name="overlays_marker[%pos%][title]">
						<input type="hidden" class="intergeo_tlbr_marker_icon" name="overlays_marker[%pos%][icon]">
						<input type="hidden" class="intergeo_tlbr_marker_info" name="overlays_marker[%pos%][info]">

						<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete marker', INTERGEO_PLUGIN_NAME ) ?>"></a>
						<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit marker', INTERGEO_PLUGIN_NAME ) ?>"></a>
					</td>
				</tr>
			</table>
		</script>
		
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Markers', INTERGEO_PLUGIN_NAME ) ?></span>
		<div id="intergeo_tlbr_markers" class="intergeo_tlbr_cntrl_items">
			<?php if ( !empty( $json['overlays']['marker'] ) ) : ?>
				<?php foreach ( $json['overlays']['marker'] as $i => $overlay ) : ?>
					<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_marker" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="intergeo_tlbr_marker_title_td">
								<?php if ( empty( $overlay['title'] ) ) : ?>
									#<?php echo $i + 1 ?> <?php esc_html_e( 'marker', INTERGEO_PLUGIN_NAME ) ?>
								<?php else : ?>
									<?php echo esc_html( $overlay['title'] ) ?>
								<?php endif; ?>
							</td>
							<td>
								<input type="hidden" class="intergeo_tlbr_marker_location" name="overlays_marker[<?php echo $i ?>][position]" value="<?php echo esc_attr( implode( ',', $overlay['position'] ) ) ?>" data-position="<?php echo $i ?>">
								<input type="hidden" class="intergeo_tlbr_marker_title" name="overlays_marker[<?php echo $i ?>][title]" value="<?php echo esc_attr( $overlay['title'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_marker_icon" name="overlays_marker[<?php echo $i ?>][icon]" value="<?php echo esc_attr( $overlay['icon'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_marker_info" name="overlays_marker[<?php echo $i ?>][info]" value="<?php echo esc_attr( $overlay['info'] ) ?>">

								<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete marker', INTERGEO_PLUGIN_NAME ) ?>"></a>
								<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit marker', INTERGEO_PLUGIN_NAME ) ?>"></a>
							</td>
						</tr>
					</table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<script id="intergeo_tlbr_polyline_tmpl" type="text/html">
			<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_polyline" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						#%num% <?php esc_html_e( 'polyline', INTERGEO_PLUGIN_NAME ) ?>
					</td>
					<td>
						<input type="hidden" class="intergeo_tlbr_polyline_path" name="overlays_polyline[%pos%][path]" data-position="%pos%">
						<input type="hidden" class="intergeo_tlbr_polyline_weight" name="overlays_polyline[%pos%][weight]">
						<input type="hidden" class="intergeo_tlbr_polyline_opacity" name="overlays_polyline[%pos%][opacity]">
						<input type="hidden" class="intergeo_tlbr_polyline_color" name="overlays_polyline[%pos%][color]">

						<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete polyline', INTERGEO_PLUGIN_NAME ) ?>"></a>
						<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit polyline', INTERGEO_PLUGIN_NAME ) ?>"></a>

						<span class="intergeo_tlbr_clr_prvw" style="background-color:black;"></span>
					</td>
				</tr>
			</table>
		</script>
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Polylines', INTERGEO_PLUGIN_NAME ) ?></span>
		<div id="intergeo_tlbr_polylines" class="intergeo_tlbr_cntrl_items"><?php 
			if ( !empty( $json['overlays']['polyline'] ) ) :
				$i = 0;
				foreach ( $json['overlays']['polyline'] as $overlay ) :
					$path = array();
					foreach( $overlay['path'] as $point ) : 
						$path[] = implode( ',', $point ); 
					endforeach; ?>
					<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_polyline" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								#<?php echo $i + 1 ?> <?php esc_html_e( 'polyline', INTERGEO_PLUGIN_NAME ) ?>
							</td>
							<td>
								<input type="hidden" class="intergeo_tlbr_polyline_path" name="overlays_polyline[<?php echo $i ?>][path]" value="<?php echo implode( ';', $path ) ?>" data-position="<?php echo $i ?>">
								<input type="hidden" class="intergeo_tlbr_polyline_weight" name="overlays_polyline[<?php echo $i ?>][weight]" value="<?php echo esc_attr( $overlay['weight'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_polyline_opacity" name="overlays_polyline[<?php echo $i ?>][opacity]" value="<?php echo esc_attr( $overlay['opacity'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_polyline_color" name="overlays_polyline[<?php echo $i++ ?>][color]" value="<?php echo esc_attr( $overlay['color'] ) ?>">
								
								<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete polyline', INTERGEO_PLUGIN_NAME ) ?>"></a>
								<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit polyline', INTERGEO_PLUGIN_NAME ) ?>"></a>

								<span class="intergeo_tlbr_clr_prvw" style="background-color:<?php echo esc_attr( $overlay['color'] ) ?>;opacity:<?php echo esc_attr( $overlay['opacity'] ) ?>"></span>
							</td>
						</tr>
					</table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<script id="intergeo_tlbr_rectangle_tmpl" type="text/html">
			<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_rectangle" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						#%num% <?php esc_html_e( 'rectangle', INTERGEO_PLUGIN_NAME ) ?>
					</td>
					<td>
						<input type="hidden" class="intergeo_tlbr_rectangle_path" name="overlays_rectangle[%pos%][path]" data-position="%pos%">
						<input type="hidden" class="intergeo_tlbr_rectangle_weight" name="overlays_rectangle[%pos%][weight]">
						<input type="hidden" class="intergeo_tlbr_rectangle_stroke_opacity" name="overlays_rectangle[%pos%][stroke_opacity]">
						<input type="hidden" class="intergeo_tlbr_rectangle_position" name="overlays_rectangle[%pos%][position]">
						<input type="hidden" class="intergeo_tlbr_rectangle_stroke_color" name="overlays_rectangle[%pos%][stroke_color]">
						<input type="hidden" class="intergeo_tlbr_rectangle_fill_opacity" name="overlays_rectangle[%pos%][fill_opacity]">
						<input type="hidden" class="intergeo_tlbr_rectangle_fill_color" name="overlays_rectangle[%pos%][fill_color]">

						<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete rectangle', INTERGEO_PLUGIN_NAME ) ?>"></a>
						<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit rectangle', INTERGEO_PLUGIN_NAME ) ?>"></a>

						<span class="intergeo_tlbr_clr_prvw" style="background-color:black;opacity:0.3;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=30)';filter:alpha(opacity=30);"></span>
						<span class="intergeo_tlbr_clr_prvw" style="background-color:black;"></span>
					</td>
				</tr>
			</table>
		</script>
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Rectangles', INTERGEO_PLUGIN_NAME ) ?></span>
		<div id="intergeo_tlbr_rectangles" class="intergeo_tlbr_cntrl_items"><?php 
			if ( !empty( $json['overlays']['rectangle'] ) ) :
				$i = 0;
				foreach ( $json['overlays']['rectangle'] as $overlay ) :
					
					$fill_opacity = "opacity:0.3;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=30)';filter:alpha(opacity=30);";
					if ( is_numeric( $overlay['fill_opacity'] ) ) {
						$opacity = floatval( $overlay['fill_opacity'] );
						$fill_opacity = sprintf( "opacity:%1\$.2f;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=%2\$u)';filter:alpha(opacity=%2\$u);", $opacity, $opacity * 100 );
					}
					
					$stroke_opacity = '';
					if ( is_numeric( $overlay['stroke_opacity'] ) ) {
						$opacity = floatval( $overlay['stroke_opacity'] );
						$stroke_opacity = sprintf( "opacity:%1\$f;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=%2\$u)';filter:alpha(opacity=%2\$u);", $opacity, $opacity * 100 );
					}
					
					$path = array();
					foreach( $overlay['path'] as $point ) : 
						$path[] = implode( ',', $point ); 
					endforeach; ?>
					<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_rectangle" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								#<?php echo $i + 1 ?> <?php esc_html_e( 'rectangle', INTERGEO_PLUGIN_NAME ) ?>
							</td>
							<td>
								<input type="hidden" class="intergeo_tlbr_rectangle_path" name="overlays_rectangle[<?php echo $i ?>][path]" value="<?php echo implode( ';', $path ) ?>" data-position="<?php echo $i ?>">
								<input type="hidden" class="intergeo_tlbr_rectangle_weight" name="overlays_rectangle[<?php echo $i ?>][weight]" value="<?php echo esc_attr( $overlay['weight'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_rectangle_stroke_opacity" name="overlays_rectangle[<?php echo $i ?>][stroke_opacity]" value="<?php echo esc_attr( $overlay['stroke_opacity'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_rectangle_position" name="overlays_rectangle[<?php echo $i ?>][position]" value="<?php echo esc_attr( $overlay['position'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_rectangle_stroke_color" name="overlays_rectangle[<?php echo $i ?>][stroke_color]" value="<?php echo esc_attr( $overlay['stroke_color'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_rectangle_fill_opacity" name="overlays_rectangle[<?php echo $i ?>][fill_opacity]" value="<?php echo esc_attr( $overlay['fill_opacity'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_rectangle_fill_color" name="overlays_rectangle[<?php echo $i++ ?>][fill_color]" value="<?php echo esc_attr( $overlay['fill_color'] ) ?>">
								
								<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete rectangle', INTERGEO_PLUGIN_NAME ) ?>"></a>
								<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit rectangle', INTERGEO_PLUGIN_NAME ) ?>"></a>

								<span class="intergeo_tlbr_clr_prvw" style="background-color:<?php echo esc_attr( $overlay['fill_color'] ) ?>;<?php echo $fill_opacity ?>"></span>
								<span class="intergeo_tlbr_clr_prvw" style="background-color:<?php echo esc_attr( $overlay['stroke_color'] ) ?>;<?php echo $stroke_opacity ?>"></span>
							</td>
						</tr>
					</table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<script id="intergeo_tlbr_circle_tmpl" type="text/html">
			<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_circle" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						#%num% <?php esc_html_e( 'circle', INTERGEO_PLUGIN_NAME ) ?>
					</td>
					<td>
						<input type="hidden" class="intergeo_tlbr_circle_path" name="overlays_circle[%pos%][path]" data-position="%pos%">
						<input type="hidden" class="intergeo_tlbr_circle_weight" name="overlays_circle[%pos%][weight]">
						<input type="hidden" class="intergeo_tlbr_circle_stroke_opacity" name="overlays_circle[%pos%][stroke_opacity]">
						<input type="hidden" class="intergeo_tlbr_circle_position" name="overlays_circle[%pos%][position]">
						<input type="hidden" class="intergeo_tlbr_circle_stroke_color" name="overlays_circle[%pos%][stroke_color]">
						<input type="hidden" class="intergeo_tlbr_circle_fill_opacity" name="overlays_circle[%pos%][fill_opacity]">
						<input type="hidden" class="intergeo_tlbr_circle_fill_color" name="overlays_circle[%pos%][fill_color]">

						<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete rectangle', INTERGEO_PLUGIN_NAME ) ?>"></a>
						<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit rectangle', INTERGEO_PLUGIN_NAME ) ?>"></a>

						<span class="intergeo_tlbr_clr_prvw" style="background-color:black;opacity:0.3;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=30)';filter:alpha(opacity=30);"></span>
						<span class="intergeo_tlbr_clr_prvw" style="background-color:black;"></span>
					</td>
				</tr>
			</table>
		</script>
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Circles', INTERGEO_PLUGIN_NAME ) ?></span>
		<div id="intergeo_tlbr_circles" class="intergeo_tlbr_cntrl_items"><?php 
			if ( !empty( $json['overlays']['circle'] ) ) :
				$i = 0;
				foreach ( $json['overlays']['circle'] as $overlay ) :
					
					$fill_opacity = "opacity:0.3;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=30)';filter:alpha(opacity=30);";
					if ( is_numeric( $overlay['fill_opacity'] ) ) {
						$opacity = floatval( $overlay['fill_opacity'] );
						$fill_opacity = sprintf( "opacity:%1\$.2f;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=%2\$u)';filter:alpha(opacity=%2\$u);", $opacity, $opacity * 100 );
					}
					
					$stroke_opacity = '';
					if ( is_numeric( $overlay['stroke_opacity'] ) ) {
						$opacity = floatval( $overlay['stroke_opacity'] );
						$stroke_opacity = sprintf( "opacity:%1\$f;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=%2\$u)';filter:alpha(opacity=%2\$u);", $opacity, $opacity * 100 );
					}
					
					$path = array();
					foreach( $overlay['path'] as $point ) : 
						$path[] = implode( ',', $point ); 
					endforeach; ?>
					<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_circle" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								#<?php echo $i + 1 ?> <?php esc_html_e( 'circle', INTERGEO_PLUGIN_NAME ) ?>
							</td>
							<td>
								<input type="hidden" class="intergeo_tlbr_circle_path" name="overlays_circle[<?php echo $i ?>][path]" value="<?php echo implode( ';', $path ) ?>" data-position="<?php echo $i ?>">
								<input type="hidden" class="intergeo_tlbr_circle_weight" name="overlays_circle[<?php echo $i ?>][weight]" value="<?php echo esc_attr( $overlay['weight'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_circle_stroke_opacity" name="overlays_circle[<?php echo $i ?>][stroke_opacity]" value="<?php echo esc_attr( $overlay['stroke_opacity'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_circle_position" name="overlays_circle[<?php echo $i ?>][position]" value="<?php echo esc_attr( $overlay['position'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_circle_stroke_color" name="overlays_circle[<?php echo $i ?>][stroke_color]" value="<?php echo esc_attr( $overlay['stroke_color'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_circle_fill_opacity" name="overlays_circle[<?php echo $i ?>][fill_opacity]" value="<?php echo esc_attr( $overlay['fill_opacity'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_circle_fill_color" name="overlays_circle[<?php echo $i++ ?>][fill_color]" value="<?php echo esc_attr( $overlay['fill_color'] ) ?>">
								
								<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete circle', INTERGEO_PLUGIN_NAME ) ?>"></a>
								<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit circle', INTERGEO_PLUGIN_NAME ) ?>"></a>

								<span class="intergeo_tlbr_clr_prvw" style="background-color:<?php echo esc_attr( $overlay['fill_color'] ) ?>;<?php echo $fill_opacity ?>"></span>
								<span class="intergeo_tlbr_clr_prvw" style="background-color:<?php echo esc_attr( $overlay['stroke_color'] ) ?>;<?php echo $stroke_opacity ?>"></span>
							</td>
						</tr>
					</table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<script id="intergeo_tlbr_polygon_tmpl" type="text/html">
			<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_polygon" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						#%num% <?php esc_html_e( 'polygon', INTERGEO_PLUGIN_NAME ) ?>
					</td>
					<td>
						<input type="hidden" class="intergeo_tlbr_polygon_path" name="overlays_polygon[%pos%][path]" data-position="%pos%">
						<input type="hidden" class="intergeo_tlbr_polygon_weight" name="overlays_polygon[%pos%][weight]">
						<input type="hidden" class="intergeo_tlbr_polygon_stroke_opacity" name="overlays_polygon[%pos%][stroke_opacity]">
						<input type="hidden" class="intergeo_tlbr_polygon_position" name="overlays_polygon[%pos%][position]">
						<input type="hidden" class="intergeo_tlbr_polygon_stroke_color" name="overlays_polygon[%pos%][stroke_color]">
						<input type="hidden" class="intergeo_tlbr_polygon_fill_opacity" name="overlays_polygon[%pos%][fill_opacity]">
						<input type="hidden" class="intergeo_tlbr_polygon_fill_color" name="overlays_polygon[%pos%][fill_color]">

						<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete polygon', INTERGEO_PLUGIN_NAME ) ?>"></a>
						<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit polygon', INTERGEO_PLUGIN_NAME ) ?>"></a>

						<span class="intergeo_tlbr_clr_prvw" style="background-color:black;opacity:0.3;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=30)';filter:alpha(opacity=30);"></span>
						<span class="intergeo_tlbr_clr_prvw" style="background-color:black;"></span>
					</td>
				</tr>
			</table>
		</script>
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Polygons', INTERGEO_PLUGIN_NAME ) ?></span>
		<div id="intergeo_tlbr_polygons" class="intergeo_tlbr_cntrl_items"><?php 
			if ( !empty( $json['overlays']['polygon'] ) ) :
				$i = 0;
				foreach ( $json['overlays']['polygon'] as $overlay ) :
					
					$fill_opacity = "opacity:0.3;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=30)';filter:alpha(opacity=30);";
					if ( is_numeric( $overlay['fill_opacity'] ) ) {
						$opacity = floatval( $overlay['fill_opacity'] );
						$fill_opacity = sprintf( "opacity:%1\$.2f;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=%2\$u)';filter:alpha(opacity=%2\$u);", $opacity, $opacity * 100 );
					}
					
					$stroke_opacity = '';
					if ( is_numeric( $overlay['stroke_opacity'] ) ) {
						$opacity = floatval( $overlay['stroke_opacity'] );
						$stroke_opacity = sprintf( "opacity:%1\$f;-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=%2\$u)';filter:alpha(opacity=%2\$u);", $opacity, $opacity * 100 );
					}
					
					$path = array();
					foreach( $overlay['path'] as $point ) : 
						$path[] = implode( ',', $point ); 
					endforeach; ?>
					<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_polygon" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								#<?php echo $i + 1 ?> <?php esc_html_e( 'polygon', INTERGEO_PLUGIN_NAME ) ?>
							</td>
							<td>
								<input type="hidden" class="intergeo_tlbr_polygon_path" name="overlays_polygon[<?php echo $i ?>][path]" value="<?php echo implode( ';', $path ) ?>" data-position="<?php echo $i ?>">
								<input type="hidden" class="intergeo_tlbr_polygon_weight" name="overlays_polygon[<?php echo $i ?>][weight]" value="<?php echo esc_attr( $overlay['weight'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_polygon_stroke_opacity" name="overlays_polygon[<?php echo $i ?>][stroke_opacity]" value="<?php echo esc_attr( $overlay['stroke_opacity'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_polygon_position" name="overlays_polygon[<?php echo $i ?>][position]" value="<?php echo esc_attr( $overlay['position'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_polygon_stroke_color" name="overlays_polygon[<?php echo $i ?>][stroke_color]" value="<?php echo esc_attr( $overlay['stroke_color'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_polygon_fill_opacity" name="overlays_polygon[<?php echo $i ?>][fill_opacity]" value="<?php echo esc_attr( $overlay['fill_opacity'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_polygon_fill_color" name="overlays_polygon[<?php echo $i++ ?>][fill_color]" value="<?php echo esc_attr( $overlay['fill_color'] ) ?>">
								
								<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete polygon', INTERGEO_PLUGIN_NAME ) ?>"></a>
								<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit polygon', INTERGEO_PLUGIN_NAME ) ?>"></a>

								<span class="intergeo_tlbr_clr_prvw" style="background-color:<?php echo esc_attr( $overlay['fill_color'] ) ?>;<?php echo $fill_opacity ?>"></span>
								<span class="intergeo_tlbr_clr_prvw" style="background-color:<?php echo esc_attr( $overlay['stroke_color'] ) ?>;<?php echo $stroke_opacity ?>"></span>
							</td>
						</tr>
					</table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</li>
</ul>