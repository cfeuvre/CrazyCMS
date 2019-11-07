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

//Sécurité
if(!defined('CCMS'))die('' );

//Sécurité
$grades = explode ( ',' , $groupes_grade_admin );

if (in_array ( $grade , $grades , TRUE ) || $grade ==4){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/groupes/admin.tpl' );
	$template->assign_vars ( array ( 'NO_JS' => no_js ) );
	
	//Test des différents cas possibles d'url afin de savoir ce qu'on veut faire
	if(isset($_GET['add'])){
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => add_member_in_a_group ) );
		$idg = intval($_GET['id']);
		if(!isset($_GET['ajout'])){
			$req = $Bdd->sql('SELECT id,pseudo FROM '.PT.'_users WHERE ( '.PT.'_users.groupe NOT REGEXP ";'.$idg.';" && '.PT.'_users.grades != "-2" && '.PT.'_users.groupe NOT REGEXP "^'.$idg.';" ) AND id!= 1 ORDER BY '.PT.'_users.pseudo ' );
			$template->assign_block_vars ( 'add' , array (
			'ID' => $idg,
			'ADD' => add,
			'BACK' => back,
			) );
			$i=0;
			$letter = 'a';
			while($rep=$Bdd->get_object($req)){
				$fst = substr ( htmlspecialchars($rep->pseudo) , 0 , 1 );
				if ( ucfirst ( $fst ) ===  ucfirst ( $letter ) ){
					if ( $i == 3){
						$i = 0;
						$template->assign_block_vars ( 'add.td1' , array (
						'ID' => intval ( $rep->id ),
						'PSEUDO' => htmlspecialchars ( $rep->pseudo ) ) );
					}
					else{
						$template->assign_block_vars ( 'add.td2' , array (
						'ID' => intval ( $rep->id ),
						'PSEUDO' => htmlspecialchars ( $rep->pseudo ) ) );
					}
				}
				else{
					$letter = $fst ;
					if ( $i == 3){
						$template->assign_block_vars ( 'add.td3' , array () );
					}
					if ( $i == 2 ){
						$template->assign_block_vars ( 'add.td4' , array () );
					}
					$i = 1;
						$template->assign_block_vars ( 'add.td2' , array (
						'LETTER' => ucfirst ( $letter ),
						'ID' => intval ( $rep->id ),
						'PSEUDO' => htmlspecialchars ( $rep->pseudo ) ) );
				}
				$i++;
			}
			
			if ( $Bdd->get_num_rows ( $req ) == 0 ){
				$template->assign_block_vars ( 'add.none' , array (
				'TXT' => NONE_MEMBER ) );
			}
		}
		else{
			//On traite les données du formulaire grace a un foreach
			foreach($_POST AS $nom=>$idmembre){
				$groupe_user = recupGroupe($idmembre);
				if(!comparGroup($idg,$groupe_user)){
					$new_groupe = $groupe_user.$idg.';';
					$Bdd->sql('INSERT INTO '.PT.'_mbr_groupe VALUES ("","'.$idmembre.'","'.$idg.'","0")' );
					$Bdd->sql('UPDATE '.PT.'_groupe SET nb_users = nb_users+1 WHERE id="'.$idg.'"' );
					$Bdd->sql('UPDATE '.PT.'_users SET groupe="'.$new_groupe.'" WHERE id="'.$idmembre.'"' );
					$template->assign_block_vars ( 'text' , array (
					'TXT' => $nom.' '.has_been_added_with_succes_in_groupe,
					'URL' => 'index.php?mods=groupes&page=admin',
					'BACK' => back ) );
				}
				else{
					$template->assign_block_vars ( 'text' , array (
					'TXT' => $nom.' '.has_not_been_added_with_succes_in_groupe,
					'URL' => 'index.php?mods=groupes&page=admin',
					'BACK' => back ) );
				}
			}
			$Bdd->delete_cached_data('groupe' );
		}
	}
	else if(isset($_GET['modif'])){
		if(!isset($_GET['ok'])){
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_modif_group ) );
			$idg = intval($_GET['id']);
			$req = $Bdd->sql('SELECT '.PT.'_groupe.id,'.PT.'_groupe.nom,'.PT.'_groupe.public,'.PT.'_groupe.description,'.PT.'_groupe.afficher FROM '.PT.'_groupe WHERE id="'.$idg.'"' );
			$rep = $Bdd->get_object($req);
			
			$template->assign_block_vars ( 'modif' , array (
			'ID' => $idg,
			'NAME_OF_GROUP' => name_of_group,
			'GROUPNAME' => stripslashes ( htmlspecialchars ( $rep->nom ) ),
			'GROUP_DESC' => group_desc,
			'DESC' => stripslashes ( htmlspecialchars ( $rep->description ) ),
			'UPDATE' => update ) );

			if($rep->afficher == 1){
				$template->assign_block_vars ( 'modif.input' , array (
				'TXT' => group_aff,
				'NAME' => 'aff',
				'VAL1' => 1,
				'CHECKED' => 'checked="checked"',
				'VAL2' => 0,
				'CHECKED2' => '',
				'YES' => YES,
				'NO' => NO ) );
			}
			else{
				$template->assign_block_vars ( 'modif.input' , array (
				'TXT' => group_aff,
				'NAME' => 'aff',
				'VAL1' => 1,
				'CHECKED' => '',
				'VAL2' => 0,
				'CHECKED2' => 'checked="checked"',
				'YES' => YES,
				'NO' => NO ) );
			}
			if($rep->public == 1){
				$template->assign_block_vars ( 'modif.input' , array (
				'TXT' => group_pub,
				'NAME' => 'pub',
				'VAL1' => 1,
				'CHECKED' => 'checked="checked"',
				'VAL2' => 0,
				'CHECKED2' => '',
				'YES' => YES,
				'NO' => NO ) );
			}
			else{
				$template->assign_block_vars ( 'modif.input' , array (
				'TXT' => group_pub,
				'NAME' => 'pub',
				'VAL1' => 1,
				'CHECKED' => '',
				'VAL2' => 0,
				'CHECKED2' => 'checked="checked"',
				'YES' => YES,
				'NO' => NO ) );
			}
		}
		else{
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_modif_group ) );
			$name = $Bdd->secure($_POST['nomdugroup']);
			$description = $Bdd->secure($_POST['desc']);
			$aff = intval($_POST['aff']);
			$pub = intval($_POST['pub']);
			$idg = intval($_POST['idg']);
			$Bdd->sql('UPDATE '.PT.'_groupe SET nom="'.$name.'",description="'.$description.'",afficher="'.$aff.'",public="'.$pub.'" WHERE id="'.$idg.'"' );
			$Bdd->delete_cached_data('groupe' );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => group_update,
			'URL' => './index.php?mods=groupes&amp;page=admin',
			'BACK' => back ) );
		}
	}
	else if(isset($_GET['create'])){
		$name = $Bdd->secure($_POST['nomdugroup']);
		if ( strlen ( $name ) > 2 ){
			$description = $Bdd->secure($_POST['desc']);
			$aff = intval($_POST['aff']);
			$pub = intval($_POST['pub']);
			$Bdd->sql('INSERT INTO '.PT.'_groupe VALUES("","'.$name.'","'.$description.'","'.convertime(time()).'","'.$uid.'","'.$aff.'","'.$pub.'","1")' );
			$groupe_add = $Bdd->last_insert_id();
			$Bdd->sql('INSERT INTO '.PT.'_mbr_groupe VALUES("","'.$uid.'","'.$groupe_add.'","2")' );
			$new_group = $groupe.$groupe_add.';';
			$Bdd->sql('UPDATE '.PT.'_users SET groupe ="'.$new_group.'" WHERE id="'.$uid.'"' );
			$Bdd->delete_cached_data('groupe' );
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => group_create ) );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => the_group.' '.$name.' '.has_been_create,
			'URL' => './index.php?mods=groupes&amp;page=admin',
			'BACK' => back ) );
		}
		else{
			$template->assign_block_vars ( 'text' , array (
			'TXT' => MORE_THAN_2_FOR_GROUPNAME,
			'URL' => './index.php?mods=groupes&amp;page=admin',
			'BACK' => back ) );
		}
	}
	else if(isset($_GET['member'])){
		if(!isset($_GET['ok'])){
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_modif_member_in_a_groupe ) );
			$idg = intval($_GET['id']);
			$req = $Bdd->get_cached_data('SELECT gmb.id_membre,
										gmb.groupe,
										gmb.niveau,
										u.pseudo,
										u.id 
										FROM '.PT.'_mbr_groupe AS gmb
										LEFT JOIN '.PT.'_users AS u
										ON gmb.groupe="'.$idg.'" && u.id = gmb.id_membre WHERE u.pseudo != ""',3600,'groupe' );
			$template->assign_block_vars ( 'member_choose' , array (
			'TXT' => choose_member,
			'ID' => $idg,
			'VALID' => valid ) );
			foreach($req AS $id=>$rep){
						$template->assign_block_vars ( 'member_choose.td' , array (
						'ID' => $rep['id'],
						'PSEUDO' => stripslashes(htmlspecialchars($rep['pseudo'])) ) );
				}
		}
		else{
			if(!isset($_GET['mo'])){
			
				$id_u = intval($_POST['id_u']);
				$idg = intval($_POST['idg']);
				
				$req = $Bdd->sql('SELECT gmr.id_membre,
										gmr.groupe,
										gmr.niveau,
										u.pseudo 
										FROM '.PT.'_mbr_groupe AS gmr
										LEFT JOIN '.PT.'_users AS u
										ON gmr.groupe="'.$idg.'" && u.id = gmr.id_membre && u.id="'.$id_u.'"' );
				$rep = $Bdd->get_object($req);
				
				$template->assign_block_vars ( 'mod_member' , array (
				'JS' => '
				<script type="text/javascript">
					<!--
						function del(idmembre,idgroupe){
							var req = confirm(\''.group_supp_member.'\' );
							if(req == true){
								window.location.href = "index.php?mods=groupes&page=admin&delmember=" + idmembre +"&idgroupe=" +idgroupe ;
							}
						}
					-->
				</script>',
				'PSEUDO' => pseudo,
				'GROUP_LEVEL' => group_level,
				'PSEUDO_VALUE' => stripslashes ( htmlspecialchars ( $rep->pseudo ) ),
				'ID' => $id_u,
				'ID2' => $idg,
				'UPDATE' => update,
				'DEL_MEMBER_GROUP' => del_member_groupe ) );

				$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_modif_member_in_a_groupe ) );
				for($i=0;$i<3;$i++){
					if($i==0) $titre=member;
					if($i==1) $titre=vip;
					if($i==2) $titre=fondateur;
					$template->assign_block_vars ( 'mod_member.titre' , array (
					'VALUE' => $i,
					'SELECTED' => ( ( $i == intval ( $rep->niveau ) ) ? ('selected="selected"') : ('') ),
					'NAME' => $titre ) );
				}
			}
			else{
				$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => to_modif_member_in_a_groupe ) );
				$level = intval($_POST['level']);
				$id_u = intval($_POST['id_u']);
				$idg = intval($_POST['idgrp']);
				$Bdd->sql('UPDATE '.PT.'_mbr_groupe SET niveau="'.$level.'" WHERE id_membre="'.$id_u.'" && groupe="'.$idg.'"' );
				$Bdd->delete_cached_data('groupe' );
				$template->assign_block_vars ( 'text' , array (
				'TXT' => group_member_modify,
				'URL' => './index.php?mods=groupes&amp;page=admin',
				'BACK' => back ) );
			}
		}
	}
	else if(isset($_GET['delmember']) && isset($_GET['idgroupe'])){
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => del_member_group ) );
		$id_u = intval($_GET['delmember']);
		$idg = intval($_GET['idgroupe']);
		$Bdd->sql('DELETE FROM '.PT.'_mbr_groupe WHERE id_membre="'.$id_u.'" && groupe="'.$idg.'"' );
		$Bdd->sql('UPDATE '.PT.'_groupe SET nb_users=nb_users-1 WHERE id="'.$idg.'"' );
		$lastgroupeu = recupGroupe($id_u);
		$newgroupe = str_replace(';'.$idg.';' , ';',$lastgroupeu);
		$newgroupe = preg_replace('!^'.$idg.';:!' , '',$newgroupe);
		$Bdd->sql('UPDATE '.PT.'_users SET groupe="'.$newgroupe.'" WHERE id="'.$id_u.'"' );
		$Bdd->delete_cached_data('groupe' );
				$template->assign_block_vars ( 'text' , array (
				'TXT' => group_member_deleted,
				'URL' => './index.php?mods=groupes&amp;page=admin',
				'BACK' => back ) );
	}
	else if(isset($_GET['delgroupe'])){
		$idg=intval($_GET['delgroupe']);
		if(!isset($_GET['ok'])){
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => group_are_u_sur_to_delet ) );
			$template->assign_block_vars ( 'delgroupe' , array (
			'JS' => '
			<script type="text/javascript">
				<!--
					function del(idgroupe){
						var req = confirm(\''.group_supp_group.'\' );
						if(req == true){
							window.location.href = "index.php?mods=groupes&page=admin&delgroupe=" + idgroupe + "&ok";
						}
					}
				-->
			</script>',
			'SURE' => group_are_u_sur_to_delet,
			'GROUP_TO_DELETE' => group_supp_group,
			'ID' => $idg ) );			
		}
		else{
			$Bdd->sql('DELETE FROM '.PT.'_groupe WHERE id="'.$idg.'"' );
			$Bdd->sql('DELETE FROM '.PT.'_mbr_groupe WHERE groupe="'.$idg.'"' );
			$req = $Bdd->sql('SELECT id,groupe FROM '.PT.'_users' );
			while($rep=$Bdd->get_object($req)){
				$ancien_groupe = $rep->groupe;
				$new_groupe = str_replace(';'.$idg.';' , ';',$ancien_groupe);
				$Bdd->sql('UPDATE '.PT.'_users SET groupe="'.$new_groupe.'" WHERE id="'.$rep->id.'"' );
			}
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => group_deleted ) );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => group_deleted,
			'URL' => './index.php?mods=groupes&amp;page=admin',
			'BACK' => back ) );
		}
	}
	else if(isset($_GET['color'])){
		$level = intval($_POST['level_choose']);
		$color = htmlspecialchars($_POST['color'],ENT_QUOTES);
		$conc = 'color_level_'.$level;
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur = "'.$color.'" WHERE nom="'.$conc.'"' );
		$Bdd->delete_cached_data('config' );
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => color_modified ) );
		$template->assign_block_vars ( 'text' , array (
		'TXT' => level_color_modified,
		'URL' => './index.php?mods=groupes&amp;page=admin',
		'BACK' => back ) );
	}
	else{
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => admin_group ) );
		$template->assign_block_vars ( 'admin' , array (
		'JS' => '
		<script type="text/javascript">
			<!--
				function affiche_div(name){
					if(document.getElementById(name).style.visibility == "hidden"){
						document.getElementById(name).style.visibility = "visible";
						document.getElementById(name).style.height = "";
						if ( document.getElementById( name + "txt") ){
							document.getElementById( name + "txt").style.height = "";
						}
					}
					else{
						document.getElementById(name).style.visibility = "hidden";
						document.getElementById(name).style.height = "0px";
						if ( document.getElementById( name + "txt") ){
							document.getElementById( name + "txt").style.height = "0px";
						}
					}
				}
			-->
		</script>',
		'ADD_MEMBER' => add_member_in_a_group,
		'CHOOSE_GROUP' => choose_group,
		'MODIF' => to_modif_group,
		'CREATE' => to_create_group,
		'MODIF_MBR' => to_modif_member_in_a_groupe,
		'ADD' => add,
		'YES' => YES,
		'NO' => NO,
		'NAME_OF_GROUP' => name_of_group,
		'GROUP_DESC' => group_desc,
		'GROUP_AFF' => group_aff,
		'GROUP_PUB' => group_pub,
		'DEL_GROUP' => del_group,
		'MODIF_COLOR' => group_modif_color_level,
		'CHOOSE_A_LEVEL' => choose_a_level,
		'SEND' => send,
		'BACK' => back,
		'CHOOSE_COLOR' => choose_color,
		'MEMBER' => member,
		'VIP' => vip,
		'FONDATEUR' => fondateur,
		'HTML_OR_NAME' => u_can_enter_html_or_name ) );

		$req = $Bdd->sql('SELECT '.PT.'_groupe.id,'.PT.'_groupe.nom  FROM '.PT.'_groupe' );
		while ($rep = $Bdd->get_object($req)){
			$template->assign_block_vars ( 'admin.list' , array (
			'URL' => 'index.php?mods=groupes&amp;page=admin&amp;id='.intval($rep->id).'&amp;add',
			'NOM' => stripslashes ( htmlspecialchars ( $rep->nom ) ) ) );
			$template->assign_block_vars ( 'admin.list2' , array (
			'URL' => 'index.php?mods=groupes&amp;page=admin&amp;id='.intval($rep->id).'&amp;modif',
			'NOM' => stripslashes ( htmlspecialchars ( $rep->nom ) ) ) );
			$template->assign_block_vars ( 'admin.list3' , array (
			'URL' => 'index.php?mods=groupes&amp;page=admin&amp;id='.intval($rep->id).'&amp;member',
			'NOM' => stripslashes ( htmlspecialchars ( $rep->nom ) ) ) );
			$template->assign_block_vars ( 'admin.list4' , array (
			'URL' => 'index.php?mods=groupes&amp;page=admin&amp;delgroupe='.intval($rep->id),
			'NOM' => stripslashes ( htmlspecialchars ( $rep->nom ) ) ) );
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