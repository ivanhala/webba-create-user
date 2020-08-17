add_action( 'wbk_add_appointment', 'my_wbk_add_appointment', 10, 1 ); 
function my_wbk_add_appointment( $data ){
	$appointment = new WBK_Appointment();
	if ( !$appointment->setId( $data['appointment_id'] ) ) {
		return '';
	};
	if ( !$appointment->load() ) {
		return '';
	};
	$extra_data = trim( $appointment->getExtra() );
	$last_name = '';
	if( $extra_data != '' ){
		$extra = json_decode( $extra_data );
		if( is_array( $extra ) ){
			foreach( $extra as $item ){
				if( $item[0] == 'custom-lastname' ){
					$last_name = $item[2]; 
				}
			}
		}
	}
	$user_info = array(
		'user_pass'     =>  uniqid(),
		'user_login'    =>  mb_strtolower( $appointment->getName() ) . '_' . time(),
		'user_nicename' =>  $appointment->getName() . ' ' . $last_name,
		'user_email'    =>  $appointment->getEmail(),
		'display_name'  =>  $appointment->getName() . ' ' . $last_name,
		'first_name'    =>  $appointment->getName(),
		'last_name'     =>  $last_name,
	);

	$insert_user_result = wp_insert_user( $user_info );
}
