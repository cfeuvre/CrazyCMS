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

$template->set_filename ( 'haut_mods.tpl' );
$template->set_filename ( './modules/groupes/index.tpl' );

if ( !isset ( $_GET['id'] ) ){
	//On sélectionne les différents groupes
	$req_groupe = $Bdd->sql('SELECT '.PT.'_groupe.id,'.PT.'_groupe.nom ,'.PT.'_groupe.description,'.PT.'_groupe.date,'.PT.'_groupe.id_createur ,'.PT.'_groupe.public ,'.PT.'_groupe.nb_users FROM '.PT.'_groupe WHERE '.PT.'_groupe.nom != "" && '.PT.'_groupe.afficher="1"' );
	//On compte le nombre d'entrée
	$compte_groupe = $Bdd->get_num_rows($req_groupe);
	//Si il n'y a pas d'entrée c'est qu'il n'y a pas de groupes donc on le dit
	if ($compte_groupe ==0){
		$template->assign_block_vars ( 'mod_titre' , array (
		'TITRE' => mods_groupe_no_groupe ) );
		$template->assign_block_vars ( 'text' , array (
		'TXT' => mods_groupe_no_groupe_create,
		'URL' => 'index.php',
		'BACK' => back ) );
	}
	else{
		//Sinon on affiche la liste des groupes
		$template->assign_block_vars ( 'mod_titre' , array (
		'TITRE' => mods_groupe_list_groupe ) );
		while($rep_groupe = $Bdd->get_object($req_groupe)){
			$template->assign_block_vars ( 'list' , array (
			'ID' => intval ( $rep_groupe->id ),
			'NOM' => htmlspecialchars ( $rep_groupe->nom ),
			'NB_USER' => $rep_groupe->nb_users,
			'MEMBERS' => members,
			'DESCRIPTION' => to_html ( $rep_groupe->description ) ) );
		}
	}
}
else{

	$idg = intval($_GET['id']);
	$verif = $Bdd->sql('SELECT '.PT.'_groupe.id,'.PT.'_groupe.nom,'.PT.'_groupe.public FROM '.PT.'_groupe WHERE id="'.$idg.'" && afficher="1"' );
	if(!isset($_GET['join'])){
		if($Bdd->get_num_rows($verif)==1){
			$gr = $Bdd->get_object($verif);
			$pub = $gr->public;
			$template->assign_block_vars ( 'mod_titre' , array (
			'TITRE' => liste_pseudo_of.' '.$gr->nom ) );
			
			$template->assign_block_vars ( 'see' , array () );

			$req = $Bdd->get_cached_data('SELECT gmr.id_membre,
													gmr.groupe,
													gmr.niveau,
													u.pseudo 
										FROM '.PT.'_mbr_groupe AS gmr
										LEFT JOIN '.PT.'_users AS u
										ON gmr.groupe="'.$idg.'" && u.id = gmr.id_membre 
										WHERE u.pseudo  != ""
										ORDER BY gmr.niveau DESC',3600,'groupe' );
			foreach ($req as $id=>$row) {
				$template->assign_block_vars ( 'see.mb' , array (
				'PSEUDO' => colorNiveau ( $row['niveau'] , htmlspecialchars ( $row['pseudo'] ) ) ) );
			}
			if($pub==1){
				$template->assign_block_vars ( 'see.join' , array (
				'ID' => $idg,
				'JOIN' => to_join_this_group ) );
			}
		}
		else{
			$template->assign_block_vars ( 'mod_titre' , array (
			'TITRE' => erreur ) );
		}
	}
	else{
		if($Bdd->get_num_rows($verif)!=1 || $pseudo == ''){
			$template->assign_block_vars ( 'mod_titre' , array (
			'TITRE' => erreur ) );
		}
		else{
			$gr = $Bdd->get_object($verif);
			if(verifGroupe($idg)){
				$template->assign_block_vars ( 'mod_titre' , array (
				'TITRE' => erreur ) );
				$template->assign_block_vars ( 'text' , array (
				'TXT' => u_belonf_alread_at_this_groupe,
				'URL' => 'index.php',
				'BACK' => back ) );
			}
			else{
				$pub = $gr->public;
				if($pub!=1){
					$template->assign_block_vars ( 'mod_titre' , array (
					'TITRE' => group_not_public ) );
				}
				else{
					$template->assign_block_vars ( 'mod_titre' , array (
					'TITRE' => to_join_group.' '.$gr->nom ) );
					$new_groupe_user = $groupe.$idg.';';
					$Bdd->sql('UPDATE '.PT.'_users SET groupe="'.$new_groupe_user.'" WHERE id="'.$uid.'"' );
					$Bdd->sql('UPDATE '.PT.'_groupe SET nb_users=nb_users+1 WHERE id="'.$idg.'"' );
					$Bdd->sql('INSERT INTO '.PT.'_mbr_groupe VALUES("","'.$uid.'","'.$idg.'","0")' );
					$Bdd->delete_cached_data('groupe' );
					
					$template->assign_block_vars ( 'text' , array (
					'TXT' => u_have_joined_this_group,
					'URL' => 'index.php?mods=groupes&id='.$idg,
					'BACK' => back ) );
				}
			}
		}
	}
}

$template->set_filename ( 'bas_mods.tpl' );
?>