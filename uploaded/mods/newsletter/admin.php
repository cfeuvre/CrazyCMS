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
$grades = explode ( ',' , $newsletter_grade_admin );
if ( $grade ==4 || in_array ( $grade , $grades , TRUE ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => NEWSLETTER ) );
	$template->set_filename ( './modules/newsletter/admin.tpl' );
	
	if ( isset ( $_GET['send_news'] ) ){

		if ( isset ( $_POST['contenu'] ) ){
			if ( isset ( $_POST['destin'] ) AND $_POST['destin'] == 0 ){
				$query = $Bdd->sql( '
				SELECT 
					news.email AS email,
					user.pseudo AS pseudo
				FROM 
					'.PT.'_newsletter AS news,
					'.PT.'_users AS user
				WHERE news.user = user.id' );
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					
					//On envoie tt mail d'un coup
					$entete = "MIME-Version: 1.0\r\n";
					$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$entete .= "To: ".htmlspecialchars ( $sql['pseudo'] , ENT_QUOTES )." <".htmlspecialchars ( $sql['email'] , ENT_QUOTES ).">\r\n";
					$entete .= "From: $nom_site\r\n";
					
					@mail ( htmlspecialchars ( $sql['email'] , ENT_QUOTES ) , to_html ( $_POST['title'] ) , to_html ( $_POST['contenu'] ) , $entete);
				}
				
				$template->assign_block_vars ( 'send_form_valid' , array (
				'TXT' => NEWSLETTER_SENDED_TO_REGISTED,
				'BACK' => back ) );
				
			}
			else{
				$query = $Bdd->sql( 'SELECT pseudo, email FROM '.PT.'_users' );
				
				while ( $sql = $Bdd->get_array ( $query ) ){
					
					//On envoie tt mail d'un coup
					$entete = "MIME-Version: 1.0\r\n";
					$entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$entete .= "To: ".htmlspecialchars ( $sql['pseudo'] , ENT_QUOTES )." <".htmlspecialchars ( $sql['email'] , ENT_QUOTES ).">\r\n";
					$entete .= "From: $nom_site\r\n";
					
					@mail ( htmlspecialchars ( $sql['email'] , ENT_QUOTES ) , to_html ( $_POST['title'] ) , to_html ( $_POST['contenu'] ) , $entete);
				}
				$template->assign_block_vars ( 'send_form_valid' , array (
				'TXT' => NEWSLETTER_SENDED_TO_ALL,
				'BACK' => back ) );
			}
		}
		else{
			// Formulaire pr envoi
			$template->assign_block_vars ( 'send_form' , array (
			'DESTIN' => NEWSLETTER_CHOOSE_DESTIN,
			'REGISTED' => NEWSLETTER_REGISTED_ONLY,
			'ALL' => NEWSLETTER_ALL_USERS,
			'FORM' => default_form ( TRUE )
			) );
		}
	}
	else if ( isset ( $_GET['truncate'] ) ){
		$Bdd->sql( 'TRUNCATE TABLE '.PT.'_newsletter' );
		$template->assign_block_vars ( 'truncated' , array (
		'TXT' => NEWSLETTER_TRUNCATED_SUCCESFFULLY,
		'BACK' => back ) );
	}
	else{
		$template->assign_block_vars ( 'index' , array (
		'SEND' => SEND_NEWSLETTER,
		'TRUNCATE' => NEWSLETTER_EMPTY_LIST ) );
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>