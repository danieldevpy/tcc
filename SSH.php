<?php

	//
	session_start();

	//
	include 'Crypt/Base.php';
	include 'Crypt/DES.php';
	include 'Crypt/RSA.php';
	include 'Crypt/Rijndael.php';
	include 'Math/BigInteger.php';
	include 'Net/SSH2.php';

	//
	include '../Config.php';
	include '../Common.php';

	//
	$Show = false;
	$Buffer = false;

	//
	$Olt_SSH = false;
	$Olt_Auth = false;

	//
	$Olt_ID = $Ses->Get( "Olt.ID" );
	$Olt_Init = $Ses->Get( "Olt.Conn" );

	//
	$Olt_Address = $Ses->Get( "Olt.Address" );
	$Olt_Port = $Ses->Get( "Olt.Port" );
	$Olt_User = $Ses->Get( "Olt.User" );
	$Olt_Passwd = $Ses->Get( "Olt.Pass" );
	$Olt_Res = "";


	//
	//
	if ( !empty( $_POST['Option'] ) ) {

		//
		//
		$Option = $_POST['Option'];
		$Form = $_POST['frm_name'];
		$Command = $_POST['Command'];


		//
		//
		if ( $Option == 1 && $Command == 1 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );
	
			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}
	
			//
			$Olt_SSH->read('typ:isadmin:~$');
			$Olt_SSH->write("show pon unprovision-onu \n");
			$Olt_Res = $Olt_SSH->read('typ:isadmin:~$');

			//
			echo "
			<br />
			<h4 class=\"w3-left w3-opacity\">Retorno</h4>
			<br />
			<hr class=\"w3-clear\">
			<form id=\"Alcatel_Res\" onSubmit=\"return AjaxPOST('Alcatel.SSH.php', 'Main', 'Alcatel_Res');\">
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"840\">
					<tr height=\"310\" valign=\"middle\">
						<td align=\"left\">
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Res."</textarea>
						</td>
					</tr>
					<tr valign=\"middle\">
						<td align=\"left\">
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\" onClick=\"document.getElementById('Alert').style.display='none';\">Fechar</button>
						</td>
					</tr>
				</table>
			</form>
			<br /><br /><br />";
			return true;
		}


		//
		//
		if ( $Option == 1 && $Command == 2 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );
	
			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}
	
			//
			$Olt_SSH->read('typ:isadmin:~$');
			$Olt_SSH->write("show equipment temperature \n");
			$Olt_Res = $Olt_SSH->read('typ:isadmin:~$');

			//
			echo "
			<br />
			<h4 class=\"w3-left w3-opacity\">Retorno</h4>
			<br />
			<hr class=\"w3-clear\">
			<form id=\"Alcatel_Res\" onSubmit=\"return AjaxPOST('Alcatel.SSH.php', 'Main', 'Alcatel_Res');\">
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"840\">
					<tr height=\"310\" valign=\"middle\">
						<td align=\"left\">
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Res."</textarea>
						</td>
					</tr>
					<tr valign=\"middle\">
						<td align=\"left\">
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\" onClick=\"document.getElementById('Alert').style.display='none';\">Fechar</button>
						</td>
					</tr>
				</table>
			</form>
			<br /><br /><br />";
			return true;
		}


		//
		//
		if ( $Option == 1 && $Command == 3 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );
	
			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}
	
			//
			$Olt_SSH->read('typ:isadmin:~$');
			$Olt_SSH->write("admin save \n");
			$Olt_SSH->write("admin software-mngt ihub database save-protected \n");
			$Olt_SSH->write("exit all \n");
			$Olt_Res = $Olt_SSH->read('typ:isadmin:~$');

			//
			echo "
			<br />
			<h4 class=\"w3-left w3-opacity\">Retorno</h4>
			<br />
			<hr class=\"w3-clear\">
			<form id=\"Alcatel_Res\" onSubmit=\"return AjaxPOST('Alcatel.SSH.php', 'Main', 'Alcatel_Res');\">
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"840\">
					<tr height=\"310\" valign=\"middle\">
						<td align=\"left\">
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Res."</textarea>
						</td>
					</tr>
					<tr valign=\"middle\">
						<td align=\"left\">
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\" onClick=\"document.getElementById('Alert').style.display='none';\">Fechar</button>
						</td>
					</tr>
				</table>
			</form>
			<br /><br /><br />";
			return true;
		}




		//
		//
		if ( $Option == 1 && $Command == 4 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH" ) ) {

			//
			$Script = $_POST['Script'];

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );
	
			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}
	
			//
			$Olt_SSH->read('typ:isadmin:~$');
			$Olt_SSH->write("".$Script );
			$Olt_Res = $Olt_SSH->read('typ:isadmin:~$');

			//
			echo "
			<br />
			<h4 class=\"w3-left w3-opacity\">Retorno</h4>
			<br />
			<hr class=\"w3-clear\">
			<form id=\"Alcatel_Res\" onSubmit=\"return AjaxPOST('Alcatel.SSH.php', 'Main', 'Alcatel_Res');\">
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"840\">
					<tr height=\"310\" valign=\"middle\">
						<td align=\"left\">
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Res."</textarea>
						</td>
					</tr>
					<tr valign=\"middle\">
						<td align=\"left\">
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\" onClick=\"document.getElementById('Alert').style.display='none';\">Fechar</button>
						</td>
					</tr>
				</table>
			</form>
			<br /><br /><br />";
			return true;
		}







	}


	//
	//


	?>
