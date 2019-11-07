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
header('Content-type: text/html; charset=iso-8859-15' ); 
include ( '../../includes/config.php' );
include ( '../../includes/fonctions.php' );

// On charge la thème
include('../../includes/class.template.php' );
$template = new Template( '../../themes/'.htmlspecialchars($_POST['theme'],ENT_QUOTES) , TRUE );
$template->set_filename ( 'modules/forum/admin.tpl' );

// On charge la langue
include_once('../../langues/'.htmlspecialchars ( $_POST['lang'] ).'/lang.php' );
include_once('./langues/'.htmlspecialchars ( $_POST['lang'] ).'.php' );

define ( 'CCMS' , TRUE );

// On recupere le grade de l'utilisateur ;)
$query = $Bdd->sql( 'SELECT grades FROM '.PT.'_users WHERE id="'.intval($_POST['iduser']).'" AND pass="'.htmlspecialchars($_POST['pass'],ENT_QUOTES).'"' );
$sql = $Bdd->get_array( $query );
$grade = $sql['grades'];

$qu_for = $Bdd->sql ( 'SELECT valeur FROM '.PT.'_parametres WHERE nom = "forum_grade_admin"' );
$forum = $Bdd->get_array ( $qu_for );


$grades = explode ( ',' , $forum['valeur'] );
if( $grade==4 || in_array ( $grade , $grades , TRUE ) ){

	//On recupere tous les sous forum associes au forum sur lequel l'utilisateur a cliqué
	$query = $Bdd->sql('SELECT id,nom,def,locked,position FROM '.PT.'_forum_for WHERE parent="'.htmlspecialchars($_POST['id'],ENT_QUOTES).'" AND is_sub="1" ORDER BY position' );

	while($sql = $Bdd->get_array($query)){

		if($sql['locked']==0)
			$verrou = UNLOCKED;
		else
			$verrou = LOCKED;

		// Array des couleurs en fonction du niveau dans l'arborescence ;)
		$colors = array('#FF0000' , '#FF3300' , '#FF6600' , '#FF9900' , '#FFCC00' , '#FFFF00' );

		$template->assign_block_vars ( 'admin_manage_ajax' , array (
		'COLOR' => $colors[intval($_POST['sub'])],
		'ID' => $sql['id'],
		'COUNT_SUB' => ( intval ( $_POST['sub'] ) + 1 ),
		'LANG' => htmlspecialchars ( $_POST['lang'] ),
		'NAME' => to_html ( $sql['nom'] , '../..' ),
		'CHOOSE_ACTION' => CHOOSE_ACTION,
		'LOCK' => LOCK,
		'UNLOCK' => UNLOCK,
		'ADD_SUB' => ADD_SUB,
		'MODIF' => MODIF,
		'DELETE' => delete,
		'MANAGE_MODERATORS' => MANAGE_MODERATORS,
		'VERROU' => $verrou,
		'DEF' => to_html ( $sql['def'] , '../..' ),
		'POSITION' => $sql['position'],
		'CAT_ID' => intval ( $_POST['id'] ) ) );

		for($i = 0;$i<=intval($_POST['sub']);$i++)
			$template->assign_block_vars ( 'admin_manage_ajax.space' , array () );
	}
}
else{

	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );

}

$template->gen();
?>
