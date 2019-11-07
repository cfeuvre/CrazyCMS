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

$template->set_filename ( './modules/newsletter/bloc.tpl' , FALSE , $row['colonne'] );
$template->assign_bloc_name ( 'BLOC_NEWSLETTER_TITLE' , ucfirst ( $row['tbloc'] ) );

include_once ( './mods/newsletter/langues/'.$u_lang.'.php' );

if(isset($_POST['newsletter_email'])){
	$query = $Bdd->sql('SELECT * FROM '.PT.'_newsletter WHERE email="'.$Bdd->secure ( $_POST['newsletter_email'] ).'"' );
	if($Bdd->get_num_rows($query)==0){
		if (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $Bdd->secure($_POST['newsletter_email']))){
			$Bdd->sql('INSERT INTO '.PT.'_newsletter (email, user, date_registration) VALUES ("'.$Bdd->secure($_POST['newsletter_email']).'","'.$uid.'","'.time().'")' );
			$template->assign_block_vars ( 'bloc_newsletter_text' , array (
			'TXT' => NEWSLETTER_REGISTRATION_SUCCESSFULL ) );
		}
		else{
			$template->assign_block_vars ( 'bloc_newsletter_text' , array (
			'TXT' => NEWSLETTER_EMAIL_INVALID ) );
		}
	}
	else{
			$template->assign_block_vars ( 'bloc_newsletter_text' , array (
			'TXT' => NEWSLETTER_ALREADY_REGISTED ) );
	}
	$Bdd->free_result($query);
}
else{
	$template->assign_block_vars ( 'bloc_newsletter_register' , array (
	'REGISTER' => REGISTER_NEWSLETTER,
	'VALID' => valid ) );
}
?>
