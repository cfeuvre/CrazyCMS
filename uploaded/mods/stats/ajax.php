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

Fichier servant à la mise a jour en arrière plan des informationsde l'utilisateur
*/
if ( isset ( $_GET['update_stat'] ) ){

	define ( 'CCMS' , TRUE );
	header('Content-type: text/html; charset=iso-8859-15' ); 
	include('../../includes/config.php' );
	
	// On récupère les données envoyées
	$ip = htmlspecialchars ( $_POST['ip'] );
	$os = $navig = htmlspecialchars ( $_POST['navig'] );
	$url_site = htmlspecialchars ( $_POST['url_site'] );
	$uid = intval ( $_POST['uid'] );
	$grade = intval ( $_POST['grade'] );
	
	// Pays
	$domaines = explode( ".", gethostbyaddr($ip));
	$domaine_nbr=count($domaines);
	if ( isset ( $domaines[$domaine_nbr - 2] ) ){
		$domaine = $domaines[$domaine_nbr - 2];
	}
	else{
		$domaine='';
	}
	if ( isset ( $domaines[$domaine_nbr-1] ) ){
		$extension = $domaines[$domaine_nbr-1];
	}
	else{
		$extension ='';
	}
	if($extension == 'net')
		if($fai=='proxad')
			$extension='fr';
			
	// FAI
	if ( isset ( $domaines[$domaine_nbr-2] ) ){
		$fai = $domaines[$domaine_nbr-2];
	}
	else{
		$fai ='';
	}
	
	// Date actuelle
	$date = date('d',time()).','.date('m',time()).','.date('Y',time()).';';
	// Provenance d'un visiteur arrivant d'un autre site
	if( $url_site == '')$url_site = 'ppp';
	if( isset ( $_POST['referer'] ) && !ereg ( $url_site , $_POST['referer'] ) ){
		$provenance = htmlspecialchars( $_POST['referer'] );
	}
	else {
		$provenance = 'none';
	}
	
	// On regarde si cette adresse IP est deja repertorie
	$verif = $Bdd -> sql('SELECT SQL_CACHE id,date FROM '.PT.'_stats WHERE ip="'.$ip.'"');
	$verif_nbr = $Bdd -> get_num_rows($verif);
	// C'est la premiere visite, quelle emotion :')
	if ( $verif_nbr == 0 ){
		$Bdd -> sql('INSERT INTO '.PT.'_stats VALUES ("", "'.$uid.'","'.$ip.'", "'.$extension.'", "'.$navig.'", "'.$os.'", "'.$u_theme.'", "'.$date.'", "'.$emplacement.'", "'.$provenance.'", "'.time().'", "'.$grade.'", "'.$fai.'")');
	}
	else if ( $verif_nbr == 1 ){
		$new_date = $Bdd->get_array($verif);
		$new_date = $new_date['date'];

		$ver = false;
		$dd = explode(';',$new_date);
		foreach($dd as $d){
			if($d!='' && $d==str_replace(';','',$date))$ver = true;
		}
		if($ver===false){
			$new_date .= $date;
		}
		// Si ce n'est pas la premiere visite, on met a jour
		
		$Bdd->sql('UPDATE '.PT.'_stats SET id_user="'.$uid.'",pays="'.$extension.'",navig="'.$navig.'",os="'.$os.'",date="'.$new_date.'", provenance="'.$provenance.'",timestamp="'.time().'", grade="'.$grade.'", bonux="'.$fai.'" WHERE ip="'.$ip.'"');
	}
	$Bdd -> free_result($verif);

}
else if ( isset ( $_GET['load_stat'] ) ){

	define ( 'CCMS' , TRUE );
	header('Content-type: text/html; charset=iso-8859-15' ); 
	include('../../includes/config.php' );
	include('../../includes/fonctions.php' );
	include('./langues/'.htmlspecialchars ( $_POST['langue'] ).'.php' );
	include('../../langues/'.htmlspecialchars ( $_POST['langue'] ).'/lang.php' );
	include('../../includes/class.template.php' );
	$template = new Template( '../../themes/'.htmlspecialchars($_POST['theme'],ENT_QUOTES) , TRUE );
	$template->set_filename ( './modules/stats/bloc_ajax.tpl' );

	// Nombre d'utilisateurs
	$nb = $Bdd->sql('SELECT COUNT(1) AS nb_users FROM '.PT.'_users WHERE id>1 AND grades > 0');
	$nb_u = $Bdd->get_array($nb);
	// Nombre de visiteurs
	$tot = $Bdd->sql('SELECT COUNT(1) AS vis_tot FROM '.PT.'_stats ');
	$vis_total = $Bdd->get_array($tot);
	
	//Nb visiteurs today
		//Timestamp a la 1ére heure de ce jour
		$date_t = mktime(0, 0, 0, date('m')  , date('d'), date('Y'));			
		$vis_today = $Bdd->sql('SELECT COUNT(id) AS vis_t FROM '.PT.'_stats WHERE timestamp >= "'.$date_t.'"');
		$vis_to = $Bdd->get_array($vis_today);
		
	//Différents records:
	$rec = parse_ini_file('./records.ini',TRUE);
	$record_member_o = $rec['mbr']['member_record_o'];
	$date_record_mbr_o = $rec['mbr']['date_record'];
	$record_visiteur_o = $rec['vis_o']['visiteurs_record_o'];
	$date_record_vis_o = $rec['vis_o']['date_record'];
	$record_visites_j = $rec['vis_j']['record_visites_j'];
	$date_record_vis_j = $rec['vis_j']['date_record'];
	
	// Pages vues
	$pg = parse_ini_file ( './pages.ini' , TRUE );
	
	if ( $_POST['reload'] == 'true' ){
		$pg_file = '[total]
		pages = '.($pg['total']['pages']+1).';
		[modules]';
		$mod = htmlspecialchars ( $_POST['mod'] );
		foreach ( $pg['modules'] AS $mods => $value ){
			if ( $mods == $mod ){
				$value = $value + 1;
			}
			$pg_file .= "\n$mods = $value;";
		}
		if ( substr ( $mod , 0 , 4 ) != 'auto' && !isset ( $pg['modules'][$mod] ) && is_dir ( '../../mods/'.$mod.'/' ) )
			$pg_file .= "\n$mod = 1;";

		$file = fopen ( './pages.ini' , 'w+' );
		fputs ( $file , $pg_file );
		fclose ( $file );
	}
	
	$template->assign_block_vars ( 'bloc' , array (
	'VISITES' => $vis_total['vis_tot'],
	'MORE_STATS' => mods_stats_more_stats,
	'VISITES_TXT' => mods_stats_guests,
	'USER' => $nb_u['nb_users'],
	'USER_TXT' => REGISTERED_USERS,
	'VISITES_TODAY' => $vis_to['vis_t'],
	'VISITES_TODAY_TXT' => VISITES_TODAY,
	'SEE_RECORDS' => SEE_RECORDS,
	'CONNECTED_MEMBERS' => CONNECTED_MEMBERS,
	'PAGES_VUES_TXT' => PAGES_VUES,
	'PAGES_VUES' => $pg['total']['pages'],
	'THE' => the,
	'CONNECTED_GUESTS' => CONNECTED_GUESTS,
	'RECORD_MBR' => $record_member_o,
	'RECORD_MBR_DATE' => date('d \/ m \/ Y',$date_record_mbr_o),
	'RECORD_GUEST' => $record_visiteur_o,
	'RECORD_GUEST_DATE' => date('d \/ m \/ Y',$date_record_vis_o),
	'RECORD_VISITES' => $record_visites_j,
	'RECORD_VISITES_DATE' => date('d \/ m \/ Y',$date_record_vis_j) ) );

	// On recup les visiteurs et membres en lignes actuellement ^^
	$inter = time() - 100;
	$online = $Bdd -> sql('SELECT s.id_user,
									s.pays,
									s.timestamp,
									s.grade, 
									s.date,
									u.pseudo,
									u.appear_offline
									FROM '.PT.'_stats AS s
									LEFT JOIN '.PT.'_users AS u
									ON s.id_user = u.id
									WHERE s.timestamp > "'.$inter.'"
									ORDER BY timestamp');

	$mbr_online = 0;
	$vis_online = 0;
	
	$template->assign_block_vars ( 'bloc.users' , array (
	'TXT' => CONNECTED_MEMBERS ) );

	while($rep = $Bdd->get_array($online)){

		if($rep['grade']==0){
			$vis_online++;
		}
		else{
			if($rep['appear_offline']== 1){
				if($grade == 4){
					$pays = $rep['pays'];
					if($pays=='uk')$pays = 'gb';
					if(file_exists('../../mods/stats/images/pays/'.$pays.'.jpg')){
						$pic = './mods/stats/images/pays/'.$pays.'.jpg';
						$alt = $pays;
					}
					else{
						$pic = './mods/stats/images/qs.gif';
						$alt = '?';
					}
					
					$template->assign_block_vars ( 'bloc.users.user' , array (
					'URL' => $pic,
					'ALT' => $alt,
					'ID' => $rep['id_user'],
					'PSEUDO' => getSymbole($rep['grade'],$rep['pseudo']) ) );
					$mbr_online++;
				}
				else{
					$vis_online++;
				}
			}
			else{
				$pays = $rep['pays'];
				if($pays=='uk')$pays = 'gb';
				if(file_exists('../../mods/stats/images/pays/'.$pays.'.jpg')){
					$pic = './mods/stats/images/pays/'.$pays.'.jpg';
					$alt = $pays;
				}
				else{
					$pic = './mods/stats/images/qs.gif';
					$alt = '?';
				}
				
				$template->assign_block_vars ( 'bloc.users.user' , array (
				'URL' => $pic,
				'ALT' => $alt,
				'ID' => $rep['id_user'],
				'PSEUDO' => getSymbole($rep['grade'],$rep['pseudo']) ) );

				$mbr_online++;
			}
		}
	}
	
	$template->assign_block_vars ( 'bloc.visiteurs' , array (
	'VALUE' => $vis_online,
	'TXT' => CONNECTED_GUESTS ) );
	
	$template->assign_block_vars ( 'bloc.users.value' , array (
	'VALUE' => $mbr_online ) );

	// Mise à jour records :
	$ok = false;
	if($mbr_online > $record_member_o ){
		$record_member_o = $mbr_online;
		$date_record_mbr_o = time();
		$ok = true;
	}
	if($vis_online > $record_visiteur_o){
		$record_visiteur_o = $vis_online;
		$date_record_vis_o = time();
		$ok = true;
	}
	if($vis_to['vis_t'] > $record_visites_j){
		$record_visites_j = $vis_to['vis_t'];
		$date_record_vis_j = time();
		$ok = true;
	}
	if($ok){
		$file = fopen('./records.ini','w+');
		fputs($file,'
					[mbr]
					member_record_o = '.$record_member_o.';
					date_record = '.$date_record_mbr_o.';
					[vis_o]
					visiteurs_record_o = '.$record_visiteur_o.';
					date_record = '.$date_record_vis_o.';
					[vis_j]
					record_visites_j = '.$record_visites_j.';
					date_record = '.$date_record_vis_j.';');
		fclose($file);
	}
	
	$Bdd->free_result($online);
	
	$template->gen();
}

?>