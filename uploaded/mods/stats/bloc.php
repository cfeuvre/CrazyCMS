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

$template->set_filename ( './modules/stats/bloc.tpl' , FALSE , $row['colonne']);
$template->assign_bloc_name ( 'BLOC_STATS_TITLE' , $row['tbloc'] );
$template->assign_bloc_name ( 'BLOC_STATS_COLONNE' , $row['colonne'] );

include('./mods/stats/langues/'.$u_lang.'.php');
if(!defined('CCMS'))die('');
include_once('./mods/stats/arrs.php');

if ( isset ( $HTTP_SERVER_VARS['HTTP_REFERER'] ) )
	$referer = htmlspecialchars ( $HTTP_SERVER_VARS['HTTP_REFERER'] );
else
	$referer = '';
	
// Enplacement actuelle de l'utilisateur sur le site
$emplacement = '';
if(isset($_GET['mods'])){
	$emplacement = htmlspecialchars($_GET['mods'],ENT_QUOTES);
}
else{
	//Si aucun module choisi dans l'url, la personne se trouve logiquement sur le module d'accueil
	$emplacement = $mod_acc;
}

if ( isset ( $_GET['mods'] ) )
	$mod = htmlspecialchars ( $_GET['mods'] );
else
	$mod = $mod_acc;

$template->assign_block_vars ( 'stats_bloc' , array (
'NO_JS' => NO_JS,
'JS' => '
<script type="text/javascript">
	<!--
		function update_stats(){
			
			var xhr_object = null; 
			 
			if(window.XMLHttpRequest) // Navigateur Normal :
				xhr_object = new XMLHttpRequest(); 
			else if(window.ActiveXObject) // Internet Explorer 
				xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 

			// Données a envoyer à la page
			var  data = "uid='.intval($uid).'&grade='.intval($grade).'&emplacement='.$emplacement.'&url_site='.$url_site.'&ip='.htmlspecialchars ( $_SERVER['REMOTE_ADDR'] ).'&navig='.htmlspecialchars ( $_SERVER['HTTP_USER_AGENT'] ).'&referer='.$referer.'"; 

			// On appelle la page distante
			xhr_object.open("POST", "./mods/stats/ajax.php?update_stat", true); 
			xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
			xhr_object.send(data);

		}
		function load_stats( reload ){
			
			var xhr_object = null; 
			 
			if(window.XMLHttpRequest) // Navigateur Normal :
				xhr_object = new XMLHttpRequest(); 
			else if(window.ActiveXObject) // Internet Explorer 
				xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 

			// Données a envoyer à la page
			var  data = "mod='.$mod.'&langue='.$u_lang.'&theme='.$u_theme.'&reload=" + reload; 
			
			// On appelle la page distante
			xhr_object.open("POST", "./mods/stats/ajax.php?load_stat", true); 
			 
			xhr_object.onreadystatechange = function() { 

				if(xhr_object.readyState == 4){
					document.getElementById(\'stats_bloc\').innerHTML = xhr_object.responseText;
					show_record( \'stats_tot\');
					show_record( \'memberlist\');
					setTimeout ( "load_stats(false)" , 15000 );
				}
			}

			xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
			xhr_object.send(data);

		}
		function show_record(id){
			if ( document.getElementById ( id ).style.visibility == "hidden" ){
				document.getElementById ( id ).style.visibility = "visible";
				document.getElementById ( id ).style.height = "";
			}
			else{
				document.getElementById ( id ).style.visibility = "hidden";
				document.getElementById ( id ).style.height = "0px";
			}
		}
		update_stats();
		load_stats(true);
	-->
</script>' ) );
?>