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

	include('../../mods/galerie_photo/langues/'.$default_langage.'.php' );
	include('../../langues/'.$default_langage.'/lang.php' );
	
	// On importe la liste des users
	$req_user = $Bdd->sql('SELECT '.PT.'_users.pass AS pass, '.PT.'_users.permission AS permission, '.PT.'_users.grades AS grades FROM '.PT.'_users WHERE id="'.intval($_POST['uid']).'"' );
	$sql_user = $Bdd->get_array ( $req_user );
	$Bdd->free_result ( $req_user );

	//Chargement info users si c'est bon										
	if ( $sql_user['pass'] == htmlspecialchars ( $_POST['password'] ) ){
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
	if( ereg ( 'gallery_vote;' , $permissions ) OR $grade == 4){
	
	   $vote = intval($_POST['vote']);
	   if($vote<0)$vote = 0;
	   if($vote>5)$vote = 5;

	   $nom = htmlspecialchars($_POST['pic'],ENT_QUOTES);
		
		$query = $Bdd->sql('SELECT votes FROM '.PT.'_gallery WHERE nom="'.$nom.'"' );  
		$sql = $Bdd->get_array($query);
		$votes = $sql['votes'];

		if(ereg('[0-9]\|'.intval($_POST['uid']),$votes)){
			echo VOTE_ONCE;
		}
		else{
			$votes .= $vote.'|'.intval($_POST['uid']).';';
			$Bdd->sql('UPDATE '.PT.'_gallery SET votes="'.$votes.'" WHERE nom="'.$nom.'"' );  
			echo VOTE_SUCCESSFULLY_ADDED;
		}
	}
	else{
		echo CANT_VOTE;
	}
?>