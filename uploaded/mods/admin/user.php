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

if ( !defined ( 'CCMS' ) ) die ('');
// On vérifie que l'utilisateur est bien un administrateur
if($grade == 4){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/admin/user.tpl' );

	// Si l'administrateur demande a voir la liste des membres, on lui affiche
	if(isset($_REQUEST['list'])){

		$template->assign_block_vars ( 'list' , array (
		'MEMBERLIST' => MEMBERLIST,
		'ALL' => ALL,
		'BACK' => back ) );

	}
	//Affichage des membres dont le nom commence par la lettre defini
	elseif(isset($_GET['order'])){
	
		if ( $_GET['order'] == 'all' ){
		
			$sql = $Bdd->sql('SELECT SQL_CACHE id,pseudo,email,grades FROM '.PT.'_users WHERE grades != "-2" AND id!=1 ORDER BY PSEUDO ASC' );
		
		}
		else{

			$sql = $Bdd->sql('SELECT SQL_CACHE id,pseudo,email,grades FROM '.PT.'_users WHERE pseudo REGEXP "^'.htmlspecialchars($_GET['order'],ENT_QUOTES).'" AND grades != "-2" AND id!=1 ORDER BY PSEUDO ASC' );
			if($_GET['order']=="[0-9]"){
				$template->assign_block_vars ( 'mod_titre' , array (
				'TITRE' => PSEUDO_WHO_BEGIN_BY_LETTER ) );
			}
			else{
				$template->assign_block_vars ( 'mod_titre' , array (
				'TITRE' => PSEUDO_WHO_BEGIN_NBR.' '.htmlspecialchars ( $_GET['order'] , ENT_QUOTES ) ) );
			}
			
		}
		
		$template->assign_block_vars ( 'print_list' , array (
		'PSEUDO' => PSEUDO,
		'GRADE' => GRADE,
		'ACTION' => ACTION,
		'BACK' => back ) );

		if($Bdd->get_num_rows($sql)==0)
			$template->assign_block_vars ( 'print_list.none' , array (
			'NOMANY_MBR_TT' => NOMANY_MBR_TT ) );
	
		while ( $reponse = $Bdd->get_array ( $sql ) ){
			$template->assign_block_vars ( 'print_list.user' , array (
			'PSEUDO' => $reponse['pseudo'],
			'GRADE' => ${'grade_'.$reponse['grades']}['name'],
			'ID' => $reponse['id'] ) );
		}
	}
	elseif(isset($_REQUEST['del'])){
		
		$template->assign_block_vars ( 'mod_titre' , array (
		'TITRE' => DELETING_AN_USER ) );
		
		$arr = explode(',',$god_user);
		if ( !in_array ( intval ( $_GET [ 'del' ] ) , $arr ) ){
			// On applique a lutilisateur le grade -2 indiquant qu'il est supprimé ;)
			
			$logs->add_event ( HAS_DELETED_USER , USERS );
			
			$Bdd->sql('UPDATE '.PT.'_users SET grades="-2" WHERE id="'.intval($_REQUEST['del']).'"' );
			$template->assign_block_vars ( 'text' , array (
			'TXT' => MEMBER_DELETED,
			'URL' => 'index.php?mods=admin&amp;page=user',
			'BACK' => back ) );
		}
		else{
			$template->assign_block_vars ( 'god_user' , array (
			'TITLE' => CANT_BE_DELETED_OR_EDITED,
			'HOWTO' => HOWTO_DEGODEISE,
			'TXT' => HOWTO_DEGODEISE_TXT,
			'BACK' => back ) );
		}
			
	}
	elseif(isset($_REQUEST['user'])){
		$arr = explode(',',$god_user);
		
		if ( in_array ( intval ( $_GET [ 'user' ] ) , $arr ) ){
			$template->assign_block_vars ( 'god_user' , array (
			'TITLE' => CANT_BE_DELETED_OR_EDITED,
			'HOWTO' => HOWTO_DEGODEISE,
			'TXT' => HOWTO_DEGODEISE_TXT,
			'BACK' => back ) );
		}
		else{

			// Mise a jour des données
			if(isset($_POST['valider1'])){

				$logs->add_event ( HAS_UPDATED_USER , USERS );
				
				$new_pseudo = $Bdd->secure($_POST['ispseudo']);
				$new_ranks = $Bdd->secure($_POST['rank']);
				$new_email = $Bdd->secure($_POST['isemail']);
				$new_name = $Bdd->secure($_POST['isname']);
				$new_icq = $Bdd->secure($_POST['isicq']);
				$new_msn = $Bdd->secure($_POST['ismsn']);
				$new_yahoom = $Bdd->secure($_POST['isyahoom']);
				$new_aim = $Bdd->secure($_POST['isaim']);
				$new_site = $Bdd->secure($_POST['issite']);
				$new_theme = $Bdd->secure($_POST['istheme']);
				$new_signature = $Bdd->secure($_POST['contenu']);
				$new_grade = intval($_POST['isgrade']);

				$Bdd->sql('UPDATE '.PT.'_users SET pseudo="'.$new_pseudo.'",email="'.$new_email.'",nom="'.$new_name.'",icq="'.$new_icq.'",msn="'.$new_msn.'",yahoom="'.$new_yahoom.'",aim="'.$new_aim.'",site="'.$new_site.'",theme="'.$new_theme.'", user_title= "'.$new_ranks.'", signature="'.$new_signature.'" '.( ($_POST['isgrade']!='not') ? (',grades="'.$new_grade .'" ') : ('') ).' WHERE id="'.intval($_GET['user']).'"' );
			}

			//Mise a jour des permissions
			if(isset($_POST['permission'])){
				$new_permission = "";
				// On recupere toutes les permissions
				$queryz = $Bdd->sql('SELECT name FROM '.PT.'_permissions' );

				// On fait une boucle pour lire toutes les permissions existantes
				while($sqlz = $Bdd->get_array($queryz)){
					if(isset($_POST[$sqlz['name']]) && $_POST[$sqlz['name']]==1){
						// On ajoute aux permissions les permissions choisies
						$new_permission .= $sqlz['name'].';';
					}
				}
				// On met a jour l'utilisateur avec les nouvelles permissions
				$Bdd->sql('UPDATE '.PT.'_users SET permission="'.$new_permission.'" WHERE id="'.intval($_REQUEST['user']).'" ' );
			}

			// Si l'administrateur cherche a regarder le profil d'une personne en particulier, on affiche le profil de la personne choisie
			$sql = $Bdd->sql('SELECT user_title,pseudo,email,permission,nom,signature,theme,icq,msn,yahoom,aim,site,grades FROM '.PT.'_users WHERE id="'.$_REQUEST['user'].'"' );
			$sql = $Bdd->get_array($sql);
			
			$grades = ${'grade_'.$sql['grades']}['name'] ;

			$template->assign_block_vars ( 'mod_titre' , array (
			'TITRE' => USERS_PROFIL.' '.$sql['pseudo'] ) );
			
			$template->assign_block_vars ( 'user_fiche' , array (
			'JS' =>
			'<script type="text/javascript">
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
						   if(xhr_object.readyState == 4) 
							{
							var retour =  xhr_object.responseText.split("|**|-|**|");
							document.getElementById(\'email_div\').innerHTML = retour[0];
							}
						}
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
						xhr_object.send(data); 
					}
				-->
			</script>',
			'PSEUDO' => PSEUDO,
			'PSEUDO_VALUE' => htmlspecialchars($sql['pseudo']),
			'REGISTER_MAIL' => REGISTER_MAIL,
			'MAIL_VALUE' => htmlspecialchars($sql['email']),
			'NAME' => name,
			'NAME_VALUE' => htmlspecialchars($sql['nom']),
			'ICQ' => ICQ,
			'MSN' => MSN,
			'AIM' => AIM,
			'YAHOOM' => yahoom,
			'ICQ_VALUE' => htmlspecialchars($sql['icq']),
			'MSN_VALUE' => htmlspecialchars($sql['msn']),
			'AIM_VALUE' => htmlspecialchars($sql['aim']),
			'YAHOOM_VALUE' => htmlspecialchars($sql['yahoom']),
			'SITE' => WEBSITE,
			'SITE_VALUE' => htmlspecialchars($sql['site']),
			'SIGN' => SIGN,
			'SIGN_VALUE' => default_form ( FALSE , NULL ,  to_html ( $sql['signature'] ) ),
			'PERSO_TITLE' => PERSONALIZED_TITLE,
			'PERSO_TITLE_VALUE' => htmlspecialchars($sql['user_title']),
			'GRADE' => GRADE,
			'UPDATE_GRADE' => UPDATE_GRADE,
			'BAN' => BAN,
			'HERITED_PERMISSION' => HERITED_PERMISSION,
			'TO_SEE_GO_TO' => TO_SEE_GO_TO,
			'GRADES_ADMINIS' => GRADES_ADMINIS,
			'THEME' => theme,
			'VALID' => valid,
			'THE_PERMISSIONS' => THE_PERMISSIONS,
			'BACK' => back,
			
			) );
					
			for ( $i = 0 ; $i < $nb_total_grades ; $i++ ){
				$template->assign_block_vars ( 'user_fiche.grade' , array (
				'ID' => $i,
				'SELECTED' => ( ( $sql['grades'] == $i ) ? ('selected="selected"') : ('') ),
				'NAME' => ${'grade_'.$i}['name'] ) );
			}

			$a = 0;
			$handle = opendir("./themes/"); 
			while (($file = readdir())!=false) { 
				if($file!=".." && $file!="." && file_exists("./themes/$file/header.tpl")){
					$template->assign_block_vars ( 'user_fiche.theme' , array (
					'SELECTED' => ( ( $sql['theme'] == $file ) ? ('selected="selected"') : ('') ),
					'NAME' => $file ) );
					$a++;
				}
			}
			closedir($handle); 

			// On recupere les DESCription de toutes les permissions
			$queryz = $Bdd->sql('SELECT name,description, element FROM '.PT.'_permissions ORDER BY element' );

			// On fait une boucle pour lire toutes les permissions existantes
			while($sqlz = $Bdd->get_array($queryz)){

				if ( !isset ( $element ) ){
					$element = $sqlz [ 'element' ];
				}
				else if ( $element != $sqlz [ 'element' ] ){
					$template->assign_block_vars ( 'user_fiche.perm.element' , array () );
					$element = $sqlz [ 'element' ];
				}
				//On regarde les permissions que l'utilisateur possede afin de montrer qu'il les possede deja
				$array = explode(';',$sql['permission']); 
				$used = false ;
				foreach($array as $value)
				{ 
					if($value == $sqlz['name']){
						$used = true;
					}
				} 
				
				$template->assign_block_vars ( 'user_fiche.perm' , array (
				'DESC' => $sqlz['description'],
				'CHECKED' => ( ( $used === TRUE ) ? ('checked="checked"') : ('') ),
				'NAME' => $sqlz['name'] ) );
			}
		}
	}
	elseif(isset($_GET['activ'])){
		if($users_valid==1){
			if(isset($_GET['activi'])){
				$logs->add_event ( HAS_ACTIVATED_USER , USERS );
			
				$query = $Bdd->sql('SELECT grades FROM '.PT.'_users WHERE id="'.intval($_GET['id']).'"' );
				$sql = $Bdd->get_array($query);
				if($sql['grades']=='-5'){
					$Bdd->sql('UPDATE '.PT.'_users SET grades="1" WHERE id="'.intval($_GET['id']).'"' );
				}
			}
			else{
				$template->assign_block_vars ( 'ban' , array (
				'PSEUDO' => PSEUDO,
				'ACTIV' => ACTIV,
				'BACK' => back ) );
				$query = $Bdd->sql('SELECT id,pseudo FROM '.PT.'_users WHERE grades="-5"' );
				while($sql = $Bdd->get_array($query)){
					$template->assign_block_vars ( 'ban.user' , array (
					'PSEUDO' => htmlspecialchars ( $sql['pseudo'] ),
					'BAN_URL' => 'index.php?mods=admin&amp;page=user&amp;list&amp;activ&amp;activi=',
					'ID' => $sql['id'],
					'ACTIV' => ACTIV ) );
				}
			}
		}
	}
	elseif(isset($_GET['ban'])){

		$template->assign_block_vars ( 'mod_titre' , array (
		'TITRE' => BAN_MANAGE ) );
		if(isset($_GET['ban_user'])){
			$logs->add_event ( HAS_BANNED_USER , USERS );
			if(isset($_GET['id'])){
				$arr = explode(',',$god_user);
				if ( !in_array ( intval ( $_GET['id'] ) , $arr ) ){
					$query = $Bdd->sql('SELECT grades FROM '.PT.'_users WHERE id="'.intval($_GET['id']).'" AND id!=1' );
					$sql = $Bdd->get_object($query);
					if($sql->grades!=-1){
						$Bdd->sql('UPDATE '.PT.'_users SET grades="-1" WHERE id="'.intval($_GET['id']).'" AND id!=1' );
						$template->assign_block_vars ( 'text' , array (
						'TXT' => USERS_BAN_SUCCESSFULLY,
						'URL' => 'index.php?mods=admin&page=user&amp;ban&amp;ban_user',
						'BACK' => back ) );
					}
				}
				else{
					$template->assign_block_vars ( 'god_user' , array (
					'TITLE' => CANT_BE_DELETED_OR_EDITED,
					'HOWTO' => HOWTO_DEGODEISE,
					'TXT' => HOWTO_DEGODEISE_TXT,
					'BACK' => back ) );
				}
				
			}
			else{
				$query = $Bdd->sql('SELECT id, pseudo FROM '.PT.'_users WHERE grades!="-1" AND id!=1' );
				$template->assign_block_vars ( 'ban' , array (
				'PSEUDO' => PSEUDO,
				'ACTIV' => BAN,
				'BACK' => back ) );
				$query = $Bdd->sql('SELECT id,pseudo FROM '.PT.'_users WHERE grades="-5"' );

				while($sql = $Bdd->get_array($query)){
					$template->assign_block_vars ( 'ban.user' , array (
					'PSEUDO' => htmlspecialchars ( $sql['pseudo'] ),
					'BAN_URL' => 'index.php?mods=admin&amp;page=user&amp;ban&amp;ban_user&amp;id=',
					'ID' => $sql['id'],
					'ACTIV' => BAN ) );
				}
			}
		}
		elseif(isset($_GET['unban_user'])){
		
			$logs->add_event ( HAS_UNBANNED_USER , USERS );
			
			if(isset($_GET['id'])){
				$query = $Bdd->sql('SELECT grades FROM '.PT.'_users WHERE id="'.intval($_GET['id']).'" AND id!=1' );
				$sql = $Bdd->get_object($query);
				if($sql->grades==-1){
					$Bdd->sql('UPDATE '.PT.'_users SET grades="1" WHERE id="'.intval($_GET['id']).'" AND id!=1' );
					$template->assign_block_vars ( 'text' , array (
					'TXT' => USERS_UNBAN_SUCCESSFULLY,
					'URL' => 'index.php?mods=admin&page=user&amp;ban&amp;unban_user',
					'BACK' => back ) );

				}
				else{
					$template->assign_block_vars ( 'text' , array (
					'TXT' => NOT_BAN_USER,
					'URL' => 'index.php?mods=admin&page=user&amp;ban&amp;unban_user',
					'BACK' => back ) );
				}
			}
			else{
				$query = $Bdd->sql('SELECT id, pseudo FROM '.PT.'_users WHERE grades="-1"' );
				$template->assign_block_vars ( 'ban' , array (
				'PSEUDO' => PSEUDO,
				'ACTIV' => UNBAN,
				'BACK' => back ) );
				while($sql = $Bdd->get_array($query)){
					$template->assign_block_vars ( 'ban.user' , array (
					'PSEUDO' => htmlspecialchars ( $sql['pseudo'] ),
					'BAN_URL' => 'index.php?mods=admin&amp;page=user&amp;ban&amp;unban_user&amp;id=',
					'ID' => $sql['id'],
					'ACTIV' => UNBAN ) );
				}
			}
		}
		else{
			$template->assign_block_vars ( 'ban_index' , array (
			'BAN_A_USER' => BAN_A_USER,
			'UNBAN_A_USER' => UNBAN_A_USER,
			'BACK' => back ) );
		}
	}
	else{
		// Si l'administrateur ne demande rien, on lui affiche l'accueil de la gestion des utilisateurs

		$template->assign_block_vars ( 'mod_titre' , array (
		'TITRE' => USERS_MANAGEMENT ) );

		$template->assign_block_vars ( 'index' , array (
		'MEMBER_LIST' => MEMBER_LIST,
		'BAN_MANAGE' => BAN_MANAGE,
		'BACK' => back ) );
		
		if($users_valid==1){
			$template->assign_block_vars ( 'index.users_valid' , array (
			'USERS_NOT_VALIDATED' => USERS_NOT_VALIDATED ) );
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