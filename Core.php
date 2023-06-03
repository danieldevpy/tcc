<?php

	//
//	ini_set('max_execution_time', '300');

	//
	session_start();

	//
	declare(strict_types=1);


	//
	include '../Config.php';
	include '../Common.php';

	//
	$DateTimer = new DateTime();
	$Date = $DateTimer->format('Y-m-d H:i:00');



	//
	$C_Address = "170.245.79.194";			// $Ses->Get( "Olt.Address" );
	$C_Port = 2222;						// $Ses->Get( "Olt.Port" );
	$C_TimeOut = true;					// $Ses->Get( "Olt.Port" );

	//
	$C_User = "mpl";					// $Ses->Get( "Olt.User" );
	$C_Passwd = "150291";						// $Ses->Get( "Olt.Pass" );


	//
	$C_Auth = false;
	$C_Conected = false;

	//
	$C_Result = "";

	//
	$C_Show = false;
	$C_Buffer = false;
	$C_Finished = false;
	$C_Trying = 0;


	//
	$C_SSH = new Net_SSH2( $C_Address, $C_Port );
	$C_Auth = $C_SSH->login( $C_User, $C_Passwd );
	$C_Conected = true;


	//
	//
	while ($C_Finished < 3) {



		if ($C_Conected == false) {


			
			echo "ssh2 channel ' . $C_Address . ' finished \n";
		}

		if ($C_Finished != true) {


		}






		exit;

	};


	?>