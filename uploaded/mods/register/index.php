<?php
/*
Copyright CrazyCMS : 

Valmori Quentin
	quentin.valmori@gmail.com
Feuvre Christophe
	neowan@live.fr
Haustrate Kevin
	gippel5@hotmail.com

This software is a computer program whose purpose is to make our own 
website. You just have to follow the automatic installation procedure
and you website is operational. Moreover, He is securized and optimized 
as much as possible.

This software is governed by the CeCILL² license under French law and
abiding by the rules of distribution of free software.  You can  use, 
modify and/ or redistribute the software under the terms of the CeCILL²
license as circulated by CEA, CNRS and INRIA at the following URL
"http://www.cecill.info". 

The fact that you are presently reading this means that you have had
knowledge of the CeCILL² license and that you accept its terms.
*/
if ( !defined('CCMS') )die('' );
if( ( $grade == 0 || $grade == 1 ) && $lock_registration == 0 ){

$template->set_filename ( 'haut_mods.tpl' );
$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => recording ) );

$template->set_filename ( './modules/register/index.tpl' );
$template->assign_block_vars ( 'index' , array ( 'JS' =>'
<script type="text/javascript">
	<!--

		function verif_pseudo() {			
			var xhr_object = null; 

			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest();
			else if(window.ActiveXObject) // Internet Explorer 
			   xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
			
			var data = "pseudos=" + document.getElementById(\'pseudo\').value;
			 
			xhr_object.open("POST", "./mods/register/verif.php?pseudo", true); 

			xhr_object.onreadystatechange = function() { 
			   if(xhr_object.readyState == 4) 
					{ 
					var retour =  xhr_object.responseText.split("|**|-|**|");
					document.getElementById(\'pseudo_div\').innerHTML = retour[0];
					if ( retour[1] == "1" )document.getElementById(\'pseudo_tmp\').value = "true";
					if ( retour[1] == "0" )document.getElementById(\'pseudo_tmp\').value = "false";
					blok_form();
				}
			}
			 
			xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
			
			xhr_object.send(data); 
		}


		function verif_email() {
			var xhr_object = null; 

			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest();
			else if(window.ActiveXObject) // Internet Explorer 
			   xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
			
			var data = "e-mail=" + document.getElementById(\'email\').value;
			
			xhr_object.open("POST", "./mods/register/verif.php?email", true); 

			xhr_object.onreadystatechange = function() { 
			   if(xhr_object.readyState == 4){
					var retour =  xhr_object.responseText.split("|**|-|**|");
					document.getElementById(\'email_div\').innerHTML = retour[0];
					if ( retour[1] == "1" )document.getElementById(\'email_tmp\').value = "true";
					if ( retour[1] == "0" )document.getElementById(\'email_tmp\').value = "false";
					blok_form();
				}
			}
			 
			xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
			
			xhr_object.send(data); 
		}

		function blok_form(){

			if(document.getElementById(\'email_tmp\').value == "true" && document.getElementById(\'pseudo_tmp\').value == "true" && document.getElementById(\'secu_tmp\').value == "true" && document.getElementById(\'pass_tmp\').value == "true"){
				document.getElementById(\'submit\').disabled = "";
			}
			else{
				document.getElementById(\'submit\').disabled = "true";
			}
						
		}

		function verif_pass(){
			var pass1 = document.getElementById(\'pass1\').value;
			var pass2 = document.getElementById(\'pass2\').value;
			if(pass1 == ""){
				document.getElementById(\'different\').innerHTML = "<span style=\"color:red;\">'.champ_vide.'</span>";
				document.getElementById(\'pass_tmp\').value = "false";
			}
			else{
				if(pass1 == pass2){
					document.getElementById(\'different\').innerHTML = "<span style=\"color:green;\">'.pass_identiques.'</span>";
					document.getElementById(\'pass_tmp\').value = "true";
				}
				else{
					document.getElementById(\'different\').innerHTML = "<span style=\"color:red;\">'.pass_different.'</span>";
					document.getElementById(\'pass_tmp\').value = "false";
				}
			}
			blok_form();
		}

		function verif_code(){
		
			var xhr_object = null; 

			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest();
			else if(window.ActiveXObject) // Internet Explorer 
			   xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
			
			var data = "code=" + document.getElementById(\'scode\').value + "&ip='.$HTTP_SERVER_VARS['REMOTE_ADDR'].'";
			
			xhr_object.open("POST", "./mods/register/verif.php?code", true); 

			xhr_object.onreadystatechange = function() { 
			   if(xhr_object.readyState == 4) 
					{
					var retour =  xhr_object.responseText;
						if(retour=="good"){
							document.getElementById(\'code_div\').innerHTML = "<span style=\"color:green;\">'.good_code.'</span>";
							document.getElementById(\'secu_tmp\').value = "true";	
						}
						else{
							document.getElementById(\'code_div\').innerHTML = "<span style=\"color:red;\">'.false_code.'</span>";
							document.getElementById(\'secu_tmp\').value = "false";
						}
					blok_form();
					}
					}
			 
			 xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
			
			xhr_object.send(data); 
		}

		function effacer_champ(defaut,champ){
			var champs = document.getElementById(champ).value;
			if(champs==defaut){
				document.getElementById(champ).value = \'\';
			}
		}
	-->
</script>',
'REGISTER_PSEUDO' => register_pseudo,
'REGISTER_PASS' => register_pass,
'REGISTER_PASS2' => register_pass_2,
'REGISTER_MAIL' => register_mail,
'VALID' => valid ) );

	if ( $register_security_code == 1 ){
	// Générations d'un code aléatoire  :
    
	$minuscules = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );

    $majuscules = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );

    $code = ''; 
	
	for ($i = 1; $i <= 8 ; $i++){

	$type = mt_rand(0,2);

		switch ($type)
		{
			case 0:
				 $caractere = mt_rand(2,9);
							 $code .= $caractere;
			break;
			
			case 1:
				 $nbre_aleatoire = mt_rand(0, 23);
							 $caractere = $majuscules[$nbre_aleatoire];
							 $code .= $caractere;
			break;
			
			case 2:
				 $nbre_aleatoire = mt_rand(0, 22);
							 $caractere = $minuscules[$nbre_aleatoire];
							 $code .= $caractere;
			break;
		}
	}

	$Bdd->sql('DELETE FROM '.PT.'_parametres WHERE nom="register:'.$Bdd->secure($HTTP_SERVER_VARS['REMOTE_ADDR']).'" ' );
	$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES("","register:'.$Bdd->secure($HTTP_SERVER_VARS['REMOTE_ADDR']).'","'.$code.'")' );
	
	$template->assign_block_vars ( 'index.secu' , array (
	'REGISTER_CODE_DEF' => register_code_def,
	'REGISTER_CODE' => register_code ) );
	
	}
	else{
		$template->assign_block_vars ( 'index.nsecu' , array ( 'JS' => '
		<script type="text/javascript">
			<!--
				document.getElementById(\'secu_tmp\').value = "true";	
			-->
		</script>' ) );
	}

	$template->set_filename ( 'bas_mods.tpl' );

}
else if ( $lock_registration == 1 ){
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => REGISTRATION_STOPPED ) );
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ALREADY_REGISTED ) );
}
?>