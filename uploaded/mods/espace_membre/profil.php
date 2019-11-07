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

	$id_user = ( ( isset($_GET['id'] ) && $_GET['id']!=1 ) ? intval($_GET['id']) : 2 );

	$req=$Bdd->sql('SELECT * FROM '.PT.'_users WHERE '.PT.'_users.id="'.$id_user.'"' );
	if($Bdd->get_num_rows($req)==1){
	
		$ligne = $Bdd->get_object($req);
		
		$template->set_filename ( 'haut_mods.tpl' );
		$template->set_filename ( './modules/espace_membre/profil.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => profile_of.' '.$ligne->pseudo ) );
		
		//Pour la date d'anniversaire
		$annif = preg_replace('!([0-9]{2})([0-9]{2})([0-9]{4})!' , '$1/$2/$3',$ligne->date_naissance);
		if($ligne->sexe ==1)
			$image = "male.gif";
		else if($ligne->sexe ==2)
			$image = "female.gif";
		else
			$image = "";

		$avatar = htmlspecialchars($ligne->avatar);
		
		if($avatar == '')
			$avatar ='./avatars/default.png';

		// On calcul la taille idela pour l'avatar
		if ( !@getimagesize($ligne->avatar) )
			$imz = array ( '1' , '1' );
		else
			$imz = getimagesize($ligne->avatar);

		if($imz[0]==0 || $imz[1]==0){
			$avatar ='./avatars/default.png';
			$new_width = 125; 
			$new_height = 125; 
		}
		else{
			$size = resize ( 125 , 125 , $imz[0] , $imz[1] );
			$new_width = $size[0];
			$new_height = $size[1];
		}
		
		//Recherche du grade
		switch($ligne->grades){
			case -5 : 
				$color = '#0000ff';
				$grade_name = UNACTIVATED;
			break;
			case -6 : 
				$color = '#0000ff';
				$grade_name = UNACTIVATED;
			break;
			case -1 : 
				$color = '#0000ff';
				$grade_name = BANNED;
			break;
			case 1 : 
				$color = '#0000ff';
				$grade_name = member;
			break;
			case 2 : 
				$color = '#0000ff';
				$grade_name = member_vip;
			break;
			case 3 : 
				$color = '#0000ff';
				$grade_name = modo;
			break;
			case 4 : 
				$color = '#50ff50';
				$grade_name = admin;
			break;
		}
			// On calcule la participation dans le forum
		// On recupere le nombre de sujets et de reponses
		$query = $Bdd->sql ( 'SELECT id, messages FROM '.PT.'_forum_topic' );
		//Total de sujets
		$total = $Bdd->get_num_rows ( $query );
		
		// On ajoute les reponses
		while ( $sql = $Bdd->get_array ( $query ) )
			$total = $total + $sql['messages'];
		
		$Bdd->free_result ( $query );
		
		$participation = ceil ( ( 100 * $ligne->nb_post ) / $total );
		
		$template->assign_block_vars ( 'index' , array (
		'JS' => '
		<script type="text/javascript">
			<!--
				function aff_div(id_div,id_user){

					if ( id_div == "n1" ){
						 document.getElementById(\'top1\').href = "#";
						 document.getElementById(\'topic\').alt = "X";
						 document.getElementById(\'topic\').src = "./themes/'.$u_theme.'/img/espace_membre/x.png";
							
						 document.getElementById(\'reply\').alt = "Reponses";
						 document.getElementById(\'rep\').href = "javascript:aff_div(\'n2\' , '.$id_user.' );";
						 document.getElementById(\'reply\').src = "./themes/'.$u_theme.'/img/espace_membre/replys.png";
						 
						  document.getElementById(\'commentaire\').alt = "Commentaires";
						 document.getElementById(\'com\').href = "javascript:aff_div(\'n3\' , '.$id_user.' );";
						 document.getElementById(\'commentaire\').src = "./themes/'.$u_theme.'/img/espace_membre/coms.png";
					}
					else if( id_div == "n2" ){
						document.getElementById(\'top1\').href = "javascript:aff_div(\'n1\' , '.$id_user.' );";
						document.getElementById(\'topic\').src = "./themes/'.$u_theme.'/img/espace_membre/topic.png";
						document.getElementById(\'topic\').alt = "Sujets";
						
						document.getElementById(\'rep\').href = "#";
						document.getElementById(\'reply\').alt = "X";
						document.getElementById(\'reply\').src = "./themes/'.$u_theme.'/img/espace_membre/x.png";
						
						 document.getElementById(\'commentaire\').alt = "Commentaires";
						 document.getElementById(\'com\').href = "javascript:aff_div(\'n3\' , '.$id_user.' );";
						 document.getElementById(\'commentaire\').src = "./themes/'.$u_theme.'/img/espace_membre/coms.png";
					}
					else{
					document.getElementById(\'top1\').href = "javascript:aff_div(\'n1\' , '.$id_user.' );";
						document.getElementById(\'topic\').src = "./themes/'.$u_theme.'/img/espace_membre/topic.png";
						document.getElementById(\'topic\').alt = "Sujets";
					
					 document.getElementById(\'reply\').alt = "Reponses";
						 document.getElementById(\'rep\').href = "javascript:aff_div(\'n2\' , '.$id_user.' );";
						 document.getElementById(\'reply\').src = "./themes/'.$u_theme.'/img/espace_membre/replys.png";
						 
					  document.getElementById(\'commentaire\').alt = "X";
						 document.getElementById(\'com\').href = "#";
						 document.getElementById(\'commentaire\').src = "./themes/'.$u_theme.'/img/espace_membre/x.png";
					
					}
						
						var xhr_object = null; 
								
						if(window.XMLHttpRequest) // Navigateur Normal :
							xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
							
						var data = "theme='.$u_theme.'&div_aff=" + id_div + "&id_user=" + id_user + "&lang='.$u_lang.'&uid='.$uid.'&pass='.$user_password.'";
						
						// On appelle la page distante
						xhr_object.open("POST", "./mods/espace_membre/trait.php", true); 
				 
						xhr_object.onreadystatechange = function() {
							if(xhr_object.readyState == 4){
								
								document.getElementById(\'result\').innerHTML = xhr_object.responseText;
							}
							else{
								document.getElementById(\'result\').innerHTML = "<center><img src=\"./mods/news/images/loading.gif\" alt=\"Chargement en cours ...\"/></center>";
							}
						}
						
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
				
						xhr_object.send(data);
				}
				aff_div(\'n1\' , '.$id_user.' );
			-->
		</script>',
		'PERSO_INFO' => perso_info,
		'PSEUDO' => pseudo,
		'PSEUDO_VALUE' => htmlspecialchars ( $ligne->pseudo ),
		'TITLE' => PERSONALIZED_TITLE,
		'TITLE_VALUE' => ( ( $ligne->user_title == '' ) ? ( NONE ) : htmlspecialchars($ligne->user_title ) ),
		'AVATAR' => AVATAR,
		'AVATAR_VALUE' => $avatar,
		'NEW_WIDTH' => $new_width,
		'NEW_HEIGHT' => $new_height,
		'GRADE' => GRADE,
		'GRADE_COLOR' => $color,
		'GRADE_NAME' => $grade_name,
		'INSCRIPTION_DATE' => date_of_inscription,
		'DATE_INSCRIPTION' => ccmsdate($fuseaux,$ligne->date_inscription),
		'SIGNATURE' => signature,
		'SIGN_VALUE' => ( ($ligne->signature=='') ? ( NONEE ) : to_html ( $ligne->signature) ),
		'CONTACT' => contact,
		'ACTIVITY' => ACTIVITY,
		'LAST_ACTIVITY' => LAST_ACTIVITY,
		'LAST_ACTIVITY_VALUE' => ( ( $ligne->last_activity_date > 0 ) ? ( ccmsdate($fuseaux,$ligne->last_activity_date ) ) : ( NEVER ) ),
		'LAST_POST' => LAST_POST,
		'LAST_POST_VALUE' => ( ( $ligne->last_mess_date > 0 ) ? ( ccmsdate($fuseaux,$ligne->last_mess_date ) ) : ( NEVER ) ),
		'NB_POSTS' => NB_POSTS,
		'NB_POSTS_VALUE' => $ligne->nb_post,
		'NB_AVERTISSEMENTS' => NB_AVERTISSEMENTS,
		'AVERTISSEMENTS_VALUE' => $ligne->avertissements,
		'PARTICIPATION' => FORUM_PARTICIPATION,
		'PARTICIPATION_VALUE' => $participation,
		'ID' => $id_user ) );

		if ( $u_privacy{12} == 0 ){
			if ( !empty ( $ligne->localisation ) )
				$template->assign_block_vars ( 'index.loca' , array (
				'TXT' => localization,
				'VALUE' => htmlspecialchars ( $ligne->localisation ) ) );
		 	else
				$template->assign_block_vars ( 'index.nloca' , array (
				'TXT' => localization,
				'NI' => not_indicated ) );
		}
		if ( $u_privacy{10} == 0 ){
			if(!empty($ligne->date_naissance))
				$template->assign_block_vars ( 'index.birth' , array (
				'TXT' => date_of_birth,
				'VALUE' => $annif ) );
			else
				$template->assign_block_vars ( 'index.nbirth' , array (
				'TXT' => date_of_birth,
				'NI' => not_indicated ) );
		}
        
		if ( $u_privacy{0} == 0 )
			$template->assign_block_vars ( 'index.email' , array (
			'TXT' => email,
			'EMAIL' => codemail ( htmlspecialchars ( $ligne->email ) ),
			'MAIL' => str_replace ( '@' , '-AT-' , htmlspecialchars ( $ligne->email ) ) ) );

		if ( $u_privacy{4} == 0 ){
			if(!empty($ligne->icq))
				$template->assign_block_vars ( 'index.icq' , array (
				'TXT' => adress_icq,
				'ADRESSE' => htmlspecialchars($ligne->icq) ) );
			else
				$template->assign_block_vars ( 'index.nicq' , array (
				'TXT' => adress_icq,
				'NI' => not_indicated ) );
		}
		if ( $u_privacy{2} == 0 ){
			if(!empty($ligne->msn))
				$template->assign_block_vars ( 'index.msn' , array (
				'TXT' => adress_msn,
				'ADRESSE' => htmlspecialchars ( $ligne->msn ) ) );
			else
				$template->assign_block_vars ( 'index.nmsn' , array (
				'TXT' => adress_msn,
				'NI' => not_indicated ) );
		}
		if ( $u_privacy{8} == 0 ){
			if(!empty($ligne->aim))
				$template->assign_block_vars ( 'index.aim' , array (
				'TXT' => adress_aim,
				'ADRESSE' => htmlspecialchars ( $ligne->aim ) ) );
			else
				$template->assign_block_vars ( 'index.naim' , array (
				'TXT' => adress_aim,
				'NI' => not_indicated ) );
		}
		if ( $u_privacy{6} == 0 ){
			if(!empty($ligne->yahoom))
				$template->assign_block_vars ( 'index.yahoom' , array (
				'TXT' => adress_yahoom,
				'ADRESSE' => htmlspecialchars ( $ligne->yahoom ) ) );
			else
				$template->assign_block_vars ( 'index.nyahoom' , array (
				'TXT' => adress_yahoom,
				'NI' => not_indicated ) );
		}

		if(!empty($ligne->site)){
			if(substr($ligne->site,0,7)!='http://')
				$site_web = 'http://'.htmlspecialchars($ligne->site);
			else
				$site_web = htmlspecialchars($ligne->site);
			
			$template->assign_block_vars ( 'index.site' , array (
			'TXT' => web_site,
			'URL' => $site_web ) );
		}
		else
			$template->assign_block_vars ( 'index.nsite' , array (
			'TXT' => web_site,
			'NI' => not_indicated ) );
		

		if ( $function_reputation == 1 ){
			$reputation = 0;
			$rep = explode(';',htmlspecialchars($ligne->avertissements));
			foreach ( $rep as $value){
				if($value != '' && $value != 0){
					$rept = explode(':',$value);
					$reputation = $reputation + $rept[3];
				}
			}
			$template->assign_block_vars ( 'index.reput' , array (
			'PTS' => REPUTATION_PTS,
			'VALUE' => $reputation ) );
		}
    
		//Fermeture du Bloc       
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{
		// Si l'utilisateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
?>