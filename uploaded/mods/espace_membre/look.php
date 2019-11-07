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
if(!defined('CCMS'))die('' );
if($grade>0){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => messagerie ) );

	$template->set_filename ( './modules/espace_membre/links.tpl' );
	$template->assign_block_vars ( 'links' , array (
	'UID' => $uid,
	'PWD' => $user_password,
	'UNLOG' => unlog,
	'MY_BLOC_NOTE' => my_bloc_note,
	'MODIF_PROFIL' => modif_profil,
	'CHANGE_LANGUAGE' => change_language,
	'CHANGE_THEME' => change_theme,
	'MY_INFOS' => my_infos,
	'MY_CONFIG' => my_config ) );
	
	$template->set_filename ( './modules/espace_membre/look.tpl' );

	//On verifie l'arriver de nouveau message
			$mess_voir=$Bdd->sql('SELECT  '.PT.'_messagerie.id AS idmes,'.PT.'_messagerie.destinataire AS destinataire,'.PT.'_messagerie.auteur AS auteur,'.PT.'_messagerie.titre AS titre,'.PT.'_messagerie.contenu AS contenu,'.PT.'_messagerie.date AS date,'.PT.'_messagerie.vu AS vu,'.PT.'_users.id AS id, '.PT.'_users.pseudo AS pseudo FROM '.PT.'_messagerie, '.PT.'_users WHERE '.PT.'_messagerie.destinataire="'.$uid.'" AND '.PT.'_messagerie.auteur='.PT.'_users.id ORDER BY '.PT.'_messagerie.date DESC' );

	// Supprimer un message
	if (isset ($_POST['sup'])){
	
		$template->assign_block_vars ( 'text' , array (
		'DEL_MESS' => del_mess,
		'DELETED' => selection_mess_delet,
		'BACK' => back ) );

		while ($mess=$Bdd->get_array($mess_voir))
		{
			if(isset($_POST['mess:'.$mess['idmes']]) && $_POST['mess:'.$mess['idmes']]==1){
			//Si le message en cours a ete selectionne pour etre supprime, on le supprime
				if($uid==$mess['destinataire']){
					$Bdd->sql('DELETE FROM '.PT.'_messagerie  WHERE id="'.$mess['idmes'].'"' );
					$template->assign_block_vars ( 'text.line' , array (
					'MESS' => THE_MESS,
					'NOM' => htmlspecialchars($mess['titre']),
					'DELETED' => HAS_BEEN_DELETED ) );
				}
			}
		}
	}
	//Répondre
	else if (isset ($_POST['repondre'])){
		
		$req=$Bdd->sql('SELECT id,pseudo FROM '.PT.'_users WHERE pseudo = "'.$Bdd->secure($_POST['des']).'"' );
		$select_id = $Bdd->get_object($req);
		$id_membre = $select_id->id;
		$rep=$Bdd->sql('INSERT INTO '.PT.'_messagerie VALUES ("","'.intval($id_membre).'","'.intval($uid).'","'.$Bdd->secure($_POST['sujet']).'","'.$Bdd->secure($_POST['contenu']).'","'.convertime(time()).'","1")' );

		$template->assign_block_vars ( 'text' , array (
		'DEL_MESS' => confirmation,
		'DELETED' => answer_sent,
		'BACK' => back ) );
	}
	else if(isset($_GET['action']) && $_GET['action']=="rep"){
	
		$sql=$Bdd->sql('SELECT  '.PT.'_messagerie.id AS idmes,'.PT.'_messagerie.destinataire AS destinataire,'.PT.'_messagerie.auteur AS auteur,'.PT.'_messagerie.titre AS titre,'.PT.'_messagerie.contenu AS contenu,'.PT.'_messagerie.date AS date,'.PT.'_messagerie.vu AS vu,'.PT.'_users.id AS id, '.PT.'_users.pseudo AS pseudo FROM '.PT.'_messagerie, '.PT.'_users WHERE '.PT.'_messagerie.destinataire="'.$uid.'" AND '.PT.'_messagerie.auteur='.PT.'_users.id AND '.PT.'_messagerie.id="'.intval($_GET['id']).'" ORDER BY '.PT.'_messagerie.date ' );
		$sql=$Bdd->get_array($sql);
		if($sql['destinataire']==$uid){
			$template->assign_block_vars ( 'answer' , array (
			'ANSWER_MP' => answer_mp,
			'RECIPIENT' => recipient,
			'PSEUDO' => htmlspecialchars ( $sql['pseudo'] ),
			'AUTHOR' => Author,
			'TOPIC' => Topic,
			'ANSWER' => answer,
			'PPSEUDO' => $pseudo,
			'TITRE' => htmlspecialchars ( $sql['titre'] ),
			'CONTENT' => Content,
			'FORM' => default_form ( FALSE , NULL , preceding_message.' : '.to_html ( $sql['contenu'] ) ) ) );
		}
		else{
			$template->set_filename('error_page.tpl' );
			$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
		}
	}
	// Apercu des Mp
	else if(isset($_GET['action']) && $_GET['action']=="voir"){
		
		$mess_look=$Bdd->sql('
		SELECT  
			'.PT.'_messagerie.id AS idmes,
			'.PT.'_messagerie.destinataire AS destinataire,
			'.PT.'_messagerie.auteur AS auteur,
			'.PT.'_messagerie.titre AS titre,
			'.PT.'_messagerie.contenu AS contenu,
			'.PT.'_messagerie.date AS date,
			'.PT.'_messagerie.vu AS vu,
			'.PT.'_users.id AS id,
			'.PT.'_users.pseudo AS pseudo 
		FROM 
			'.PT.'_messagerie,
			'.PT.'_users 
		WHERE 
			'.PT.'_messagerie.destinataire = "'.$uid.'" 
		AND 
			'.PT.'_messagerie.auteur='.PT.'_users.id 
		AND 
			'.PT.'_messagerie.id="'.intval($_GET['id']).'" 
		ORDER BY 
			'.PT.'_messagerie.id ASC' );

		$notel=$Bdd->get_array($mess_look);
		if ( $notel['destinataire'] == $uid OR $notel['auteur']==$uid ){
			$Bdd->sql('UPDATE '.PT.'_messagerie  SET vu="0" WHERE id="'.intval($_GET['id']).'"' );
			$date = ccmsdate($fuseaux,$notel['date']);
			$contenu = to_html ( $notel['contenu'] );
			
			$template->assign_block_vars ( 'mp' , array (
			'MP' => mp,
			'TITRE' => htmlspecialchars ( $notel['titre'] ),
			'ENVOY_BY' => envoy_by,
			'AUTEUR' => $notel['auteur'],
			'PSEUDO' => htmlspecialchars ( $notel['pseudo'] ),
			'THE' => the,
			'DATE' => $date,
			'CONTENU' => $contenu,
			'ANSWER' => answer,
			'BACK' => back,
			'ID' => $notel['idmes'],
			'TO_PRINT_THIS_MESS' => to_print_this_mess ) );
		}
		else{
			$template->set_filename('error_page.tpl' );
			$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
		}
	}
	//Apercu des MP	
	else{

		if($Bdd->get_num_rows($mess_voir)==0){
			$template->assign_block_vars ( 'none' , array (
			'MP' => mp,
			'NONE_MP' => none_mp ) );
		}
		// Tableau d'apercu des MP
		else{
		
			$template->assign_block_vars ( 'index' , array (
			'SEEN_YOUR_MESSAGES' => seen_your_messages,
			'STATUT' => STATUT,
			'TITLE' => title,
			'SHIPPER' => shipper,
			'DELET' => delet ) );

			while ($mess=$Bdd->get_array($mess_voir)){

				$template->assign_block_vars ( 'index.mp' , array (
				'COLOR' => ( ( $mess['vu'] == 1 ) ? ( '#c00000' ) : ('#202040') ),
				'STATUT' => ( ( $mess['vu'] == 1 ) ? ( new_mess ) : ( readed_mps ) ),
				'ID' => $mess['idmes'],
				'TITRE' => htmlspecialchars ( $mess['titre'] ),
				'PSEUDO' => htmlspecialchars ( $mess['pseudo'] ) ) );
			}
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>