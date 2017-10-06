<?php
class Iota
{
	function __construct()
	{
		register_activation_hook( __FILE__,   array($this, 'aj_vortex_default') ); 

		add_action( 'admin_menu', array($this, 'aj_vortex_menu')  );
		
		add_action( 'admin_enqueue_scripts',  array($this, 'admin_script') );	
		
		add_action('wp_enqueue_scripts', array($this, 'aj_vortex_scripts'));
		
		add_action( 'show_user_profile', array($this,'fb_add_custom_user_profile_fields') );
		
		add_action( 'edit_user_profile', array($this,'fb_add_custom_user_profile_fields') );

		add_action( 'personal_options_update', array($this,'fb_save_custom_user_profile_fields') );
		
		add_action( 'edit_user_profile_update', array($this,'fb_save_custom_user_profile_fields') );
		
		add_action('wp_head', array($this, 'aj_vortex_head'));
		
		add_filter( 'the_content', array($this,'iota_qbar') );
		
	}
	
	function aj_vortex_default() {}
	
	function aj_vortex_head(){
		$aj_iota_initialization_url = get_option( 'aj_iota_initialization_url' );
		$output = '<script>';
		$output .= 'window.iota_url = "'.( !empty($aj_iota_initialization_url) ? $aj_iota_initialization_url : '' ).'";';
		$output .= '</script>';
		echo $output;		
	}
	
	function aj_vortex_scripts() {
		wp_enqueue_style( 'aj-ioto-css', plugins_url( 'frontend/css/iota.css', __FILE__ ) );
		wp_enqueue_script(array('jquery'));
		wp_enqueue_script( 'aj-qrcode',  "https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js" );
		wp_enqueue_script( 'aj-ioto-js',  plugins_url( 'frontend/js/iota.min.js', __FILE__ ) );
    	wp_enqueue_script( 'aj-iota-tipping',  plugins_url( 'frontend/js/iota-micro-tipping.js', __FILE__ ) );
		wp_enqueue_script( 'aj-iota-functions',  plugins_url( 'frontend/js/functions.js', __FILE__ ) );
	}
	
	function iota_qbar( $content ) {
		global $post;
		
		if( is_single() ){
			$iota_address = get_the_author_meta( 'iota_address', $post->post_author );
			$aj_iota_initialization_url = get_option( 'aj_iota_initialization_url' );
			
			if( !empty( $aj_iota_initialization_url ) ){
				$balance = $this->getBalance($aj_iota_initialization_url, $iota_address);
			}
			
			if( !empty( $iota_address ) ){
				return $content.'<br/><p style="text-align:center;">Did you enjoy this article? Give a tip to the author with IOTA! <br/><span data-address="'.$iota_address.'" data-tag="Did you enjoy this article? Give a tip to the author with IOTA!" data-amount="1000000"></span><br/>Iota Address : '.$iota_address.'</p>';
			}else{
				return $content;
			}
		}else{
			return $content;
		}
	}
	
	
	function getBalance( $url ,$address){
		
		$string = "{\"command\": \"getBalances\", \"addresses\": [\"$address\"], \"threshold\": 100}";
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $string); 
		curl_setopt($ch, CURLOPT_POST, 1); 
		$headers = array(); 
		$headers[] = "Content-Type: application/json"; 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		$result = curl_exec($ch); 
		if (curl_errno($ch)) { 
			echo 'Error:' . curl_error($ch); 
		} 
		curl_close ($ch);

		$result = json_decode($result, true);

		if( !empty($result['balances'][0]) ){
			return $this->nice_number($result['balances'][0]);
		}else{
			return "0 i";
		}
	}
	
	
	function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n >= 1000000000000000) return 'Pi';
		elseif ($n >= 1000000000000) return 'Ti';
        elseif ($n >= 1000000000) return 'Gi';
        elseif ($n >= 1000000) return 'Mi';
        elseif ($n >= 1000) return 'Ki';
		else return 'i';

        return number_format($n);
    }
	
	
	
	function fb_add_custom_user_profile_fields( $user ) {
		
		$user_meta = get_userdata( $user->ID );
		$current_user_info = get_currentuserinfo();
		
		$found = false;
		$allowed_array = array("author");
		if( isset($user_meta->roles) ){
			foreach( $user_meta->roles as $each_role ){
				if( in_array($each_role, $allowed_array) ){
					$found = true;
					break;
				}
			}
		}
		
		if( $found == true && $current_user_info->roles[0] != 'administrator' ):
	?>
		<h3><?php _e('Iota Information', 'iota_textdomain'); ?></h3>

		<table class="form-table">
			<tr>
				<th>
					<label for="address"><?php _e('Iota Address', 'iota_textdomain'); ?>
				</label></th>
				<td>
					<input type="text" name="iota_address" id="iota_address" value="<?php echo esc_attr( get_the_author_meta( 'iota_address', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Please enter your iota address.', 'iota_textdomain'); ?></span>
				</td>
			</tr>
		</table>
	<?php 
		endif;	
	}

	function fb_save_custom_user_profile_fields( $user_id ) {

		if ( !current_user_can( 'edit_user', $user_id ) )
			return FALSE;
		
		if( isset( $_POST['iota_address'] ) )
		update_usermeta( $user_id, 'iota_address', sanitize_text_field($_POST['iota_address']) );
	}
	
	
	
	function admin_script()
	{
		$page_array = array('aj-iota-tipping');
		if( isset( $_REQUEST['page'] ) )
		{
			if( in_array($_REQUEST['page'],$page_array ) )
			{
				wp_enqueue_style( 'aj-admin-css', plugins_url( 'admin/css/style.css', __FILE__ ) );
			}
		}
	}
	
	function aj_vortex_menu() {
		// Create top-level menu item 
		add_menu_page( 'Iota Tipping', 'Iota Tipping', 'manage_options', 'aj-iota-tipping',  array($this, 'aj_general_settings'), plugins_url( 'admin/img/iota.png', __FILE__ ) ); 
	}
	
	
	function aj_general_settings(){
			
		if( isset($_POST['aj_general_settings_btn']) ){
			update_option('aj_iota_initialization_url', $_POST['aj_iota_initialization_url']);
		}
		$aj_iota_initialization_url = get_option( 'aj_iota_initialization_url' );

		
		echo '<div class="wrap w_60p">
				<div id="icon-users" class="icon32"><br/></div>
				<h2>Iota Tipping General Settings</h2>';              
		echo 	'<form action="" id="aj_general_settings_form" name="aj_general_settings_form" method="post">
					<table class="wp-list-table widefat fixed m_t_20p p_5p table_bg">
						<tbody>
							<tr class="alternate">
								<td>iota node URL for counter, leave blank for default</td>
								<td>
									<input type="text" required="required" name="aj_iota_initialization_url" id="aj_iota_initialization_url" placeholder="http://iota.bitfinex.com:80" value="'.$aj_iota_initialization_url.'" />
									
								</td>
							</tr>
							
							<tr class="alternate">
								<td>
									<input type="submit" name="aj_general_settings_btn" id="aj_general_settings_btn" class="button button-primary button-large" value="Save" />
								</td>
								<td>
									&nbsp;
								</td>
							</tr>
						 <tbody>
					 </table>	 
				  </form>';		  
		echo '</div>';		  
	}
	
}
/** Initiate the Class */
$GLOBALS['aj_vortex_iota'] = new Iota;
?>
