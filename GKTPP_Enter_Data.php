<?php

class GKTPP_Enter_Data extends GKTPP_Table {

     protected static function add_url_hint() {

          if ( ! is_admin() )
               exit();
          ?>

		<table id="gktpp-enter-data" class="gktpp-table fixed widefat striped" cellspacing="0">
			<?php wp_nonce_field( 'gkt_preP-settings-page' ); ?>

			<thead>
                    <tr>
					<th colspan="5"><h2 style="text-align: center;"><?php esc_html_e( 'Add New Resource Hint', 'gktpp' ); ?></h2></th>
				</tr>
			</thead>

			<tbody>

				<tr>
					<td style="text-align: right;" colspan="1"><?php esc_html_e( 'URL:', 'gktpp' ); ?></td>
					<td colspan="4">
						<label for="url">
							<input placeholder="<?php esc_attr_e( 'Enter valid domain or URL...', 'gktpp' ); ?>" class="widefat" name="url" />
						</label>
					</td>
				</tr>

				<?php self::show_pp_radio_options(); ?>

			</tbody>

			<tfoot>
                    <tr>
					<th colspan="5" style="text-align: center; padding: 20px 0;">
						<input type="submit" name="gktpp-settings-submit" class="button button-primary" value="<?php esc_attr_e( 'Insert Resource Hint', 'gktpp' ); ?>" />
					</th>
				</tr>
			</tfoot>

		</table>
		<?php
	}

	protected static function show_pp_radio_options() {
		$hint_type = '';
		?>
		<tr>
			<td colspan="1">
				<label for="hint_type">
                         <button class="gktpp-help-tip-hint before">
                              <p class='gktpp-help-tip-box'><?php esc_html_e( 'Insert domain names from external URL\'s to perform DNS resolution early.', 'gktpp' ); ?></p>
                         </button>
                         <span class="gktpp-hint"><?php esc_html_e( 'DNS-Prefetch' ); ?></span>
					<input class="gktpp-radio" name="hint_type" type="radio" value="DNS-Prefetch" <?php if ( 'DNS-Prefetch' === $hint_type ) { echo 'checked="checked"';} ?> />

				</label>
			</td>

			<td colspan="1">
				<label for="hint_type">
                         <button class="gktpp-help-tip-hint before">
                              <p class='gktpp-help-tip-box'><?php esc_html_e( 'Insert the full URL of a resource that is likely to be needed on a page later.', 'gktpp' ); ?></p>
                         </button>
                         <span class="gktpp-hint"><?php esc_html_e( 'Prefetch' ); ?></span>
                         <input class="gktpp-radio" name="hint_type" type="radio" value="Prefetch" <?php if ( 'Prefetch' === $hint_type ) { echo 'checked="checked"'; } ?> />
				</label>
			</td>

			<td colspan="1">
				<label for="hint_type">
                         <button class="gktpp-help-tip-hint before">
                              <p class='gktpp-help-tip-box'><?php esc_html_e( 'Insert the full URL of a page/post your visitors are likely to navigate towards.', 'gktpp' ); ?></p>
                         </button>
                         <span class="gktpp-hint"><?php esc_html_e( 'Prerender' ); ?></span>
                         <input class="gktpp-radio" name="hint_type" type="radio" value="Prerender" <?php if ( 'Prerender' === $hint_type ) { echo 'checked="checked"'; } ?> />
				</label>
			</td>

			<td colspan="1">
				<label for="hint_type">
                         <button class="gktpp-help-tip-hint before">
                              <p class='gktpp-help-tip-box'><?php esc_html_e( 'Insert domain names from external URL\'s to perform DNS resolution, initial connection, and SSL negotiation ahead of time.', 'gktpp' ); ?></p>
                         </button>
                         <span class="gktpp-hint"><?php esc_html_e( 'Preconnect' ); ?></span>
                         <input class="gktpp-radio" name="hint_type" type="radio" value="Preconnect" <?php if ( 'Preconnect' === $hint_type ) { echo 'checked="checked"'; } ?> />
				</label>
			</td>

			<td colspan="1">
				<label for="hint_type">
                         <button class="gktpp-help-tip-hint before">
                              <p class='gktpp-help-tip-box'><?php esc_html_e( 'Insert the full URL of a resource that is needed on a current page.', 'gktpp' ); ?></p>
                         </button>
                         <span class="gktpp-hint"><?php esc_html_e( 'Preload' ); ?></span>
                         <input class="gktpp-radio" name="hint_type" type="radio" value="Preload" <?php if ( 'Preload' === $hint_type ) { echo 'checked="checked"'; } ?> />
				</label>
			</td>

		</tr>

		<?php
	}

     protected static function show_info() {
          if ( ! is_admin() )
               exit;

          global $pagenow;
          if ( ('admin.php' === $pagenow) && ( $_GET['page'] === 'gktpp-plugin-settings' ) ) {

               add_option( 'gktpp_preconnect_status', 'Yes', '', 'yes' );
               if ( isset( $_POST['gktpp-preconnect-status'] ) ) {
                    update_option( 'gktpp_preconnect_status', $_POST['gktpp-preconnect-status'], 'no' );
               }

               add_option( 'gktpp_reset_preconnect', 'notset', '', 'yes' );
               if ( isset( $_POST['gktpp-reset-preconnect'] ) ) {
                    update_option( 'gktpp_reset_preconnect', 'notset', 'yes' );
               }

               add_option( 'gktpp_send_in_header', 'HTTP Header', '', 'yes' );
               if ( isset( $_POST['gktpp-save-header-option'] ) ) {
                    update_option( 'gktpp_send_in_header', $_POST['gktpp-send-in-header'], 'no' );
               }
               ?>
               <div class="gktpp-table info postbox">

                    <h2 id="gktpp-collapse-btn" class="hndle ui-sortable-handle" style="text-align: center;">
                         <span>Settings</span>
                         <button type="button" class="handlediv" aria-expanded="false">
                              <span id="gktpp-toggle-indicator" aria-hidden="true"></span>
                         </button>
                    </h2>
                    <div id="gktpp-collapse-box" class="">

                         <form class="gktpp-form" method="post" action='<?php admin_url( "admin.php?page=gktpp-plugin-settings&_wpnonce=" );?>'>
                              <?php $preconnect_status = get_option( 'gktpp_preconnect_status' ); ?>
                              <div>
                                   <h2 class="gktpp-hint"><?php esc_html_e( 'Automatically Set Preconnect Hints?', 'gktpp' ); ?></h2>
                                   <button class="gktpp-help-tip-hint after">
                                        <p class='gktpp-help-tip-box'><?php esc_html_e( 'JavaScript, CSS, and images loaded from external domains will preconnect automatically.', 'gktpp' ); ?></p>
                                   </button>
                              </div>

                              <br />
                              <br />

                              <div>
                                   <select name="gktpp-preconnect-status">
                                        <option value="<?php echo esc_attr( 'Yes', 'gktpp' ); ?>" <?php if ( 'Yes' === $preconnect_status ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yes', 'gktpp' ); ?></option>
                                        <option value="<?php echo esc_attr( 'No', 'gktpp' ); ?>" <?php if ( 'No' === $preconnect_status ) echo 'selected="selected"'; ?>><?php esc_html_e( 'No', 'gktpp' ); ?></option>
                                   </select>
                                   <input style="margin: 0 25px;" type="submit" name="gktpp-save-preconnect" class="button-primary" value="<?php esc_attr_e( 'Save', 'gktpp' ); ?>" />
                                   <input type="submit" name="gktpp-reset-preconnect" class="button-secondary" value="<?php esc_attr_e( 'Reset Links', 'gktpp' ); ?>" />
                              </div>
                         </form>

                         <form class="gktpp-form" method="post" action='<?php admin_url( "admin.php?page=gktpp-plugin-settings&_wpnonce=" );?>'>
                         <?php $header_option = get_option( 'gktpp_send_in_header' ); ?>

                              <h2 class="gktpp-hint"><?php esc_html_e( 'Send Resource Hints in the Header or <head>?', 'gktpp' ); ?></h2>
                              <button class="gktpp-help-tip-hint after">
                                   <p class='gktpp-help-tip-box'><?php esc_html_e( 'Embedding hints in the header allows the browser more time to process the hints, while loading in the <head> allows them to be more visible. Header is recommended.', 'gktpp' ); ?></p>
                              </button>

                              <br />
                              <br />

                              <select name="gktpp-send-in-header">
                                   <option value="<?php echo esc_attr( 'HTTP Header', 'gktpp' ); ?>"<?php if ( 'HTTP Header' === $header_option ) echo 'selected="selected"'; ?>><?php esc_html_e( 'HTTP Header', 'gktpp' ); ?></option>
                                   <option value="<?php echo esc_attr( 'Send in head', 'gktpp' ); ?>"<?php if ( 'Send in head' === $header_option ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Send in <head>', 'gktpp' ); ?></option>
                              </select>
                              <input style="margin: 0 25px;" type="submit" name="gktpp-save-header-option" class="button-primary" value="<?php esc_attr_e( 'Save', 'gktpp' ); ?>" />
                         </form>
                         
                    </div>

               </div>
               <?php
          }
     }
}