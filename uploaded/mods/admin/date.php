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

if($grade == 4){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array (
	'TITRE' => DATE ) );
	$template->set_filename ( './modules/admin/date.tpl' );

	if ( isset ( $_POST['first'] ) ){
	
		$logs->add_event ( HAS_UPDATED_DEFAULT_SYNTAX , DATE );
	
		$new_syntaxe = '';
		
		switch ( $_POST['first'] ){
		
			case 'd':
				$new_syntaxe .= 'd';
			break;
			case 'm':
				$new_syntaxe .= 'm';
			break;
			case 'y':
				$new_syntaxe .= 'y';
			break;
			
		}

		switch ( $_POST['sep_first'] ){
		
			case '-':
				$new_syntaxe .= '-';
			break;
			case '|':
				$new_syntaxe .= '|';
			break;
			case '\\':
				$new_syntaxe .= '\\';
			break;
			case '/':
				$new_syntaxe .= '/';
			break;
			case ':':
				$new_syntaxe .= ':';
			break;
			case ';':
				$new_syntaxe .= ';';
			break;
			
		}
		
		switch ( $_POST['second'] ){
		
			case 'd':
				$new_syntaxe .= 'd';
			break;
			case 'm':
				$new_syntaxe .= 'm';
			break;
			case 'y':
				$new_syntaxe .= 'y';
			break;
			
		}
		
		switch ( $_POST['sep_second'] ){
		
			case '-':
				$new_syntaxe .= '-';
			break;
			case '|':
				$new_syntaxe .= '|';
			break;
			case '\\':
				$new_syntaxe .= '\\';
			break;
			case '/':
				$new_syntaxe .= '/';
			break;
			case ':':
				$new_syntaxe .= ':';
			break;
			case ';':
				$new_syntaxe .= ';';
			break;
			
		}		
		
		switch ( $_POST['third'] ){
		
			case 'd':
				$new_syntaxe .= 'd';
			break;
			case 'm':
				$new_syntaxe .= 'm';
			break;
			case 'y':
				$new_syntaxe .= 'y';
			break;
			
		}
		
		$new_syntaxe .= ' '.str_replace ( ' ' , '+esp;' , htmlspecialchars ( $_POST['center_text'] ) ).' ';
		
		switch ( $_POST['type'] ){
			
			case 12:
				$new_syntaxe .= '12';
			break;
			case 24:
				$new_syntaxe .= '24';
			break;
		
		}
		
		switch ( $_POST['sep_last'] ){
		
			case '-':
				$new_syntaxe .= '-';
			break;
			case '|':
				$new_syntaxe .= '|';
			break;
			case '\\':
				$new_syntaxe .= '\\';
			break;
			case '/':
				$new_syntaxe .= '/';
			break;
			case ':':
				$new_syntaxe .= ':';
			break;
			case ';':
				$new_syntaxe .= ';';
			break;
			
		}	
	
		$Bdd->sql ( 'UPDATE '.PT.'_parametres SET valeur="'.$new_syntaxe.'" WHERE nom="default_format_date"' );
		
		$template->assign_block_vars ( 'text' , array (
		'TXT' => updated_successfully,
		'URL' => 'index.php?mods=admin&amp;page=date',
		'BACK' => back ) );
		
		$Bdd->delete_cached_data ( 'config' );
	
	}
	else if ( isset ( $_POST['fuseau_def'] ) ){
	
		$logs->add_event ( HAS_UPDATED_DEFAULT_FUSEAU , DATE );
	
		$Bdd->sql ( 'UPDATE '.PT.'_parametres SET valeur="'.intval ( $_POST['fuseau_def'] ).';'.( ( isset ( $_POST['correction'] ) ) ? ('1') : ('0') ).'" WHERE nom="fuseaux_def"' );
		
		$template->assign_block_vars ( 'text' , array (
		'TXT' => updated_successfully,
		'URL' => 'index.php?mods=admin&amp;page=date',
		'BACK' => back ) );
		
		$Bdd->delete_cached_data ( 'config' );
	
	}
	else{
		
		$fuseaux = explode ( ';' , $fuseaux_def );	
		$format = explode ( ' ' , $default_format_date );

		$template->assign_block_vars ( 'index' , array (
		'DATE_SYNTAX' => DATE_SYNTAX,
		'SEPARATOR' => SEPARATOR,
		'DATE_HOUR' => DATE_HOUR,
		'DATE_TYPE' => DATE_TYPE,
		'HOUR_SEPARATOR' => HOUR_SEPARATOR,
		'DAY' => DAY,
		'MONTH' => MONTH,
		'YEAR' => YEAR,
		'CENTER_SEP' => str_replace ( '+esp;' , ' ' , $format[1] ),
		'VALID' => valid,
		'JS' => '
		<script type="text/javascript">
			<!--
				function change(){
					var hour = document.getElementById(\'general\').innerHTML.split(":");
					var heure = Math.round(hour[0]) + Math.round(document.getElementById(\'fuso\').value) + Math.round(document.getElementById(\'winter\').checked);
					if(heure > 24){
						var heure = Math.round(heure) - Math.round(24);
					}
					else if(heure<0){
						var heure = Math.round(24) + Math.round(heure);
					}
					document.getElementById(\'actual\').innerHTML = "'.WE_ARE_ON.' : " + heure + " : " + hour[1];
				}
			-->
		</script>',
		'DEFAULT_FUSEAU' => DEFAULT_FUSEAU,
		'TIME_ZONE' => time_sone,
		'PB_HOURS' => pb_hours,
		'BACK' => back,
		'WE_ARE' => WE_ARE_ON,
		'DATE' => ccmsdate ( $fuseaux [ 0 ] + $fuseaux [ 1 ] , convertime ( time ( ) ) ),
		'DATE2' => gmdate('h\:i',time()),
		'SUMMER_CHECK' => ( ( $fuseaux[1] == 1 ) ? ('checked="checked"') : ('') ),
		'F1' => ( ( $default_format_date{0} == 'd' ) ? ('selected="selected"') : ('') ),
		'F2' => ( ( $default_format_date{0} == 'm' ) ? ('selected="selected"') : ('') ),
		'F3' => ( ( $default_format_date{0} == 'y' ) ? ('selected="selected"') : ('') ),
		'S1' => ( ( $default_format_date{1} == '/' ) ? ('selected="selected"') : ('') ),
		'S2' => ( ( $default_format_date{1} == '-' ) ? ('selected="selected"') : ('') ),
		'S3' => ( ( $default_format_date{1} == '|' ) ? ('selected="selected"') : ('') ),
		'S4' => ( ( $default_format_date{1} == '\\' ) ? ('selected="selected"') : ('') ),
		'S5' => ( ( $default_format_date{1} == ':' ) ? ('selected="selected"') : ('') ),
		'S6' => ( ( $default_format_date{1} == ';' ) ? ('selected="selected"') : ('') ),
		'SE1' => ( ( $default_format_date{2} == 'd' ) ? ('selected="selected"') : ('') ),
		'SE2' => ( ( $default_format_date{2} == 'm' ) ? ('selected="selected"') : ('') ),
		'SE3' => ( ( $default_format_date{2} == 'y' ) ? ('selected="selected"') : ('') ),
		'SS1' => ( ( $default_format_date{3} == '/' ) ? ('selected="selected"') : ('') ),
		'SS2' => ( ( $default_format_date{3} == '-' ) ? ('selected="selected"') : ('') ),
		'SS3' => ( ( $default_format_date{3} == '|' ) ? ('selected="selected"') : ('') ),
		'SS4' => ( ( $default_format_date{3} == '\\' ) ? ('selected="selected"') : ('') ),
		'SS5' => ( ( $default_format_date{3} == ':' ) ? ('selected="selected"') : ('') ),
		'SS6' => ( ( $default_format_date{3} == ';' ) ? ('selected="selected"') : ('') ),
		'T1' => ( ( $default_format_date{4} == 'd' ) ? ('selected="selected"') : ('') ),
		'T2' => ( ( $default_format_date{4} == 'm' ) ? ('selected="selected"') : ('') ),
		'T3' => ( ( $default_format_date{4} == 'y' ) ? ('selected="selected"') : ('') ),
		'TT1' => ( ( substr ( $default_format_date , ( strlen ( $default_format_date ) - 4 ) , ( strlen ( $default_format_date ) - 2 ) ) == 24 )? ('selected="selected"') : ('') ),
		'TT2' => ( ( substr ( $default_format_date , ( strlen ( $default_format_date ) - 4 ) , ( strlen ( $default_format_date ) - 2 ) ) == 12 )? ('selected="selected"') : ('') ),
		'L1' => ( ( $default_format_date{strlen ( $default_format_date ) -1 } == '/' ) ? ('selected="selected"') : ('') ),
		'L2' => ( ( $default_format_date{strlen ( $default_format_date ) -1 } == '-' ) ? ('selected="selected"') : ('') ),
		'L3' => ( ( $default_format_date{strlen ( $default_format_date ) -1 } == '|' ) ? ('selected="selected"') : ('') ),
		'L4' => ( ( $default_format_date{strlen ( $default_format_date ) -1 } == '\\' ) ? ('selected="selected"') : ('') ),
		'L5' => ( ( $default_format_date{strlen ( $default_format_date ) -1 } == ':' ) ? ('selected="selected"') : ('') ),
		'L6' => ( ( $default_format_date{strlen ( $default_format_date ) -1} == ';' ) ? ('selected="selected"') : ('') ) ) );
		for($i=-12;$i<14;$i++){
			$template->assign_block_vars ( 'index.option' , array (
			'ID' => $i,
			'SELECTED' => ( ( $i == $fuseaux_def ) ? ('selected="selected"') : ('') ) ) );
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