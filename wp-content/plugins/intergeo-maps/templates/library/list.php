<div class="wrap">
    <h2>
		<div id="intergeo_lbrr_ttl">Inter<span style="color:#4067dc">g</span><span style="color:#e21b31">e</span><span style="color:#fcaa08">o</span> <?php _e( 'Maps', INTERGEO_PLUGIN_NAME ) ?></div> 
		<a id="intergeo_lbrr_add_new" href="javascript:;" class="add-new-h2"><?php _e( 'Add New', INTERGEO_PLUGIN_NAME ) ?></a>
	</h2>
	
	<script type="text/javascript">
		/* <![CDATA[ */
		window.intergeo_maps = [];
		window.intergeo_maps_maps = [];
		/* ]]> */
	</script>
	
	<?php if ( $query->have_posts() ) : ?>
	
		<div id="intergeo_lbrr_items"><?php 
			$index = 0;
			while ( $query->have_posts() ) : 
				$post = $query->next_post();

				$id = intergeo_encode( $post->ID );
				$json = json_decode( $post->post_content, true );

				$delete_url = add_query_arg( array( 
					'map'      => $id, 
					'do'       => 'delete', 
					'noheader' => 'true',
					'nonce'    => wp_create_nonce( $post->ID . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ),
				) );

				$libraries = intergeo_check_libraries( $json, $libraries );

				?><div class="intergeo_lbrr_item"<?php echo $index != 0 && $index % 3 == 0 ? ' style="clear:both"' : '' ?>>
					<div class="intergeo_lbrr_wrapper">
						<div class="intergeo_lbrr_map_wrapper">
							<div class="intergeo_lbrr_map_loader">
								<div id="intergeo_map<?php echo $id ?>" class="intergeo_lbrr_map"></div>
							</div>
						</div>
						<table class="intergeo_lbrr_cntrls" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td>
									<input type="text" class="intergeo_lbrr_code" value="[intergeo id=&quot;<?php echo $id ?>&quot;]<?php echo !empty( $json['address'] ) ? esc_attr( $json['address'] ) : '' ?>[/intergeo]">
								</td>
								<td class="intergeo_lbrr_item_actions">
									<a class="intergeo_lbrr_item_edit" href="javascript:;" title="<?php _e( "Edit", INTERGEO_PLUGIN_NAME ) ?>" data-map="<?php echo $id  ?>"></a>
									<a class="intergeo_lbrr_item_copy" href="javascript:;" title="<?php _e( "Copy", INTERGEO_PLUGIN_NAME ) ?>" data-map="<?php echo $id  ?>"></a>
									<a class="intergeo_lbrr_item_delete" href="<?php echo esc_attr( $delete_url ) ?>" title="<?php _e( "Delete", INTERGEO_PLUGIN_NAME ) ?>" onclick="return showNotice.warn();"></a>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<script type="text/javascript">
					/* <![CDATA[ */
					window.intergeo_maps.push({
						container: 'intergeo_map<?php echo $id ?>', 
						options: <?php echo $post->post_content ?> 
					});
					/* ]]> */
				</script><?php

				$index++;
			endwhile;

			?><div style="clear:both"></div>
		</div>

		<?php if ( !empty( $pagination ) ) : ?>
		<div>
			<ul id="intergeo_lbrr_pgntn">
				<?php foreach ( $pagination as $page_item ) : ?>
				<li><?php echo $page_item ?></li>
				<?php endforeach; ?>
			</ul>
			<div style="clear:both"></div>
		</div>
		<?php endif; ?>
	
	<?php else : ?>
		<p>
			<?php esc_html_e( 'You do not have created maps. Start adding it by clicking "Add New" button.', INTERGEO_PLUGIN_NAME ) ?>
		</p>
	<?php endif; ?>
</div>