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

// On verifie le grade.
$grades = explode ( ',' , $forum_grade_admin );
if($grade==4 OR in_array ( $grade , $grades , TRUE ) )
{

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => FORUM_ADMIN ) );

	$template->set_filename ( './modules/forum/admin.tpl' );

	if ( isset ( $_GET['rules'] ) ){

		if ( isset ( $_POST['contenu'] ) ){
			$Bdd->sql ( 'UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure ( $_POST['contenu'] ).'" WHERE nom="forum_rules"' );
			$Bdd->delete_cached_data ( 'config' );
			$forum_rules = $_POST['contenu'];
		}

		$template->assign_block_vars ( 'admin_param' , array (
		'CONTENU' => default_form ( FALSE ,'' , to_html ( $forum_rules ) ),
		'BACK' => back ) );

	}
	else if ( isset ( $_GET['mails'] ) ){

		if ( isset ( $_GET['reply'] ) ){

			if ( isset ( $_POST['contenu'] ) ){
				$Bdd->sql ( 'UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure ( $_POST['contenu'] ).'" WHERE nom="new_reply_posted_mail"' );
				$Bdd->delete_cached_data ( 'config' );
				$new_reply_posted_mail = str_replace ( '\r\n' , '<br /><br />' , $Bdd->secure ( $_POST['contenu'] ) );
			}

			$template->assign_block_vars ( 'admin_param' , array (
			'CONTENU' => default_form ( FALSE , '' , to_html ( $new_reply_posted_mail ) ),
			'BACK' => back ) );		
		
		}
		else if ( isset ( $_GET['topic'] ) ){

			if ( isset ( $_POST['contenu'] ) ){
				$Bdd->sql ( 'UPDATE '.PT.'_parametres SET valeur="'.$Bdd->secure ( $_POST['contenu'] ).'" WHERE nom="new_topic_posted_mail"' );
				$Bdd->delete_cached_data ( 'config' );
				$new_topic_posted_mail = str_replace ( '\r\n' , '<br /><br />' , $Bdd->secure ( $_POST['contenu'] ) );
			}

			$template->assign_block_vars ( 'admin_param' , array (
			'CONTENU' => default_form ( FALSE , '' , to_html ( $new_topic_posted_mail ) ),
			'BACK' => back ) );
		
		}
		else{
		
			$template->assign_block_vars ( 'admin_mails' , array (
			'EDIT_MAIL_TOPIC' => EDIT_MAIL_TOPIC,
			'EDIT_MAIL_REPLY' => EDIT_MAIL_REPLY,
			'BACK' => back ) );
		
		}
	
	}
	else if(isset($_GET['manage'])){

		$Bdd->delete_cached_data ( 'forum' );

		$template->assign_block_vars ( 'admin_manage' , array (
		'NO_JS' => no_js,
		'JS' => '
		<script type="text/javascript">
			<!--
				// Fonction pour monter ou descendre une categorie
					function mod(idcat, type, position, type2, cat,is_sub){
						var xhr_object = null; 
				 
						if(window.XMLHttpRequest) // Navigateur Normal :
							xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
						var  data = "idcat=" + idcat + "&is_sub=" + is_sub + "&type=" + type + "&position=" + position + "&id='.$uid.'&pass='.htmlspecialchars($_COOKIE['pass'],ENT_QUOTES).'&parent=" + cat; 
				 
						xhr_object.open("POST", "./mods/forum/position.php?" + type2, true); 
				 
						xhr_object.onreadystatechange = function() { 
							if(xhr_object.readyState == 4) {
								window.location.href="";
							}
						}
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
						xhr_object.send(data);
					}

				//Fonction pour rediriger vers la page de configuration en fonction du choix et de l\'id du forum
				function redir_forum(id,id_cat){

					if(document.getElementById("for:"+id).value!=""){

						//On redirige vers la page pour modifier le forum, le supprimer, le verrouiller ou lui ajouter un sous forum ou gerer ses moderateurs
						if(document.getElementById("for:"+id).value == "lock"){
							window.location.href="index.php?mods=forum&page=admin&lock=" + id;
						}
						else if(document.getElementById("for:"+id).value == "add_sub"){
							window.location.href="index.php?mods=forum&page=admin&add&sub=" + id + "&cat_parent=" + id_cat;
						}
						else if(document.getElementById("for:"+id).value == "modos"){
							window.location.href="index.php?mods=forum&page=admin&modos=" + id;
						}
						else if(document.getElementById("for:"+id).value == "mod"){
							window.location.href="index.php?mods=forum&page=admin&mod&modforum=" + id;
						}
						else if(document.getElementById("for:"+id).value == "delete"){
							var req = confirm("'.CONFIRM_DELETING.'");
								if(req==true){
									window.location.href="index.php?mods=forum&page=admin&del&delforum=" + id;
								}
						}

					}

				}

				//Fonction pour rediriger vers la page de configuration en fonction du choix et de l\'id du forum
				function redir_cat(id){

					if(document.getElementById("cat:"+id).value!=""){

						//On redirige vers la page pour modifier le forum, le supprimer, le verrouiller ou lui ajouter un sous forum
						if(document.getElementById("cat:"+id).value == "add_for"){
							window.location.href="index.php?mods=forum&page=admin&add&for=" + id;
						}
						else if(document.getElementById("cat:"+id).value == "mod"){
							window.location.href="index.php?mods=forum&page=admin&mod&modcat=" + id;
						}
						else if(document.getElementById("cat:"+id).value == "delete"){
							var req = confirm("'.CONFIRM_DELETING_CAT.'");
								if(req==true){
									window.location.href="index.php?mods=forum&page=admin&del&delcat=" + id;
								}
						}

					}

				}

				//Fonction pour charger les sous forum du forum choisi
				function load_sub(id, sub, lang, theme){

					if(document.getElementById(\'for\' + id).style.visibility == "visible"){
						document.getElementById(\'for\' + id).style.visibility = "hidden";
						document.getElementById(\'for\' + id).innerHTML = "";
						document.getElementById(\'for\' + id).style.height = "0px";
					}
					else{

						var xhr_object = null; 
						 
						if(window.XMLHttpRequest) // Navigateur Normal :
						   xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
						   xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
						var  data = "grade='.$grade.'&sub=" + sub + "&id=" + id + "&lang=" + lang + "&theme=" + theme + "&iduser='.$uid.'&pass='.htmlspecialchars($_COOKIE['pass'],ENT_QUOTES).'"; 
						 
						xhr_object.open("POST", "./mods/forum/admin2.php", true); 
						 
						xhr_object.onreadystatechange = function() { 

							if(xhr_object.readyState == 4) {
							document.getElementById(\'for\' + id).innerHTML = xhr_object.responseText;
							document.getElementById(\'for\' + id).style.visibility = "visible";
							document.getElementById(\'for\' + id).style.height = "";
							}
						}

						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 

						xhr_object.send(data);

					}

				}

			-->
		</script>',
		'ADD_A_CAT' => ADD_A_CAT,
		'TITLE' => TITLE,
		'ACTION_TO_DO' => ACTION_TO_DO,
		'STATUS_AND_TOPIC' => STATUS_AND_TOPIC,
		'POSITION' => POSITION,
		'BACK' => back ) );

		//On recupere toutes les catégories et leur forum pour pouvoir les gerer
		$query = $Bdd->sql('
		SELECT 
			'.PT.'_forum_cat.id AS id,
			'.PT.'_forum_cat.nom AS nom ,
			'.PT.'_forum_cat.def AS def ,
			'.PT.'_forum_cat.position AS position
		FROM 
			'.PT.'_forum_cat 
		ORDER BY '.PT.'_forum_cat.position ' );

		if( $Bdd->get_num_rows ( $query ) == 0 ){
			$template->assign_block_vars ( 'admin_manage.none' , array ( 'NONE_CATS' => nobody_cats ) );
		}
		else{

			while ( $sql = $Bdd->get_array ( $query ) ){

				$template->assign_block_vars ( 'admin_manage.cats' , array (
				'CATS' => CATS,
				'NAME' => to_html($sql['nom']),
				'ID' => $sql['id'],
				'CHOOSE_ACTION' => CHOOSE_ACTION,
				'ADD_FOR' => ADD_FOR,
				'MODIF' => MODIF,
				'DELETE' => delete,
				'TOPIC' => DEFINITION,
				'DEF' => to_html($sql['def']),
				'POSITION' => $sql['position']) );

				//On recupere tous les forums associes a cette categorie ;)
				$query2 = $Bdd->sql('SELECT id,nom,def,locked,position,is_sub FROM '.PT.'_forum_for WHERE parent="'.$sql['id'].'" AND is_sub="0" ORDER BY position' );
				while($sql2 = mysql_fetch_array($query2)){

					if($sql2['locked']==0)
						$verrou = UNLOCKED;
					else
						$verrou = LOCKED;

					$template->assign_block_vars ( 'admin_manage.cats.for' , array (
					'ID' => $sql2['id'],
					'IDCAT' => $sql['id'],
					'ISSUB' => $sql2['is_sub'],
					'LANGUE' => $u_lang,
					'NAME' => to_html($sql2['nom']),
					'CHOOSE_ACTION' => CHOOSE_ACTION,
					'LOCK' => LOCK,
					'UNLOCK' => UNLOCK,
					'ADD_SUB' => ADD_SUB,
					'MODIF' => MODIF,
					'DELETE' => delete,
					'MANAGE_MODERATORS' => MANAGE_MODERATORS,
					'VERROU' => $verrou,
					'TOPIC' => DEFINITION,
					'DEF' => to_html($sql2['def']),
					'POSITION' => $sql2['position']) );
				}
			}
		}
	}
	elseif(isset($_GET['add'])){

		if(isset($_GET['sub'])){

			if(isset($_POST['def'])){

				$last_pos = $Bdd->sql ( 'SELECT position FROM '.PT.'_forum_for WHERE parent = "'.intval($_GET['sub']).'" ORDER BY position desc LIMIT 0,1' );
				$sq_last = $Bdd->get_array ( $last_pos );
				$position = $sq_last['position'] + 1;

				// On recupere les permissions a appliquer a ce forumù en fonction des permissions du forum parent
				$last_pos = $Bdd->sql ( 'SELECT groupes, ecriture FROM '.PT.'_forum_for WHERE id = "'.intval($_GET['sub']).'" ORDER BY position desc LIMIT 0,1' );
				$sq_last = $Bdd->get_array ( $last_pos );

				if ( $position == '' )$position = 1;

				$Bdd->sql('INSERT INTO '.PT.'_forum_for VALUES ("", "'.intval($_GET['sub']).'", "'.$Bdd->secure($_POST['titre']).'", "'.$Bdd->secure($_POST['def']).'", "0", "0", "1", "'.$position.'", "'.$sq_last['groupes'].'", "'.$sq_last['ecriture'].'", "0","","","'.intval ( $_GET['cat_parent'] ).'")' );
				$new_id = $Bdd->last_insert_id();
				
				// On abonne a ce forum tous les utilisateurs qui sont abonnées au forum parent ;)
				$u = $Bdd->sql( 'SELECT id,abonnements FROM '.PT.'_users WHERE abonnements REGEXP "\['.intval ( $_GET['sub'] ).'\]"' );
				while ( $s = $Bdd->get_array ( $u ) ){
					$abo = $s['abonnements'].'['.$new_id.']';
					$Bdd->sql ( 'UPDATE '.PT.'_users SET abonnements="'.$abo.'" WHERE id="'.$s['id'].'"' );
				}
				$Bdd->free_result ( $u );
				
				$template->assign_block_vars ( 'admin_add_mess' , array (
				'TXT' => CREATED_SUCCESSFULLY,
				'BACK' => back ) );
			}
			else{
				$template->assign_block_vars ( 'admin_add_form' , array (
				'TITLE' => title,
				'DEFINITION' => DEFINITION,
				'VALID' => valid,
				'BACK' => back ) );
			}
		}
		elseif(isset($_GET['for'])){

			if(isset($_POST['def'])){

				$last_pos = $Bdd->sql ( 'SELECT position FROM '.PT.'_forum_for WHERE parent = "'.intval($_GET['for']).'" ORDER BY position desc LIMIT 0,1' );

				$sq_last = $Bdd->get_array ( $last_pos );
				$position = $sq_last['position'] + 1;
				if ( $position == '' )$position = 1;

				$last_pos = $Bdd->sql ( 'SELECT groupes, ecriture FROM '.PT.'_forum_cat WHERE id = "'.intval($_GET['for']).'" ORDER BY position desc LIMIT 0,1' );
				$sq_last = $Bdd->get_array ( $last_pos );

				$Bdd->sql('INSERT INTO '.PT.'_forum_for VALUES ("", "'.intval($_GET['for']).'", "'.$Bdd->secure($_POST['titre']).'", "'.$Bdd->secure($_POST['def']).'", "0", "0", "0", "'.$position.'", "'.$sq_last['groupes'].'", "'.$sq_last['ecriture'].'", "0","","","'.intval ( $_GET['for'] ).'")' );

				$template->assign_block_vars ( 'admin_add_mess' , array (
				'TXT' => CREATED_SUCCESSFULLY,
				'BACK' => back ) );
			}
			else{
				$template->assign_block_vars ( 'admin_add_form' , array (
				'TITLE' => title,
				'DEFINITION' => DEFINITION,
				'VALID' => valid,
				'BACK' => back ) );
			}
		}
		elseif(isset($_GET['cat'])){

			$Bdd->delete_cached_data ( 'forum' );

			if(isset($_POST['def'])){

				$last_pos = $Bdd->sql ( 'SELECT position FROM '.PT.'_forum_cat ORDER BY position desc LIMIT 0,1' );
				$sq_last = $Bdd->get_array ( $last_pos );
				$position = $sq_last['position'] + 1;
				if ( $position == '' )$position = 1;

				$Bdd->sql('INSERT INTO '.PT.'_forum_cat VALUES ("", "'.$Bdd->secure($_POST['titre']).'", "'.$Bdd->secure($_POST['def']).'", "'.$position.'", "0;", "0;")' );

				$template->assign_block_vars ( 'admin_add_mess' , array (
				'TXT' => CREATED_SUCCESSFULLY,
				'BACK' => back ) );
			}
			else{
				$template->assign_block_vars ( 'admin_add_form' , array (
				'TITLE' => title,
				'DEFINITION' => DEFINITION,
				'VALID' => valid,
				'BACK' => back ) );
			}
		}
	}
	elseif(isset($_GET['del'])){

		if(isset($_GET['delforum'])){

			// On supprime le forum
			$Bdd->sql('DELETE FROM '.PT.'_forum_for WHERE id="'.intval($_GET['delforum']).'"' );

			// On recupere toute la liste des sous forum puis on va supprimer tout ceux qui n'ont plus de parent
			$recup_fors = $Bdd->sql('SELECT id, parent FROM '.PT.'_forum_for WHERE is_sub="1" ORDER BY id' );
			while($sql_fors = $Bdd->get_array($recup_fors)){
				$verif_for = $Bdd->sql('SELECT id FROM '.PT.'_forum_for WHERE id="'.$sql_fors['parent'].'"' );
				if($Bdd->get_num_rows($verif_for)==0){
					$Bdd->sql('DELETE FROM '.PT.'_forum_for WHERE id="'.$sql_fors['id'].'"' );
				}
			}
			$template->assign_block_vars ( 'admin_manage_del' , array ( 'TXT' => FOR_SUCCESSFULLY_DELETED, 'BACK' => back ) );
		}
		elseif(isset($_GET['delcat'])){

			$Bdd->delete_cached_data ( 'forum' );
			// On supprime la cat
			$Bdd->sql('DELETE FROM '.PT.'_forum_cat WHERE id="'.intval($_GET['delcat']).'"' );
			$fors = array();

			// On supprime les forums de premiers niveaux
			$Bdd->sql('DELETE FROM '.PT.'_forum_for WHERE parent="'.intval($_GET['delcat']).'" AND is_sub="0"' );

			// On recupere toute la liste des sous forum puis on va supprimer tout ceux qui n'ont plus de parent
			$recup_fors = $Bdd->sql('SELECT id, parent FROM '.PT.'_forum_for WHERE is_sub="1" ORDER BY id' );
			while($sql_fors = $Bdd->get_array($recup_fors)){
				$verif_for = $Bdd->sql('SELECT id FROM '.PT.'_forum_for WHERE id="'.$sql_fors['parent'].'"' );
				if($Bdd->get_num_rows($verif_for)==0){
					$Bdd->sql('DELETE FROM '.PT.'_forum_for WHERE id="'.$sql_fors['id'].'"' );
				}
			}
			$template->assign_block_vars ( 'admin_manage_del' , array ( 'TXT' => CAT_SUCCESSFULLY_DELETED, 'BACK' => back ) );
		}
	}
	elseif(isset($_GET['mod'])){
		if(isset($_GET['modforum'])){

			if(isset($_POST['def'])){

				$lecture = '';
				$ecriture = '';
				// On recupere toutes les permissions
				$queryz = $Bdd->sql('SELECT id FROM '.PT.'_groupe' );

				// On fait une boucle pour lire toutes les permissions existantes
				while($sqlz = mysql_fetch_array($queryz)){

					// On ajoute aux permissions les permissions choisies
					if(isset($_POST['lecture:group:'.$sqlz['id']]) AND $_POST['lecture:group:'.$sqlz['id']]==1)
						$lecture .= $sqlz['id'].';';

					// On ajoute aux permissions les permissions choisies
					if(isset($_POST['ecriture:group:'.$sqlz['id']]) AND $_POST['ecriture:group:'.$sqlz['id']]==1)
						$ecriture .= $sqlz['id'].';';

				}

				// On ajoute aux permissions les permissions choisies
				if(isset($_POST['lecture:group:0']) AND $_POST['lecture:group:0']==1)
					$lecture .= '0;';

				// On ajoute aux permissions les permissions choisies
				if(isset($_POST['ecriture:group:0']) AND $_POST['ecriture:group:0']==1)
					$ecriture .= '0;';

				$query = $Bdd->sql('UPDATE '.PT.'_forum_for SET nom="'.$Bdd->secure($_POST['titre']).'", def="'.$Bdd->secure($_POST['def']).'", ecriture="'.$Bdd->secure($ecriture).'", groupes="'.$Bdd->secure($lecture).'" WHERE id="'.intval($_GET['modforum']).'"' );

				// On va lancer boucle qui va partir du forum que l'on modifie pour appliquer ces permissiosn a tous ses forums enfants
				$child = true ;
				$parent = array ( intval($_GET['modforum']) );
				while ( $child ){

					$qqquery = 'SELECT id FROM '.PT.'_forum_for WHERE is_sub = "1" AND (';
					$a = true;
					foreach ( $parent as $part ) {
						if ( $part != '' ){
							if ( !$a )$qqquery.= ' OR ';
							$qqquery .= 'parent = "'.$part.'"';
							$a = false;
						}
					}
					$qqquery .= ')';

					$qquery = $Bdd->sql ( $qqquery );

						$parent = array ();

					while ( $ssql = $Bdd->get_array ( $qquery ) ){
						// On met a jour ce forum avec nouvelle pemrissions =)
						$Bdd->sql ('UPDATE '.PT.'_forum_for SET ecriture="'.$Bdd->secure($ecriture).'", groupes="'.$Bdd->secure($lecture).'" WHERE id="'.$ssql['id'].'"' );
						$parent[] = $ssql['id'];
					}

					if ( $Bdd->get_num_rows ( $qquery ) == 0 )
						$child = false;

				}
				$template->assign_block_vars ( 'admin_mod_for_mess' , array (
				'TXT' => updated_successfully,
				'URL' => 'index.php?mods=forum&page=admin&amp;mod&amp;modforum='.intval( $_GET['modforum'] ),
				'BACK' => back ) );
			}
			else{

				$query = $Bdd->sql('SELECT id,nom,def, groupes, ecriture FROM '.PT.'_forum_for WHERE id="'.intval($_GET['modforum']).'" ' );
				$sql = mysql_fetch_array($query);

				// On recupere tous les groupes existants
				$queryz = $Bdd->sql('SELECT id,description FROM '.PT.'_groupe' );

				$template->assign_block_vars ( 'admin_mod_for' , array ( 
				'JS' => '
				<script type="text/javascript">
					<!--
						function ver ( id ){

							if ( document.getElementById ( "ecriture:group:" + id ).checked == true ){

								document.getElementById ( "lecture:group:" + id ).checked = false;
								document.getElementById ( "lecture:group:" + id ).disabled = true;

							}
							else{

								document.getElementById ( "lecture:group:" + id ).disabled = false;

							}
						}
					-->
				</script>',
				'TITLE' => title,
				'TITLE_VALUE' => stripslashes ( htmlspecialchars ( $sql['nom'] ) ),
				'DEFINITION' => DEFINITION,
				'DEFINITION_VALUE' => stripslashes ( htmlspecialchars ( $sql['def'] ) ),
				'VALID' => valid,
				'BACK' => back ) );

					if ( $Bdd->get_num_rows ( $queryz ) != 0 ){

						$used = false;
						$used2 = false;

						if ( eregi ( ';0;' , $sql['groupes'] ) )$used = true;
						if ( eregi ( '^0;' , $sql['groupes'] ) )$used = true;

						if ( eregi ( ';0;' , $sql['ecriture'] ) )$used2 = true;
						if ( eregi ( '^0;' , $sql['ecriture'] ) )$used2 = true;

						$template->assign_block_vars ( 'admin_mod_for.groupes' , array (
						'GROUPS_ALLOWED' => GROUPS_ALLOWED,
						'READING' => READING,
						'WRITTING' => WRITTING,
						'EVERYBODY' => EVERYBODY,
						'NM_IN' => 'lecture:group:0',
						'ID_IN' => 'lecture:group:0',
						'CHK_IN' => ( ( $used === TRUE ) ? ('checked="checked"') : ('') ),
						'DSB_IN' => ( ( $used2 === TRUE ) ? ('disabled="true"') : ('') ),
						'CHK_IN2' => ( ( $used2 === TRUE ) ? ('checked="checked"') : ('') ),
						'NM_IN2' => 'ecriture:group:0',
						'ID_IN2' => 'ecriture:group:0',
						'OC_IN2' => 'ver(\'0\' );' ) );

						// On fait une boucle pour lire toutes les permissions existantes
						while($sqlz = mysql_fetch_array($queryz)){

							$used = false ;
							if ( eregi ( ';'.$sqlz['id'].';' , $sql['groupes'] ) )$used = true;
							if ( eregi ( '^'.$sqlz['id'].';' , $sql['groupes'] ) )$used = true;

							$used2 = false ;
							if ( eregi ( ';'.$sqlz['id'].';' , $sql['ecriture'] ) )$used2 = true;
							if ( eregi ( '^'.$sqlz['id'].';' , $sql['ecriture'] ) )$used2 = true;
							$template->assign_block_vars ( 'admin_mod_for.groupes.gr' , array (
							'NAME' => stripslashes ( $sqlz['description'] ),
							'NM_IN' => 'lecture:group:'.$sqlz['id'],
							'ID_IN' => 'lecture:group:'.$sqlz['id'],
							'CHK_IN' => ( ( $used === TRUE ) ? ('checked="checked"') : ('') ),
							'DSB_IN' => ( ( $used2 === TRUE ) ? ('disabled="true"') : ('') ),
							'CHK_IN2' => ( ( $used2 === TRUE ) ? ('checked="checked"') : ('') ),
							'NM_IN2' => 'ecriture:group:'.$sqlz['id'],
							'ID_IN2' => 'ecriture:group:'.$sqlz['id'],
							'OC_IN2' => 'ver(\''.$sqlz['id'].'\' );' ) );
						}

					}
			}
		}
		elseif(isset($_GET['modcat'])){

			$Bdd->delete_cached_data ( 'forum' );

			if(isset($_POST['def'])){


				$lecture = '';
				$ecriture = '';
				// On recupere toutes les permissions
				$queryz = $Bdd->sql('SELECT id FROM '.PT.'_groupe' );

				// On fait une boucle pour lire toutes les permissions existantes
				while($sqlz = mysql_fetch_array($queryz)){

					// On ajoute aux permissions les permissions choisies
					if(isset($_POST['lecture:group:'.$sqlz['id']]) AND $_POST['lecture:group:'.$sqlz['id']]==1)
						$lecture .= $sqlz['id'].';';

					// On ajoute aux permissions les permissions choisies
					if(isset($_POST['ecriture:group:'.$sqlz['id']]) AND $_POST['ecriture:group:'.$sqlz['id']]==1)
						$ecriture .= $sqlz['id'].';';
				}

				// On ajoute aux permissions les permissions choisies
				if(isset($_POST['lecture:group:0']) AND $_POST['lecture:group:0']==1)
					$lecture .= '0;';

				// On ajoute aux permissions les permissions choisies
				if(isset($_POST['ecriture:group:0']) AND $_POST['ecriture:group:0']==1)
					$ecriture .= '0;';

				$query = $Bdd->sql('UPDATE '.PT.'_forum_cat SET nom="'.$Bdd->secure($_POST['titre']).'", def="'.$Bdd->secure($_POST['def']).'", groupes="'.$Bdd->secure($lecture).'", ecriture="'.$Bdd->secure($ecriture).'" WHERE id="'.intval($_GET['modcat']).'"' );

				// On va lancer boucle qui va partir du forum que l'on modifie pour appliquer ces permissiosn a tous ses forums enfants
				$child = true ;
				$parent = array ( intval($_GET['modcat']) );
				$is_sub = 0;
				while ( $child ){

					$qqquery = 'SELECT id FROM '.PT.'_forum_for WHERE is_sub="'.$is_sub.'" AND (';
					$a = true;
					foreach ( $parent as $part ) {
						if ( $part != '' ){
							if ( !$a )$qqquery.= ' OR ';
							$qqquery .= 'parent = "'.$part.'"';
							$a = false;
						}
					}
					$qqquery .= ')';
					$is_sub = 1;

					$qquery = $Bdd->sql ( $qqquery );

					$parent = array ();

					while ( $ssql = $Bdd->get_array ( $qquery ) ){
						// On met a jour ce forum avec nouvelle pemrissions =)
						$Bdd->sql ('UPDATE '.PT.'_forum_for SET ecriture="'.$Bdd->secure($ecriture).'", groupes="'.$Bdd->secure($lecture).'" WHERE id="'.$ssql['id'].'"' );
						$parent[] = $ssql['id'];
					}

					if ( $Bdd->get_num_rows ( $qquery ) == 0 ){
						$child = false;
					}

				}

				$template->assign_block_vars ( 'admin_mod_cat_mess' , array (
				'TXT' => updated_successfully,
				'URL' => 'index.php?mods=forum&page=admin&amp;mod&amp;modcat='.intval( $_GET['modcat'] ),
				'BACK' => back ) );
			}
			else{

				$query = $Bdd->sql('SELECT id,nom,def, groupes, ecriture FROM '.PT.'_forum_cat WHERE id="'.intval($_GET['modcat']).'" ' );
				$sql = mysql_fetch_array($query);
				// On recupere tous les groupes existants
				$queryz = $Bdd->sql('SELECT id,description FROM '.PT.'_groupe' );

				$template->assign_block_vars ( 'admin_mod_cat' , array ( 
				'JS' => '
				<script type="text/javascript">
					<!--
						function ver ( id ){

							if ( document.getElementById ( "ecriture:group:" + id ).checked == true ){

								document.getElementById ( "lecture:group:" + id ).checked = false;
								document.getElementById ( "lecture:group:" + id ).disabled = true;

							}
							else{

								document.getElementById ( "lecture:group:" + id ).disabled = false;

							}
						}
					-->
				</script>',
				'TITLE' => title,
				'TITLE_VALUE' => stripslashes ( htmlspecialchars ( $sql['nom'] ) ),
				'DEFINITION' => DEFINITION,
				'DEFINITION_VALUE' => stripslashes ( htmlspecialchars ( $sql['def'] ) ),
				'VALID' => valid,
				'BACK' => back ) );

				if ( $Bdd->get_num_rows ( $queryz ) != 0 ){

					$used = false;
					$used2 = false;

					if ( eregi ( ';0;' , $sql['groupes'] ) )$used = true;
					if ( eregi ( '^0;' , $sql['groupes'] ) )$used = true;

					if ( eregi ( ';0;' , $sql['ecriture'] ) )$used2 = true;
					if ( eregi ( '^0;' , $sql['ecriture'] ) )$used2 = true;

					$template->assign_block_vars ( 'admin_mod_cat.groupes' , array (
					'GROUPS_ALLOWED' => GROUPS_ALLOWED,
					'READING' => READING,
					'WRITTING' => WRITTING,
					'EVERYBODY' => EVERYBODY,
					'NM_IN' => 'lecture:group:0',
					'ID_IN' => 'lecture:group:0',
					'CHK_IN' => ( ( $used === TRUE ) ? ('checked="checked"') : ('') ),
					'DSB_IN' => ( ( $used2 === TRUE ) ? ('disabled="true"') : ('') ),
					'CHK_IN2' => ( ( $used2 === TRUE ) ? ('checked="checked"') : ('') ),
					'NM_IN2' => 'ecriture:group:0',
					'ID_IN2' => 'ecriture:group:0',
					'OC_IN2' => 'ver(\'0\' );' ) );

					// On fait une boucle pour lire toutes les permissions existantes
					while($sqlz = mysql_fetch_array($queryz)){

						$used = false ;
						if ( eregi ( ';'.$sqlz['id'].';' , $sql['groupes'] ) )$used = true;
						if ( eregi ( '^'.$sqlz['id'].';' , $sql['groupes'] ) )$used = true;

						$used2 = false ;
						if ( eregi ( ';'.$sqlz['id'].';' , $sql['ecriture'] ) )$used2 = true;
						if ( eregi ( '^'.$sqlz['id'].';' , $sql['ecriture'] ) )$used2 = true;

						$template->assign_block_vars ( 'admin_mod_cat.groupes.gr' , array (
						'NAME' => stripslashes ( $sqlz['description'] ),
						'NM_IN' => 'lecture:group:'.$sqlz['id'],
						'ID_IN' => 'lecture:group:'.$sqlz['id'],
						'CHK_IN' => ( ( $used === TRUE ) ? ('checked="checked"') : ('') ),
						'DSB_IN' => ( ( $used2 === TRUE ) ? ('disabled="true"') : ('') ),
						'CHK_IN2' => ( ( $used2 === TRUE ) ? ('checked="checked"') : ('') ),
						'NM_IN2' => 'ecriture:group:'.$sqlz['id'],
						'ID_IN2' => 'ecriture:group:'.$sqlz['id'],
						'OC_IN2' => 'ver(\''.$sqlz['id'].'\' );' ) );
					}
				}
			}
		}
	}
	elseif(isset($_GET['lock'])){
		$query = $Bdd->sql('SELECT locked FROM '.PT.'_forum_for WHERE id="'.intval($_GET['lock']).'"' );
		$sql = mysql_fetch_array($query);

		if($sql['locked']==0){
			$verrou = 1;
			$template->assign_block_vars ( 'admin_lock' , array ( 'TXT' => LOCKED, 'BACK' => back ) );
		}
		else{
			$verrou = 0;
			$template->assign_block_vars ( 'admin_lock' , array ( 'TXT' => UNLOCKED, 'BACK' => back ) );
		}
		$query = $Bdd->sql('UPDATE '.PT.'_forum_for SET locked="'.$verrou.'" WHERE id="'.intval($_GET['lock']).'"' );

	}
	else if ( isset ( $_GET['modos'] ) ){

		$q = $Bdd->sql ( 'SELECT '.PT.'_forum_for.moderators AS modos, '.PT.'_forum_for.is_sub AS is_sub, '.PT.'_forum_for.parent AS parent FROM '.PT.'_forum_for WHERE id="'.intval ( $_GET['modos'] ).'"' );
		$s = $Bdd->get_array ( $q );
		$modos = substr ( $s['modos'] , 0 , strlen ( $s['modos'] ) - 1 );
		$Bdd->free_result ( $q );

		if ( isset ( $_GET['remove'] ) ){

			$new_modos = str_replace ( intval ( $_GET['remove'] ).',' , '' , $s['modos'] );
			$Bdd->sql ( 'UPDATE '.PT.'_forum_for SET moderators="'.$new_modos.'" WHERE id="'.intval ( $_GET['modos'] ).'"' );

			$template->assign_block_vars ( 'admin_modos_mess' , array (
			'TXT' => MODERATOR_SUCCESSFULLY_REMOVED,
			'URL' => 'index.php?mods=forum&amp;page=admin&amp;modos='.intval ( $_GET['modos'] ),
			'BACK' => back ) );
		}
		else if ( isset ( $_GET['add_mod'] ) ){

			if ( isset ( $_POST['user_id'] ) ){

				$new_modos = $s['modos'] . intval ( $_POST['user_id'] ).',';
				$Bdd->sql ( 'UPDATE '.PT.'_forum_for SET moderators="'.$new_modos.'" WHERE id="'.intval ( $_GET['modos'] ).'"' );

				$template->assign_block_vars ( 'admin_modos_mess' , array (
				'TXT' => MODERATOR_SUCCESSFULLY_ADDED,
				'URL' => 'index.php?mods=forum&amp;page=admin&amp;modos='.intval ( $_GET['modos'] ),
				'BACK' => back ) );

			}
			else{
				$template->assign_block_vars ( 'admin_modos_add' , array (
				'MODERATOR_PSEUDO' => MODERATOR_PSEUDO,
				'VALID' => valid,
				'URL' => 'index.php?mods=forum&amp;page=admin&amp;modos='.intval ( $_GET['modos'] ),
				'BACK' => back ) );

				if ( $modos != '' )
					$condition = 'AND id NOT IN ( '.$modos.' )';
				else
					$condition = '';

				$query = $Bdd->sql ( 'SELECT id, pseudo FROM '.PT.'_users WHERE id!=1 '.$condition );
				while ( $sql = $Bdd->get_array ( $query ) ){
					$template->assign_block_vars ( 'admin_modos_add.pseudo' , array (
					'VALUE' => $sql['id'],
					'PSEUDO' => $sql['pseudo'] ) );
				}
				$Bdd->free_result ( $query );
			}
		}
		else{

			$template->assign_block_vars ( 'admin_modos' , array (
			'MODERATOR_NAME' => MODERATOR_NAME,
			'MODERATOR_USAGE' => MODERATOR_USAGE,
			'URL' => './index.php?mods=forum&page=admin&amp;modos='.intval ( $_GET['modos'] ).'&amp;add_mod',
			'ADD_MODERATOR' => ADD_MODERATOR,
			'BACK' => back ) );

			if ( $modos != '' ){
				$uq = $Bdd->sql ( 'SELECT '.PT.'_users.pseudo AS pseudo, '.PT.'_users.id AS id FROM '.PT.'_users WHERE id IN ( '.$modos.' )' );
			}

			if ( $modos == '' || $Bdd->get_num_rows ( $uq ) == 0 ){
				$template->assign_block_vars ( 'admin_modos.none' , array ( 'NONE_MODERATORS' => NONE_MODERATORS ) );
			}
			else{

				while ( $us = $Bdd->get_array ( $uq ) ){
					$template->assign_block_vars ( 'admin_modos.mod' , array ( 
					'PSEUDO' => $us['pseudo'],
					'URL' => 'index.php?mods=forum&page=admin&modos='.intval ( $_GET['modos'] ).'&remove='.$us['id'],
					'REMOVE_MODERATOR' => REMOVE_MODERATOR ) );
				}

				$Bdd->free_result ( $uq );

			}

		}

	}
	else if ( isset ( $_GET['manage_rank'] ) ){

		if ( isset ( $_GET['add_rank'] ) ){

			if ( isset ( $_POST['name' ] ) ){
				$Bdd->sql ( 'INSERT INTO '.PT.'_forum_ranks VALUES ( "" , "'.intval ( $_POST['nb_posts'] ).'" , "'.$Bdd->secure ( $_POST['name'] ).'" )' );
				$Bdd->delete_cached_data('forum' );
				$template->assign_block_vars ( 'admin_ranks_mess' , array (
				'TXT' => RANK_SUCCESSFULLY_ADDED,
				'BACK' => back) );
			}
			else{
				$template->assign_block_vars ( 'admin_ranks_form' , array (
				'RANK_NAME' => RANK_NAME,
				'RANK_NAME_VALUE' => '',
				'POST_NEEDED' => POST_NEEDED,
				'POST_NEEDED_VALUE' => '',
				'VALID' => valid ) );
			}
		}
		else if ( isset ( $_GET['edit'] ) ){

			if ( isset ( $_POST['name' ] ) ){

				$Bdd->sql ( 'UPDATE '.PT.'_forum_ranks SET nb_posts="'.intval ( $_POST['nb_posts'] ).'", name="'.$Bdd->secure ( $_POST['name'] ).'" WHERE id="'.intval ( $_GET['edit'] ).'"' );
				$Bdd->delete_cached_data('forum' );
				$template->assign_block_vars ( 'admin_ranks_mess' , array (
				'TXT' => RANK_SUCCESSFULLY_EDITED,
				'BACK' => back) );

			}
			else{

				$query = $Bdd->sql ( 'SELECT name, nb_posts FROM '.PT.'_forum_ranks WHERE id="'.intval ( $_GET['edit'] ).'"' );
				$sql = $Bdd->get_array ( $query );
				$template->assign_block_vars ( 'admin_ranks_form' , array (
				'RANK_NAME' => RANK_NAME,
				'RANK_NAME_VALUE' => $sql['name'],
				'POST_NEEDED' => POST_NEEDED,
				'POST_NEEDED_VALUE' => $sql['nb_posts'],
				'VALID' => valid ) );

			}

		}
		else if ( isset ( $_GET['delete'] ) ){

				$Bdd->sql ( 'DELETE FROM '.PT.'_forum_ranks WHERE id="'.intval ( $_GET['delete'] ).'"' );
				$Bdd->delete_cached_data('forum' );
				$template->assign_block_vars ( 'admin_ranks_mess' , array (
				'TXT' => RANK_SUCCESSFULLY_DELETED,
				'BACK' => back) );

		}
		else{

			$template->assign_block_vars ( 'admin_ranks_index' , array (
			'AVAILABLE_RANKS' => AVAILABLE_RANKS,
			'POST_NEEDED' => POST_NEEDED,
			'ADD_RANK' => ADD_RANK,
			'BACK' => back ) );

			$query = $Bdd->get_cached_data ( 'SELECT id, name, nb_posts FROM '.PT.'_forum_ranks ORDER BY nb_posts ASC' , 86400 , 'forum' );
			foreach ( $query AS $array ){

				$template->assign_block_vars ( 'admin_ranks_index.rank' , array (
				'NAME' => stripslashes ( $array['name'] ),
				'NB_POSTS' => $array['nb_posts'],
				'EDIT_URL' => './index.php?mods=forum&amp;page=admin&amp;manage_rank&amp;edit='.$array['id'],
				'EDIT' => edit,
				'DELETE_URL' => './index.php?mods=forum&amp;page=admin&amp;manage_rank&amp;delete='.$array['id'],
				'DELETE' => delete ) );

			}
			if ( count ( $query ) == 0 ){
				$template->assign_block_vars ( 'admin_ranks_index.none' , array (
				'TXT' => NONE_RANKS ) );
			}

			$Bdd->delete_cached_data('forum' );

		}

	}
	else{

		if ( isset ( $_POST['reputation'] ) )
			$function_reputation = intval ( $_POST['reputation'] );
		if ( isset ( $_POST['ranks'] ) )
			$forum_use_ranks = intval ( $_POST['ranks'] );

		$template->assign_block_vars ( 'admin_index' , array ( 
		'MANAGE_CATS' => MANAGE_CATS,
		'MANAGE_RANKS' => MANAGE_RANKS,
		'MANAGE_RULES' => MANAGE_RULES,
		'MANAGE_MAILS' => MANAGE_MAILS,
		'FORUM_OPTION' => FORUM_OPTION,
		'MINIMAL_FLOOD_TIME' => MINIMAL_FLOOD_TIME,
		'MINIMAL_FLOOD_TIME_VALUE' => ( (!isset($_POST['flood'])) ? $flood_time : intval($_POST['flood']) ),
		'NB_REP' => NB_REP,
		'NB_REP_VALUE' => ( (!isset($_POST['forum_nb_reponses_page'])) ? $forum_nb_reponses_page : intval($_POST['forum_nb_reponses_page']) ),
		'NB_TOPIC' => NB_TOPIC,
		'NB_TOPIC_VALUE' => ( (!isset($_POST['forum_nb_topic_page'])) ? $forum_nb_topic_page : intval($_POST['forum_nb_topic_page']) ),
		'VALID' => valid,
		'ENABLE_REPUTATION' => ENABLE_REPUTATION,
		'ENABLE_REPUTATION_TRUE' => ( ($function_reputation == 1 ) ? ('checked="true"') : ('')),
		'ENABLE_REPUTATION_FALSE' => ( ($function_reputation == 0 ) ? ('checked="true"') : ('')),
		'ENABLE_RANKS' => ENABLE_RANKS,
		'ENABLE_RANKS_TRUE' => ( ($forum_use_ranks == 1 ) ? ('checked="true"') : ('') ),
		'ENABLE_RANKS_FALSE' => ( ($forum_use_ranks == 0 ) ? ('checked="true"') : ('')),
		'ACTU_POST_LINK_COLOR' => ( (isset($_GET['actu_post'])) ? ( 'green' ) : ( '' ) ),
		'ACTU_POST_LINK' => ( (isset($_GET['actu_post'])) ? ( NB_POST_ACTUALISED ) : ( ACTUALISE_USER_NB_POST ) ),
		'BACK' => back ) );

		// Mise à jour du temps de flood
		if(isset($_POST['flood'])){
			$template->assign_block_vars ( 'admin_index.anti_flood_time' , array ( 'TXT' => ANTI_FLOOD_TIME_UPDATED ) );
			$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['flood']).'" WHERE nom="flood_time"' );
			$Bdd->delete_cached_data('config' );
		}
		// Mise a jour du nombre de messaes a afficher par page
		if(isset($_POST['forum_nb_reponses_page'])){
			$template->assign_block_vars ( 'admin_index.forum_nb_reponses_page' , array ( 'TXT' => FORUM_NB_REPONSES_PAGE_UPDATED ) );
			$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['forum_nb_reponses_page']).'" WHERE nom="forum_nb_reponses_page"' );
			$Bdd->delete_cached_data('config' );
		}
		// Mise a jour du nombre de topic a afficher par page
		if(isset($_POST['forum_nb_topic_page'])){
			$template->assign_block_vars ( 'admin_index.forum_nb_topic_page' , array ( 'TXT' => FORUM_NB_TOPIC_PAGE_UPDATED ) );
			$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['forum_nb_topic_page']).'" WHERE nom="forum_nb_topic_page"' );
			$Bdd->delete_cached_data('config' );
		}

		// On active ou desactive la reputation
		if(isset($_POST['reputation'])){
			$template->assign_block_vars ( 'admin_index.reputation' , array ( 'TXT' => successfully_updated ) );
			$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['reputation']).'" WHERE nom="function_reputation"' );
			$Bdd->delete_cached_data('config' );
		}

		// On active ou desactive les rangs
		if(isset($_POST['ranks'])){
			$template->assign_block_vars ( 'admin_index.ranks' , array ( 'TXT' => successfully_updated ) );
			$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.intval($_POST['ranks']).'" WHERE nom="forum_use_ranks"' );
			$Bdd->delete_cached_data('config' );
		}
		// On met a jour le nombre total de post si c demandé ;)
		if(isset($_GET['actu_post'])){
			$query = $Bdd->sql('SELECT id FROM '.PT.'_users' );
			while($sql = $Bdd->get_array($query)){
				$quer_1 = $Bdd->sql('SELECT id FROM '.PT.'_forum_topic WHERE auteur="'.$sql['id'].'"' );
				$quer_2 = $Bdd->sql('SELECT id FROM '.PT.'_forum_reply WHERE auteur="'.$sql['id'].'"' );
				$cnt = $Bdd->get_num_rows($quer_1) + $Bdd->get_num_rows($quer_2);
				$Bdd->sql('UPDATE '.PT.'_users SET nb_post = "'.$cnt.'" WHERE id="'.$sql['id'].'"' );
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