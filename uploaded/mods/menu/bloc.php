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
$menu_lien = '';
$default_menu_array = explode('|**|',$default_menu);
foreach($default_menu_array as $actual_link){
	if($actual_link != ''){
		$link = explode('|*|', htmlspecialchars ( $actual_link ) );
	
		$grad_req = explode(',',$link[0]);
		if( in_array ( $grade , $grad_req ) ){
			$menu_lien .= '<br /><a href="'.$link[2].'">'.to_html($link[1]).'</a>';
		}
	}
}
	
$template->set_filename ( 'bloc.tpl{|}menu'  , FALSE);
$template->assign_block_vars('bloc-menu', array('TITRE_BLOC' => $row['tbloc'], 'CONTENU_BLOC' => $menu_lien));


?>
