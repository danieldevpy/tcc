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
	$Account = $Ses->Get("Account");
	$User = $Ses->Get("User");

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
	$Olt_Buff = "";







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
			$Script = $_POST['Script'];

			//
			if ( empty( $Script ) || empty( $Script ) ) {
				$Show = "Error Command Script";
			}

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("".$Script );
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

			//
			echo "".$Olt_Buff;
			return true;
		}


		//
		//
		if ( $Option == 1 && $Command == 2 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH" ) ) {

			//
			$Script = $_POST['Script'];

			//
			if ( empty( $Script ) || empty( $Script ) ) {
				$Show = "Error Command Script";
			}

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("".$Script );
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

			//
			echo "
			<br />
			<h4 class=\"w3-left w3-opacity\">Retorno SSH</h4>
			<br />
			<form id=\"Alcatel_SSH\" onSubmit=\"return AjaxPOST('Script/SSH.AlcatelFX.php', 'AlertResult', 'Alcatel_SSH');\">
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"840\">
					<tr height=\"310\" valign=\"middle\">
						<td align=\"left\">
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">$Olt_Buff</textarea>
						</td>
					</tr>
					<tr valign=\"middle\">
						<td align=\"left\">
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\" onClick=\"document.getElementById('Alert').style.display='none';\">Fechar</button>
							<input type=\"hidden\" name=\"Option\" value=\"1\" />
							<input type=\"hidden\" name=\"Command\" value=\"2\" />
						</td>
					</tr>
				</table>
			</form>
			<br /><br />";
			return true;
		}


		// ShowPonUnprovision
		//
		if ( $Option == 1 && $Command == 3 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port, 30 );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
//			$Olt_SSH->enableQuietMode();
			$Olt_SSH->enablePTY();

			//
			$Olt_Buff = $Olt_SSH->read('/.*@.*[$|#|>]/', NET_SSH2_READ_REGEX);
			$Olt_SSH->write( "environment inhibit-alarms \r\n" );

			//
//			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("show pon unprovision-onu \r\n");

			//
			$Olt_Buff  .= "";
//			$Olt_Buff .= $Olt_SSH->read("typ:isadmin:~$");
			$Olt_Buff .= $Olt_SSH->read("unprovision-onu count : " );




			//
			$Olt_Buff = preg_replace("/=/", "=\"\"", $Olt_Buff);

			//
			$Olt_Buff = preg_replace ('/<[^>]*>/', '', $Olt_Buff);
			$Olt_Buff = str_replace( "1D1D1D1D", "", $Olt_Buff);
//			$Olt_Buff = str_replace( "1D", "", $Olt_Buff);
			$Olt_Buff = str_replace( "1D/", "", $Olt_Buff);
			$Olt_Buff = str_replace( "1D\\", "", $Olt_Buff);
			$Olt_Buff = str_replace( "1D|", "", $Olt_Buff);
			$Olt_Buff = str_replace( "1D/", "", $Olt_Buff);
			$Olt_Buff = str_replace( "\"", "", $Olt_Buff);
			$Olt_Buff = str_replace( "|", "", $Olt_Buff);
			$Olt_Buff = str_replace( "[1D", "", $Olt_Buff);

			//
			$Olt_Buff = str_replace( "", "", $Olt_Buff);
			$Olt_Buff = str_replace( "[", "", $Olt_Buff);
			$Olt_Buff = str_replace( "-", "", $Olt_Buff);
			$Olt_Buff = str_replace( "+", "", $Olt_Buff);
			$Olt_Buff = str_replace( "&quot;", "", $Olt_Buff);
			$Olt_Buff = str_replace( '\\', "", $Olt_Buff);
			$Olt_Buff = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $Olt_Buff);
			$Olt_Buff = trim(preg_replace('/ {2,}/', ' ', $Olt_Buff));

			//
			$Olt_Buff = str_replace( '//', "", $Olt_Buff);
			$Olt_Buff = str_replace( '/ ', "", $Olt_Buff);

			//


			//
			$Handle = fopen( "./tmp/".$Account.".txt", "w");
			fwrite($Handle, $Olt_Buff );
			fclose($Handle);

			//
			echo "
			<hr class=\"w3-clear\" />
			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"w3-table w3-striped w3-hoverable w3-white\" width=\"100%\">
				<tr valign=\"middle\" height=\"40\">
					<td align=\"center\" width=\"80\"></td>
					<td align=\"center\" width=\"40\"><b>Alarm</b></td>
					<td align=\"center\" width=\"40\"><b>Chassi</b></td>
					<td align=\"center\" width=\"40\"><b>Rack</b></td>
					<td align=\"center\" width=\"40\"><b>Slot</b></td>
					<td align=\"center\" width=\"40\"><b>Pon</b></td>
					<td align=\"center\" width=\"\"><b>Serial</b></td>
					<td align=\"center\" width=\"\"><b>LogicalAuthID</b></td>
				</tr>";

			//
			$Handle = fopen( "./tmp/".$Account.".txt", "r");

			//
			while ($Line = fgets($Handle, 1024)) {

				//
//				if ( ($Line[0] == '/' && $Line[1] == '/') || $Line[0] == "\0" || $Line[0] == "\n" || $Line[0] == "\r") {
//					continue;
//				}

				//
				$Ont = sscanf($Line, "%d %d/%d/%d/%d %s %s");

				//
				if (isset($Ont[0]) && isset($Ont[1])) {
		
					for($i = 1; isset($Ont[1][$i]); $i++)
		
						if ($Ont[1][$i] == '_')
							$Ont[1][$i] = ' ';

						//
						echo "
				<tr valign=\"middle\" height=\"40\">
					<td align=\"center\" width=\"40\">
						<button type=\"submit\" class=\"w3-button w3-green\" style=\"width: 140px;\"
							onClick=\"
								AjaxURL('AlcatelFX/Ont.UnprovisionRegister.php?Option=1&Rack=1&Slot=$Ont[3]&Pon=$Ont[4]&Serial=$Ont[5]', 'HTML' );
								document.getElementById('Alert').style.display='none';
								document.getElementById('HTML').style.display='block';\"><i class=\"fa fa-edit\"> Autorizar</i>
						</button>
					</td>
					<td align=\"center\" width=\"40\">".$Ont[0]."</td>
					<td align=\"center\" width=\"40\">".$Ont[1]."</td>
					<td align=\"center\" width=\"40\">".$Ont[2]."</td>
					<td align=\"center\" width=\"\">".$Ont[3]."</td>
					<td align=\"center\" width=\"40\">".$Ont[4]."</td>
					<td align=\"center\" width=\"40\">".$Ont[5]."</td>
					<td align=\"center\" width=\"40\">".$Ont[6]."</td>
				</tr>";
				}
			}	

			//
			fclose($Handle);

			//
			echo "
			</table>
			<br /><br /><br />
			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"w3-table w3-striped w3-hoverable w3-white\" width=\"100%\">
				<tr height=\"310\" valign=\"middle\">
					<td align=\"left\">
						<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Buff."</textarea>
					</td>
				</tr>
			</table>
			<br /><br /><br />";
			return true;
		}


		//
		//
		if ( $Option == 1 && $Command == 4 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH_Command" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("show equipment temperature \n");
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

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
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Buff."</textarea>
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
		if ( $Option == 1 && $Command == 5 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH_Command" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("admin save \n");
			$Olt_SSH->write("admin software-mngt ihub database save-protected \n");
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

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
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Buff."</textarea>
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
		if ( $Option == 1 && $Command == 6 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH_Command" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("show software-mngt version etsi \n");
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

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
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Buff."</textarea>
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


		// CPU Load
		//
		if ( $Option == 1 && $Command == 7 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH_Command" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("debug-command current-cpu-core-load nt-a \n");
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

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
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Buff."</textarea>
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


		// Reboot-ISam Fast
		//
		if ( $Option == 1 && $Command == 8 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH_Command" ) ) {

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("admin equipment reboot-isam without-self-test \n");
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

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
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">".$Olt_Buff."</textarea>
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
		if ( $Option == 1 && $Command == 6 && isset( $Form ) && !strcmp( $Form, "Alcatel_SSH_dBm" ) ) {

			//
			$Script = $_POST['Script'];
			$OID = $_POST['OID'];
			$Slot = $_POST['Slot'];
			$Pon = $_POST['Pon'];
			$Ont = $_POST['Ont'];

			//
			if ( empty( $Script ) || empty( $Script ) ) {
				$Show = "Error Command Script";
			}

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, $Olt_Port );
			$Olt_Auth = $Olt_SSH->login( $Olt_User, $Olt_Passwd );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("".$Script );
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

			//
			$Olt_Buff = preg_replace ('/<[^>]*>/', '', $Olt_Buff);
			$Olt_Buff = str_replace( "1D", "", $Olt_Buff);
			$Olt_Buff = str_replace( "\"", "", $Olt_Buff);
			$Olt_Buff = str_replace( "|", "", $Olt_Buff);
			
			//
			$Olt_Buff = str_replace( "", "", $Olt_Buff);
			$Olt_Buff = str_replace( "[", "", $Olt_Buff);
//			$Olt_Buff = str_replace( "-", "", $Olt_Buff);
			$Olt_Buff = str_replace( "+", "", $Olt_Buff);
			$Olt_Buff = str_replace( "&quot;", "", $Olt_Buff);
			$Olt_Buff = str_replace( '\\', "", $Olt_Buff);
			$Olt_Buff = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $Olt_Buff);
			$Olt_Buff = trim(preg_replace('/ {2,}/', ' ', $Olt_Buff));

			//
			$Olt_Buff = str_replace( ".", " ", $Olt_Buff);

			//
			$Olt_Buff = str_replace( '//', "", $Olt_Buff);
			$Olt_Buff = str_replace( '/ ', "", $Olt_Buff);

			//
			$Handle = fopen( "./tmp/".$Account.".txt", "w");
			fwrite($Handle, $Olt_Buff );
			fclose($Handle);

			//
			$Handle = fopen( "./tmp/".$Account.".txt", "r");

			//
			$Rx = false;
			$Tx = false;
		

			//
			while ($Line = fgets($Handle, 1024)) {
		
				//
				if ( ($Line[0] == '/' && $Line[1] == '/') || $Line[0] == "\0" || $Line[0] == "\n" || $Line[0] == "\r" )
					continue;

				// 1/1/1/3/1 -22 924 2 576 57 000 3 26 13800 0 -26 5 
				//
				$Data = sscanf($Line, "1/1/%d/%d/%d %d %d %d %d");

				//
				if ( isset($Data[0]) && isset($Data[1] ) ) {
		
					for( $i = 1; isset($Data[1][$i]); $i++ )
		
						if ($Data[1][$i] == '_')
							$Data[1][$i] = ' ';

						$Rx = $Data[3].".".$Data[4];
						$Tx = $Data[5].".".$Data[6];
				}
			}	

			//
			fclose($Handle);

			//
			$Query = sprintf( "UPDATE `onu` SET `Rx`='%s',`Tx`='%s' WHERE `OnuID` = '%d';", $Rx, $Tx, $OID );
			$Sql->Query( $Query, 'index.php');

			//
			echo "
			<br />
			<h4 class=\"w3-left w3-opacity\">Retorno SSH</h4>
			<br />
			<form id=\"Alcatel_SSH\" onSubmit=\"return AjaxPOST('Script/SSH.AlcatelFX.php', 'AlertResult', 'Alcatel_SSH');\">
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"840\">
					<tr height=\"310\" valign=\"middle\">
						<td align=\"left\">
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">$Olt_Buff</textarea>
						</td>
					</tr>
					<tr valign=\"middle\">
						<td align=\"left\">
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\">Rx: $Rx</button>
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\">Tx: $Tx</button>
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\" onClick=\"document.getElementById('Alert').style.display='none';\">Fechar</button>
							<input type=\"hidden\" name=\"Option\" value=\"1\" />
							<input type=\"hidden\" name=\"Command\" value=\"2\" />
						</td>
					</tr>
				</table>
			</form>
			<br /><br />";
			return true;
		}



		//
		//
		if ( $Option == 1 && $Command == 1 && isset( $Form ) && !strcmp( $Form, "Alcatel_TL1" ) ) {

			//
			$Script = $_POST['Script'];

			//
			if ( empty( $Script ) || empty( $Script ) ) {
				$Show = "Error Command Script";
			}

			//
			$Olt_SSH = new Net_SSH2( $Olt_Address, 1022 );
			$Olt_Auth = $Olt_SSH->login( "SUPERUSER", "ANS#150" );

			//
			if ( !$Olt_SSH ) {
				exit('Conn Failed');
			}

			//
			if ( !$Olt_Auth ) {
				exit('Auth Failed');
			}

			//
			$Olt_SSH->read("typ:isadmin:~$");
			$Olt_SSH->write("".$Script );
			$Olt_Buff = $Olt_SSH->read('typ:isadmin:~$');

			//
			echo "
			<br />
			<h4 class=\"w3-left w3-opacity\">Retorno SSH</h4>
			<br />
			<form id=\"Alcatel_TL1\" onSubmit=\"return AjaxPOST('Script/SSH.AlcatelFX.php', 'AlertResult', 'Alcatel_TL1');\">
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"840\">
					<tr height=\"310\" valign=\"middle\">
						<td align=\"left\">
							<textarea name=\"Script\" onKeyPress=\"return force(this.name,this.form.id,event);\" style=\"width: 830px; height: 300px;\">$Olt_Buff</textarea>
						</td>
					</tr>
					<tr valign=\"middle\">
						<td align=\"left\">
							<button type=\"button\" class=\"w3-button w3-padding-large w3-green\" onClick=\"document.getElementById('Alert').style.display='none';\">Fechar</button>
							<input type=\"hidden\" name=\"Option\" value=\"1\" />
							<input type=\"hidden\" name=\"Command\" value=\"2\" />
						</td>
					</tr>
				</table>
			</form>
			<br /><br />";
			return true;
		}



		//
		//

	}



	//
	//


	?>
