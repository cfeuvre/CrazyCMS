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
header('Content-type: text/html; charset=iso-8859-1' ); 

	include('../../includes/config.php' );
	include('../../includes/fonctions.php' );
	// On importe les parametres
	$req_param=$Bdd->sql('SELECT nom,valeur FROM '.PT.'_parametres' );
	while ($result_param = $Bdd->get_object($req_param)){
		${$result_param->nom} = $result_param->valeur;				 
	}
	
	$req_grades = $Bdd->sql('SELECT nbr, name, permissions FROM '.PT.'_grades' );
	while ($req_grade = $Bdd->get_array ( $req_grades ) ){
		${'grade_'.$req_grade['nbr']} = array ( 
			'name' => $req_grade [ 'name' ],
			'permissions' => $req_grade [ 'permissions' ]
			);
	}
	
	include('../../includes/class.template.php' );
	$template = new Template( '../../themes/'.htmlspecialchars($_POST['theme'],ENT_QUOTES) , TRUE );
	$template->set_filename ( './modules/galerie_photo/view_comment.tpl' );
	
	define ( 'CCMS' , TRUE );

	include('../../mods/galerie_photo/langues/'.$default_langage.'.php' );
	include('../../langues/'.$default_langage.'/lang.php' );
	
	// On importe la liste des users
	$req_user = $Bdd->sql('SELECT '.PT.'_users.pass AS pass, '.PT.'_users.permission AS permission, '.PT.'_users.grades AS grades FROM '.PT.'_users WHERE id="'.intval($_POST['id']).'"' );
	$sql_user = $Bdd->get_array ( $req_user );
	$Bdd->free_result ( $req_user );

	//Chargement info users si c'est bon										
	if ( $sql_user['pass'] == htmlentities ( $_POST['password'] ) ){
		$user_password = $sql_user['pass'];
		$grade = $sql_user['grades'];
		$permissions = $sql_user['permission'];
		
		// On va fusionner les permissions que l'utilisateur possede avec celle héritée de son grade ;)
		
		// On recupere les permissions de l'utilisateur dans un array
		$permissions_user = explode ( ';' , $permissions );
		
		// On recupere celle du grade auxquel il appartient dans un autre array
		$permissions_grade = explode ( ';' , ${'grade_'.$grade}['permissions'] );
		
		// On fusionne les deux array
		$permissions_f = array_merge ( $permissions_user , $permissions_grade );
		
		// Et voila ^^.
		$permissions = implode ( ';' , $permissions_f );

	}
	
	if( ereg ( 'view_comment_photo;' , $permissions ) OR $grade == 4){

		$query = $Bdd->sql('SELECT id FROM '.PT.'_gallery WHERE nom="'.htmlspecialchars ( base64_decode ( $_POST['picture'] , ENT_QUOTES ) ).'" AND galerie="'.htmlspecialchars ( base64_decode ( $_POST['dossier'] ) , ENT_QUOTES ).'"' );  
		$sql = $Bdd->get_array($query);

		$queryz = $Bdd->sql('SELECT '.PT.'_gallery_comment.contenu as contenu,'.PT.'_gallery_comment.date as date,'.PT.'_gallery_comment.smiley as smilies,
											'.PT.'_users.pseudo as pseudo
			  							FROM '.PT.'_gallery_comment, '.PT.'_users
			  							
										WHERE '.PT.'_gallery_comment.auteur='.PT.'_users.id AND '.PT.'_gallery_comment.parent = "'.$sql['id'].'"
			  							ORDER BY '.PT.'_gallery_comment.date' );			
		if($Bdd->get_num_rows($queryz) == 0){
			$template->assign_block_vars ( 'txt' , array ( 'TXT' => aucun_comment ) );
		}
		else{
			$template->assign_block_vars ( 'comment' , array () );
			while( $sqlz = mysql_fetch_array ( $queryz ) ){
				$template->assign_block_vars ( 'comment.com' , array (
				'COMMENTS_FROM' => COMMENTS_FROM,
				'PSEUDO' => $sqlz['pseudo'],
				'THE' => the,
				'DATED' => date ( 'd/m/Y' , $sqlz['date'] ),
				'AT' => at,
				'DATEH' => date ('H \h i' , $sqlz['date'] ),
				'CONTENU' => to_html ( $sqlz['contenu'] ) ) );	
			}
		}
	}
	else{
		$template->assign_block_vars ( 'txt' , array ( 'TXT' => COMMENTS_UNALLOWED ) );
	}
	$template->gen();
	
?>