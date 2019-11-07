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
if(!defined('CCMS'))die('');

include_once ( './mods/stats/arrs.php' );

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/stats/index.tpl' );
	
// On recupere toute les states dans un tableau pour eviter de futures reques sql
$users = array();
$online = $Bdd->sql('SELECT id, pays, grade,navig,os,theme,date,location,provenance,bonux FROM '.PT.'_stats');
while ( $on = $Bdd->get_array ( $online ) ){	
	$users[$on['id']] = array('pays' => $on['pays'],'grade' => $on['grade'],'navig' => $on['navig'],'os' => $on['os'],'theme' => $on['theme'],'date' => $on['date'],'location' => $on['location'],'provenance' => $on['provenance'],'bonux' => $on['bonux']);
}

function compare($a, $b){
	$a = $a['total'];
	$b = $b['total'];
	if ($a == $b) return 0;
	return ($a > $b) ? -1 : 1;
}

function compare_2($a, $b){
	if ($a == $b) return 0;
	return ($a > $b) ? -1 : 1;
}

function st_navig($users,$tpl_dir = 'navig.liste'){

	global $liste_navigators, $template;

	$vars = '';

	foreach ( $users as $id => $array ){
		if($id != ''){

			$navig_actuel = explode('|*|',$array['navig']);
			if ( isset ( $navig_actuel[0] ) && isset ( $navig_actuel[1] ) ){
				if(isset(${$navig_actuel[0].'-'.$navig_actuel[1]})){
					${$navig_actuel[0].'-'.$navig_actuel[1]} = ${$navig_actuel[0].'-'.$navig_actuel[1]} + 1;
				}
				else{
					${$navig_actuel[0].'-'.$navig_actuel[1]} = 1;
				}

				if(!ereg($navig_actuel[0].'-'.$navig_actuel[1],$vars)){
					$vars .= $navig_actuel[0].'-'.$navig_actuel[1].'|*-*|';
				}
			}
		}
	}
	
	$total = 0;
	$navigs = explode('|*-*|',$vars);
	foreach ( $navigs as $val ){
		if($val != ''){
			$total = $total + ${$val};
		}
	}

	$percent = $total / 100;
	$toto =0;
	$all_stats = array();
	$end_array = array();
	foreach ( $navigs as $val ){
		if($val != ''){
			$navig = explode('-',$val);
			$all_stats[$liste_navigators[$navig[0]].' '.$navig[1]] = ${$val};
		}
	}
	
	foreach ( $all_stats as $nom => $val ){
		$rname = explode ( ' ' , $nom );
		if ( count ( $rname ) == 2 ){
			$nom = $rname[0];
			$version = $rname[1];
		}
		else{
			$totnm = count ( $rname ) - 1;
			$nom = '';
			for ( $i = 0 ; $i < $totnm ; $i++ ){
				$nom .= $rname[$i];
			}
			$version = $rname ( $totnm );
		}
		
		if ( isset ( $end_array[$rname[0]] ) ){
			$end_array[$rname[0]][$rname[1]] = $val;
		}
		else{
			$end_array[$rname[0]] = array();
			$end_array[$rname[0]][$rname[1]] = $val;
		}
		if ( isset ( $end_array[$rname[0]]['total'] ) )
			$end_array[$rname[0]]['total'] = $end_array[$rname[0]]['total'] + $val;
		else
			$end_array[$rname[0]]['total'] = $val;
			
	}
	uasort ($end_array, "compare");
	
	
	
	foreach ( $end_array AS $navig => $array ){
		
		uasort ( $array, "compare_2");
			
		if ( is_file ( './mods/stats/images/navig/'.strtolower($navig).'.png' ) ){
			$pic = './mods/stats/images/navig/'.strtolower($navig).'.png';
		}
		else{
			$pic = './mods/stats/images/qs.gif';
		}
		
		$template->assign_block_vars ( $tpl_dir , array (
		'PIC' => $pic,
		'NAME' => $navig,
		'VALUE' => $array['total'],
		'SIZE' => ( round ( $array['total'] / $percent ) * 3 ),
		'PERCENT' => round( $array['total'] / $percent , 1 ) ) );

		if ( count ( $array ) > 2 ){
		
			$template->assign_block_vars ( $tpl_dir.'.version' , array ( 'NAVIG' => $navig ) );

			foreach ( $array AS $version => $val ){
				if ( $version != 'total' ){
					$template->assign_block_vars ( $tpl_dir.'.version.vers' , array (
					'VERSION' => $version,
					'VALUE' => $val,
					'PERCENT' => round ( $val / $percent , 1 ),
					'SIZE' => ( round ( $val / $percent ) * 3 ) ) );
				}
			}
		}
	}
}

function stats($arg,$users,$d=0,$y='',$tpl_dir='stats.liste'){

	global $template;
	$vars = '';
	// On trie les informations des navigateurs
	foreach ( $users as $id => $array ){
		if($id != ''){
			
			if(!isset(${$array[$arg]})){
				${$array[$arg]} = 1;
				$vars .= $array[$arg].'|*-*|';
			}
			else{
				${$array[$arg]}++ ;
			}
		}
	}

	$total = 0;
	$navigs = explode('|*-*|',$vars);
	foreach ( $navigs as $val ){
		if($val != ''){
			$total = $total + ${$val};
		}
	}
	
	$all_stats = array();
	foreach ( $navigs as $val ){
		if($val != ''){
			if($d==0){
				$all_stats[$val] = ${$val};	
			}
			else{
				if(isset($y[$val])){
				$varz = $y[$val];
				}
				else{
				$varz = mods_stats_unknow;
				}
				$all_stats[$varz] = ${$val};	
			}

		}
	}

	uasort ($all_stats, "compare_2");
	$percent = $total / 100;
	$toto =0;

	foreach ( $all_stats as $nom => $val ){
		$template->assign_block_vars ( $tpl_dir , array (
		'SIZE' => (round($val/$percent) * 3),
		'NAME' => $nom,
		'VALUE' => $val,
		'PERCENT' => round ( $val/$percent , 1 ) ) );
		
		// On affiche image des Os
		if ( $arg == 'os' ){
			if ( strstr ( strtolower ( $nom ) , 'windows' ) ){
				if ( strstr ( strtolower ( $nom ) , 'vista' ) )
					$pic = './mods/stats/images/os/vista.png';
				else
					$pic = './mods/stats/images/os/windows.png';
			}
			else{
				if ( is_file ( './mods/stats/images/os/'.strtolower($nom).'.png' ) ){
					$pic = './mods/stats/images/os/'.strtolower($nom).'.png';
				}
				else{
					$pic = './mods/stats/images/qs.gif';
				}
			}
			$template->assign_block_vars ($tpl_dir.'.pic' , array ( 'PIC' => $pic ) );
		}
	}
}

if(isset($_GET['navig'])){
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => mods_stats_navigators_stats ) );
	$template->assign_block_vars ( 'navig' , array ( 
	'BACK' => back,
	'JS' => '
	<script type="text/javascript">
			<!--
				function show_navig(id){
					if ( document.getElementById ( id ) ){
						if ( document.getElementById ( id ).style.visibility == "hidden" ){
							document.getElementById ( id ).style.visibility = "visible";
							document.getElementById ( id ).style.height = "";
						}
						else{
							document.getElementById ( id ).style.visibility = "hidden";
							document.getElementById ( id ).style.height = "0px";
						}
					}
				}
			-->
	</script>' ) );
	st_navig($users);
}
else if(isset($_GET['os'])){
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => mods_stats_os_stats ) );
	$template->assign_block_vars ( 'stats' , array ( 'BACK' => back ) );
	stats('os',$users,1,$liste_os);
}
else if(isset($_GET['pays'])){
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => mods_stats_pays_stat ) );
	$template->assign_block_vars ( 'stats' , array ( 'BACK' => back ) );
	stats('pays',$users,'1',$liste_pays);
}
else if(isset($_GET['theme'])){
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => mods_stats_theme_stat ) );
	$template->assign_block_vars ( 'stats' , array ( 'BACK' => back ) );
	stats('theme',$users,'0');
}
else if(isset($_GET['date'])){

	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => mods_stats_period_stat ) );

	$mois = array (january,february,march,april,may,june,july,august,september,october,november,december);
	
	$years = array();
	foreach($users as $id => $array){
			
		if($id!=''){
			$date = explode(';',$array['date']);
		
			foreach($date as $var){
				if($var != ''){
				
					$dates = explode(',',$var);
					
					if(!in_array($dates[2],$years)){
						$years[] = $dates[2];
					}
				}				
			}
		}
	}
	
	function rec_month($year){
	$month = array();
	global $users;
		foreach($users as $id => $array){
			
			if($id!=''){
				$date = explode(';',$array['date']);
				foreach($date as $var){
					if($var != ''){
						$dates = explode(',',$var);
						if(!in_array($dates[1],$month) && $dates[2] == $year){
							$month[] = $dates[1];
						}
					}				
				}
			}
		}
		return $month;
	}
	
	function rec_day($year,$month){
	$day = array();
	global $users;
		foreach($users as $id => $array){
			
			if($id!=''){
				$date = explode(';',$array['date']);
				foreach($date as $var){
					if($var != ''){
						$dates = explode(',',$var);
						if(!in_array($dates[0],$day) && $dates[2] == $year && $dates[1] == $month){
							$day[] = $dates[0];
						}
					}				
				}
			}
		}
		return $day;
	}
	
	if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])){
	
		$template->assign_block_vars ( 'date' , array (
		'SEE_IN' =>  SEE_STATS_IN,
		'ALL_PERIOD' => STATS_DURING_LAST_SEVEN,
		'URL' => './index.php?mods=stats&date',
		'LAST_SEVEN_DAYS' => intval ( $_GET['day'] ).' / '.$mois[(intval($_GET['month'])-1)].' / '.intval($_GET['year']),
		'OS_STATS' => mods_stats_os_stats,
		'PAYS' => mods_stats_pays_stat,
		'BACK' => back,
		'JS' => '
		<script type="text/javascript">
				<!--
					function show_navig(id){
						if ( document.getElementById ( id ) ){
							if ( document.getElementById ( id ).style.visibility == "hidden" ){
								document.getElementById ( id ).style.visibility = "visible";
								document.getElementById ( id ).style.height = "";
							}
							else{
								document.getElementById ( id ).style.visibility = "hidden";
								document.getElementById ( id ).style.height = "0px";
							}
						}
					}
				-->
		</script>',
		'NAVIGS' => mods_stats_navigators_stats,
		'THEME' => mods_stats_theme_stat ) );
		
		sort($years,SORT_NUMERIC);
		foreach($years as $year){
			if($year!=''){
				$template->assign_block_vars ( 'date.years' , array ( 'YEAR' => $year ) );
			}
		}
		
		$template->assign_block_vars ( 'date.month' , array (
		'SEE_IN' => SEE_DURING_MONTH ) );
		
		$months = rec_month(htmlspecialchars($_GET['year'],ENT_QUOTES));
		sort($months,SORT_NUMERIC);
		foreach($months as $month){
			if($month!=''){
				$template->assign_block_vars ( 'date.month.m' , array (
				'YEAR' => intval ( $_GET['year'] ),
				'MONTH' => $month,
				'NAME' => $mois[$month-1] ) );
			}
		}
		
		$template->assign_block_vars ( 'date.day' , array (
		'SEE_IN' => DAY ) );
		
		$days = rec_day(htmlspecialchars($_GET['year'],ENT_QUOTES),htmlspecialchars($_GET['month'],ENT_QUOTES));
		sort($days,SORT_NUMERIC);
		foreach($days as $day){
			if($day!=''){
				$template->assign_block_vars ( 'date.day.d' , array (
				'YEAR' => intval ( $_GET['year'] ),
				'MONTH' => htmlspecialchars ( $_GET['month'] ),
				'DAY' => $day ) );
			}
		}
		
		$actu = array();
		foreach($users as $id => $array){
			if($id!='' && strstr($array['date'],htmlspecialchars($_GET['day'],ENT_QUOTES).','.htmlspecialchars($_GET['month'],ENT_QUOTES).','.htmlspecialchars($_GET['year'],ENT_QUOTES).';')!= ''){
				$actu[$id] = $array;
			}
		}
		stats('os',$actu,1,$liste_os, 'date.os' );
		stats('pays',$actu,1,$liste_pays , 'date.pays' );
		stats('theme',$actu,0,NULL,'date.theme');
		st_navig($actu,'date.navig');	
	
	}
	else if(isset($_GET['month']) && isset($_GET['year'])){
	
		$template->assign_block_vars ( 'date' , array (
		'SEE_IN' =>  SEE_STATS_IN,
		'ALL_PERIOD' => STATS_DURING_LAST_SEVEN,
		'URL' => './index.php?mods=stats&date',
		'LAST_SEVEN_DAYS' => $mois[(intval($_GET['month'])-1)].' / '.intval($_GET['year']),
		'OS_STATS' => mods_stats_os_stats,
		'PAYS' => mods_stats_pays_stat,
		'BACK' => back,
		'JS' => '
		<script type="text/javascript">
				<!--
					function show_navig(id){
						if ( document.getElementById ( id ) ){
							if ( document.getElementById ( id ).style.visibility == "hidden" ){
								document.getElementById ( id ).style.visibility = "visible";
								document.getElementById ( id ).style.height = "";
							}
							else{
								document.getElementById ( id ).style.visibility = "hidden";
								document.getElementById ( id ).style.height = "0px";
							}
						}
					}
				-->
		</script>',
		'NAVIGS' => mods_stats_navigators_stats,
		'THEME' => mods_stats_theme_stat ) );

		sort($years,SORT_NUMERIC);
		foreach($years as $year){
			if($year!=''){
				$template->assign_block_vars ( 'date.years' , array ( 'YEAR' => $year ) );
			}
		}
		
		$template->assign_block_vars ( 'date.month' , array (
		'SEE_IN' => SEE_DURING_MONTH ) );
		
		$months = rec_month(htmlspecialchars($_GET['year'],ENT_QUOTES));
		sort($months,SORT_NUMERIC);
		foreach($months as $month){
			if($month!=''){
				$template->assign_block_vars ( 'date.month.m' , array (
				'YEAR' => intval ( $_GET['year'] ),
				'MONTH' => $month,
				'NAME' => $mois[$month-1] ) );
			}
		}
		
		$template->assign_block_vars ( 'date.day' , array (
		'SEE_IN' => DAY ) );
		
		$days = rec_day(htmlspecialchars($_GET['year'],ENT_QUOTES),htmlspecialchars($_GET['month'],ENT_QUOTES));
		sort($days,SORT_NUMERIC);
		foreach($days as $day){
			if($day!=''){
				$template->assign_block_vars ( 'date.day.d' , array (
				'YEAR' => intval ( $_GET['year'] ),
				'MONTH' => htmlspecialchars ( $_GET['month'] ),
				'DAY' => $day ) );
			}
		}
	
		$actu = array();
		foreach($users as $id => $array){
			if($id!='' && strstr($array['date'],','.htmlspecialchars($_GET['month'],ENT_QUOTES).','.htmlspecialchars($_GET['year'],ENT_QUOTES).';')!= ''){
				$actu[$id] = $array;
			}
		}
		
		stats('os',$actu,1,$liste_os, 'date.os' );
		stats('pays',$actu,1,$liste_pays , 'date.pays' );
		stats('theme',$actu,0,NULL,'date.theme');
		st_navig($actu,'date.navig');	
	
	}
	else if(isset($_GET['year'])){
	
		$template->assign_block_vars ( 'date' , array (
		'SEE_IN' =>  SEE_STATS_IN,
		'ALL_PERIOD' => STATS_DURING_LAST_SEVEN,
		'URL' => './index.php?mods=stats&date',
		'LAST_SEVEN_DAYS' => intval ( $_GET['year'] ),
		'OS_STATS' => mods_stats_os_stats,
		'PAYS' => mods_stats_pays_stat,
		'BACK' => back,
		'JS' => '
		<script type="text/javascript">
				<!--
					function show_navig(id){
						if ( document.getElementById ( id ) ){
							if ( document.getElementById ( id ).style.visibility == "hidden" ){
								document.getElementById ( id ).style.visibility = "visible";
								document.getElementById ( id ).style.height = "";
							}
							else{
								document.getElementById ( id ).style.visibility = "hidden";
								document.getElementById ( id ).style.height = "0px";
							}
						}
					}
				-->
		</script>',
		'NAVIGS' => mods_stats_navigators_stats,
		'THEME' => mods_stats_theme_stat ) );
		
		sort($years,SORT_NUMERIC);
		foreach($years as $year){
			if($year!=''){
				$template->assign_block_vars ( 'date.years' , array ( 'YEAR' => $year ) );
			}
		}
		
		$template->assign_block_vars ( 'date.month' , array (
		'SEE_IN' => SEE_DURING_MONTH ) );
		
		$months = rec_month(htmlspecialchars($_GET['year'],ENT_QUOTES));
		sort($months,SORT_NUMERIC);
		foreach($months as $month){
			if($month!=''){
				$template->assign_block_vars ( 'date.month.m' , array (
				'YEAR' => intval ( $_GET['year'] ),
				'MONTH' => $month,
				'NAME' => $mois[$month-1] ) );
			}
		}
		
		$actu = array();
		foreach($users as $id => $array){
			if($id!='' && strstr($array['date'],','.htmlspecialchars($_GET['year'],ENT_QUOTES).';')!= ''){
				$actu[$id] = $array;
			}
		}
		stats('os',$actu,1,$liste_os, 'date.os' );
		stats('pays',$actu,1,$liste_pays , 'date.pays' );
		stats('theme',$actu,0,NULL,'date.theme');
		st_navig($actu,'date.navig');	
	
	}
	else if(isset($_GET['all_period'])){

		$template->assign_block_vars ( 'date' , array (
		'SEE_IN' =>  SEE_STATS_IN,
		'ALL_PERIOD' => STATS_DURING_LAST_SEVEN,
		'URL' => './index.php?mods=stats&date',
		'LAST_SEVEN_DAYS' => STATS_DURING_ALL_PERIOD,
		'OS_STATS' => mods_stats_os_stats,
		'PAYS' => mods_stats_pays_stat,
		'BACK' => back,
		'JS' => '
		<script type="text/javascript">
				<!--
					function show_navig(id){
						if ( document.getElementById ( id ) ){
							if ( document.getElementById ( id ).style.visibility == "hidden" ){
								document.getElementById ( id ).style.visibility = "visible";
								document.getElementById ( id ).style.height = "";
							}
							else{
								document.getElementById ( id ).style.visibility = "hidden";
								document.getElementById ( id ).style.height = "0px";
							}
						}
					}
				-->
		</script>',
		'NAVIGS' => mods_stats_navigators_stats,
		'THEME' => mods_stats_theme_stat ) );
		
		sort($years,SORT_NUMERIC);
		foreach($years as $year){
			if($year!=''){
				$template->assign_block_vars ( 'date.years' , array ( 'YEAR' => $year ) );
			}
		}

		stats('os',$users,1,$liste_os, 'date.os' );
		stats('pays',$users,1,$liste_pays , 'date.pays' );
		stats('theme',$users,0,NULL,'date.theme');
		st_navig($users,'date.navig');	
	
	}
	else{
		$template->assign_block_vars ( 'date' , array (
		'SEE_IN' =>  SEE_STATS_IN,
		'ALL_PERIOD' => SEE_STATS_IN_ALL_PERIOD,
		'URL' => 'index.php?mods=stats&amp;date&amp;all_period',
		'LAST_SEVEN_DAYS' => STATS_DURING_LAST_SEVEN,
		'OS_STATS' => mods_stats_os_stats,
		'PAYS' => mods_stats_pays_stat,
		'BACK' => back,
		'JS' => '
		<script type="text/javascript">
				<!--
					function show_navig(id){
						if ( document.getElementById ( id ) ){
							if ( document.getElementById ( id ).style.visibility == "hidden" ){
								document.getElementById ( id ).style.visibility = "visible";
								document.getElementById ( id ).style.height = "";
							}
							else{
								document.getElementById ( id ).style.visibility = "hidden";
								document.getElementById ( id ).style.height = "0px";
							}
						}
					}
				-->
		</script>',
		'NAVIGS' => mods_stats_navigators_stats,
		'THEME' => mods_stats_theme_stat ) );
		sort($years,SORT_NUMERIC);
		foreach($years as $year){
			if($year!=''){
				$template->assign_block_vars ( 'date.years' , array ( 'YEAR' => $year ) );
			}
		}
		$mois = date('m',time());
		$jour = date('d',time());
		
		$jour_min = $jour - 7;
		if ( $jour_min < 0 )$jour_min = 30 - $jour_min;
		
		// On affiche les stats sur les 7 derniers jours ;)
		$actu = array();
		foreach($users as $id => $array){
			if($id!=''){
				$date = explode(';',$array['date']);
				foreach($date as $var){
					if($var != ''){
						$dates = explode(',',$var);
						if($dates[1] == $mois){
							if ($dates[0]>$jour_min && $dates[0]<=$jour){
								$actu[$id] = $array;
							}
						}
					}
				}
			}
		}

		stats('os',$actu,1,$liste_os, 'date.os' );
		stats('pays',$actu,1,$liste_pays , 'date.pays' );
		stats('theme',$actu,0,NULL,'date.theme');
		st_navig($actu,'date.navig');
	
	}
}
else if ( isset ( $_GET['pages'] ) ){
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => PAGES_DETAILS ) );
	$pg = parse_ini_file ( './mods/stats/pages.ini' , TRUE );
	
	$template->assign_block_vars ( 'page' , array (
	'NB_PAGES' => NB_TOTAL_PAGES,
	'NB_PAGES_VALUE' => $pg['total']['pages'],
	'BACK' => back ) );
	
	foreach ( $pg['modules'] AS $mod => $value ){
		if ( is_file ( './mods/'.$mod.'/install_def.php' ) )
		include ( './mods/'.$mod.'/install_def.php' );
		if ( isset ( ${'mod_name_'.$u_lang} ) )
			$mod = ${'mod_name_'.$u_lang};
		$template->assign_block_vars ( 'page.pg' , array (
		'NAME' => ucfirst ( $mod ),
		'VALUE' => $value ) );
		unset ( ${'mod_name_'.$u_lang} );
	}
}
else{
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => mods_stats_index ) );
	
	$template->assign_block_vars ( 'index' , array (
	'NAVIG' => mods_stats_navigators_stats,
	'PERIOD' => mods_stats_period_stat,
	'OS' => mods_stats_os_stats,
	'PAYS' => mods_stats_pays_stat,
	'THEME' => mods_stats_theme_stat,
	'PAGE_DETAILS' => PAGES_DETAILS ) );

}

$template->set_filename ( 'bas_mods.tpl' );

?>