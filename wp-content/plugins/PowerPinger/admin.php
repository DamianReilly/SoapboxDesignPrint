<?php
class powerpinger_admin {

	function powerpinger_admin() {
		// stuff to do when the plugin is loaded
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}

	function admin_menu() {
		add_options_page('Power Pinger Settings', 'Power Pinger', 'manage_options', __FILE__, array(&$this, 'settings_page'));
	}// end function

	function settings_page() {
		
		global $powerpinger;
		$options = $powerpinger->get_options();
		
		if ( isset($_POST['update']) ) {
			
			// check user is authorised
			if ( function_exists('current_user_can') && !current_user_can('manage_options') )
				die('Sorry, not allowed...');
			check_admin_referer('powerpinger_settings');

			$options['method'] = trim($_POST['method']);
			$options['enabled'] = trim($_POST['enabled']);
			$options['staticip'] = trim($_POST['staticip']);
			$options['testmode'] = trim($_POST['testmode']);
			
			$options['onhome'] = trim($_POST['onhome']);
			$options['onpage'] = trim($_POST['onpage']);
			$options['onpost'] = trim($_POST['onpost']);
			

			update_option('powerpinger', $options);

			echo '<div id="message" class="updated fade"><p><strong>Power Pinger Settings Have Been Saved.</strong></p></div>';
		
		}// end if

		echo '<div class="wrap">'
			.'<h2>Power Pinger Settings</h2>'
			.'<form method="post">';
		if ( function_exists('wp_nonce_field') ) wp_nonce_field('powerpinger_settings');
		?>
		   <h3>Modify These Settings as Required</h3>
		   This plugin allows you to have your users automatically promote your site by pinging pingomatic.com everytime they visit a page.<BR>
		   If you are on a static IP then you can stop yourself from pinging every time you view a page by entering your IP in the STATIC IP option below.
		   <p>You can use IFrame or Javascript to hide the power pinger code in the footer</p>
		   <table class="form-table">
		   <tr>
		      <th scope="row">Enable This Plugin:</th>
			   <td><input type="checkbox" id="enabled" name="enabled" value="ON" <?php if ( $options['enabled'] ){ echo 'checked="checked"';} ?>></td>
			</tr>

			<tr><th scope="row">Method:</th>
			<td><select name="method">
			<option value="iframe" <?php if ( $options['method']=='iframe' ){ echo ' selected '; } ?> >IFrame</option>
  			<option value="js" <?php if ( $options['method']=='js' ){ echo ' selected ';} ?> >Javascript</option>
			</select>
			</td></tr>	
					
	    	<tr><th scope="row">Test Mode:</th>
			<td>
			<input type="checkbox" id="testmode" name="testmode" value="ON" <?php if ( $options['testmode'] ) {echo 'checked="checked"';} ?> />
			</td></tr>
		
		<tr><th scope="row">Static IP:</th><td><input type=text name="staticip" id="token" style="width:200px;" value="<?php echo $options['staticip']; ?>"><BR><small>Your current IP is <?php echo $_SERVER['REMOTE_ADDR'] ?></small></td>
		</tr>
		
		<tr>
		      <th scope="row">Where To Use This:</th>
			   <td>
			<label>On Home Page: <input type="checkbox" id="onhome" name="onhome" value="ON" <?php if ( $options['onhome'] ){ echo 'checked="checked"';} ?>></label>
			<label>&nbsp;&nbsp;&nbsp;&nbsp;On Posts: <input type="checkbox" id="onpost" name="onpost" value="ON" <?php if ( $options['onpost'] ){ echo 'checked="checked"';} ?>></label>
			<label>&nbsp;&nbsp;&nbsp;&nbsp;On Pages: <input type="checkbox" id="onpage" name="onpage" value="ON" <?php if ( $options['onpage'] ){ echo 'checked="checked"';} ?>></label>
			</td>
			</tr>
		
		
		</table>
		<p class="submit"><input type="submit" name="update" class="button-primary" value="Save Changes" /></p>
		</form>
		</div>
<?php
		
	}// end function

}// end class
$powerpinger_admin = new powerpinger_admin;
