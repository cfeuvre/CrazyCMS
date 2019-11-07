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
$grades = explode ( ',' , $menu_grade_admin );
if($grade==4 || in_array ( $grade , $grades , TRUE ) ){
$titre_mod = menu;
if(isset($_GET['del'])){
	$new_menu = str_replace($Bdd->secure($_GET['grade']).'|*|'.base64_decode ( $_GET['name'] ).'|*|'.$Bdd->secure( base64_decode ( $_GET['url'] ) ).'|**|','',$default_menu);
	$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$new_menu.'" WHERE nom="default_menu"');
	$cont = '<br />'.link_deleted_successfully.'<br /><br /><a href="index.php?mods=menu&amp;page=admin">'.back.'</a>';
	$Bdd->delete_cached_data('config');
}
else if(isset($_GET['edit'])){
	if(isset($_POST['name'])){
	
	$grade = '';
	if(isset($_POST['grade_0']))$grade .= '0,-1,-5,-6,';
	for ( $i = 0 ; $i < $nb_total_grades ; $i++ ){
		if(isset($_POST['grade_'.$i]))$grade .= $i.',';
	}
	$grade = substr($grade,0,strlen($grade)-1);

	$new_menu = str_replace( $Bdd->secure ( $_GET['grade'] ).'|*|'.base64_decode ( $_GET['name'] ).'|*|'.$Bdd->secure( base64_decode ( $_GET['url'] ) ).'|**|',$grade.'|*|'.$Bdd->secure(str_replace('|*','| *',$_POST['name'])).'|*|'.$Bdd->secure ( str_replace ( '|*' , '| *' , $_POST['urlo'] ) ).'|**|',$default_menu);
	//$cont = $Bdd->secure ( $_GET['grade'] ).'|*|'.$Bdd->secure ( base64_decode ( $_GET['name'] ) ).'|*|'.$Bdd->secure( base64_decode ( $_GET['url'] ) ).'|**|'.'<br />'.$new_menu;
	$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$new_menu.'" WHERE nom="default_menu"');
	$cont = '<br />'.link_updated_successfully.'<br /><br /><a href="index.php?mods=menu&amp;page=admin">'.back.'</a>';
	$Bdd->delete_cached_data('config');
	}
	else{
	
	$grades = explode(',',$Bdd->secure($_GET['grade']));
	
		$cont ='
	<form method="post" action="">
		<table>
			<tr>
				<td>
					'.link_name.'
				</td>
				<td>
					<input type="text" name="name" value="'.to_html ( base64_decode ( $_GET['name'] ) ).'"/>
				</td>
			</tr>
			<tr>
				<td>
					'.link_url.'
				</td>
				<td>
					<input type="text" name="urlo" value="'.htmlspecialchars ( base64_decode ( $_GET['url'] ) ).'"/>
				</td>
			</tr>
			<tr>
				<td>
					'.rank.'
				</td>
				<td>';
					
		for ( $i = 0 ; $i < $nb_total_grades ; $i++ ){
	
			$cont .= '<input type="checkbox" name="grade_'.$i.'" '.( (in_array( $i , $grades ) ) ? ('checked="checked"') : ('') ).'/>'.${'grade_'.$i}['name'].'<br />';
		}
		
	$cont .='
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="'.valid.'" />
				</td>
			</tr>
		</table>
	</form>';
	
	
	
	}
}
else if(isset($_GET['add'])){
	if(isset($_POST['name'])){
	$grade = '';
	if(isset($_POST['grade_0']))$grade .= '0,-1,-5,-6,';
	
	for ( $i = 0 ; $i < $nb_total_grades ; $i++ ){
		if(isset($_POST['grade_'.$i]))$grade .= $i.',';
	}
	$grade = substr($grade,0,strlen($grade)-1);
	
	$new_menu = preg_replace('![0-9,-]+\|\*\|'.$Bdd->secure($_POST['name']).'\|\*\|'.$Bdd->secure($_POST['urlo']).'\|\*\*\|!isU','',$default_menu);
	$new_menu .= $grade.'|*|'.$Bdd->secure(str_replace('|*','| *',$_POST['name'])).'|*|'.$Bdd->secure(str_replace('|*','| *',$_POST['urlo'])).'|**|';
	$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$new_menu.'" WHERE nom="default_menu"');

		$cont = '<br />'.link_added_successfully.'<br /><br /><a href="index.php?mods=menu&amp;page=admin">'.back.'</a>';
	
	$Bdd->delete_cached_data('config');
	}
	else{
	
	
	
		$cont ='
	<form method="post" action="">
		<table>
			<tr>
				<td>
					'.link_name.'
				</td>
				<td>
					<input type="text" name="name" />
				</td>
			</tr>
			<tr>
				<td>
					'.link_url.'
				</td>
				<td>
					<input type="text" name="urlo" />
				</td>
			</tr>
			<tr>
				<td>
					'.rank.'
				</td>
				<td>';
				
		for ( $i = 0 ; $i < $nb_total_grades ; $i++ ){
			$cont .= '<input type="checkbox" name="grade_'.$i.'"/>'.${'grade_'.$i}['name'].'<br />';
		}
		
		$cont .='
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="'.valid.'" />
				</td>
			</tr>
		</table>
	</form>';
	
	
	
	}
}
else{

	$default_menu_array = explode('|**|',$default_menu);
	$links = array();
	$a = 0;
	foreach($default_menu_array as $actual_link){
                 if($actual_link !=''){
		$link = explode('|*|',$actual_link);
		$links[$a] = array('grade' => $link[0], 'url' => htmlspecialchars($link[2]),'nom' => htmlspecialchars($link[1]));
		$a++;
	}
}
	
	$cont = '<br />
	<a href="index.php?mods=menu&amp;page=admin&amp;add">
		'.add_link.'
	</a>
	<br /><br />
	<center>
	<table border="1" style="width:95%;">
		<tr align="center">
			<td>
				<strong>'.name.'</strong>
			</td>
			<td>
				<strong>'.link_url.'</strong>
			</td>
			<td>
				<strong>'.rank.'</strong>
			</td>
			<td>
				<strong>'.edit.'</strong>
			</td>
			<td>
				<strong>'.delete.'</strong>
			</td>
		</tr>';
		
		foreach($links as $id => $array){
			if($array['nom'] !=''){
				$grades = explode(',',$array['grade']);
				$grad = '';
				
				for ( $i = 0 ; $i < $nb_total_grades ; $i++ ){
					if(in_array( $i , $grades ) )$grad .= ucfirst( ${'grade_'.$i}['name'] ).'<br />';
				}

				$cont .= '
			<tr>
				<td>
					'.to_html($array['nom']).'
				</td>
				<td>
					'.substr ( $array['url'] , 0 , 30 ).' '.( ( strlen ( $array [ 'url' ] ) > 30 ) ? ('...') : ('') ).'
				</td>
				<td>
					'.$grad.'
				</td>
				<td align="center">
					<a href="index.php?mods=menu&amp;page=admin&amp;edit&amp;name='.base64_encode( $array['nom'] ).'&amp;url='.base64_encode ( $array['url']).'&amp;grade='.$array['grade'].'">
						<img src="./themes/'.$u_theme.'/img/admin/edit.gif" border="0">
					</a>
				</td>
				<td align="center">
					<a href="index.php?mods=menu&amp;page=admin&amp;del&amp;name='.base64_encode ( $array['nom'] ).'&amp;url='.base64_encode ( $array['url'] ).'&amp;grade='.$array['grade'].'">
						<img src="./themes/'.$u_theme.'/img/admin/del.gif" border="0">
					</a>
				</td>
			</tr>';
			}
		}
	$cont .= '</table></center><br /><br />
	<a href="index.php?mods=admin">'.back.'</a>
	';
	
	
	
	}
$template->assign_block_vars('module',array('TITRE_MODULE' => $titre_mod, 'CONTENU_MODULE'=> $cont));
}
?>