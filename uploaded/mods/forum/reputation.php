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

if ( $uid > 1 && $function_reputation == 1 ){
	if(isset($_GET['increase'])){

		// On charge le haut du bloc
		$template->set_filename ( 'haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => UPDATE_USER_REPUTATION ) );

		$template->set_filename ( './modules/forum/reputation.tpl' );

		$query = $Bdd->sql('SELECT pseudo, reputation FROM '.PT.'_users WHERE id="'.intval($_GET['increase']).'"' );
		$sql = $Bdd->get_array($query);

		// On verifie que l'utilisateur na pas deja donne des points sur ce post
		$rep = explode(';',$sql['reputation']);
		$already = false;
		foreach ( $rep as $value){
			if($value!=''){
				$rept = explode(':',$value);

				if(isset($_GET['reply'])){
					if($rept[1]==intval($_GET['reply']) && $rept[0] == 1 && $rept[2] == $uid){
						$already = true;
					}
				}
				else if(isset($_GET['topic'])){
					if($rept[1]==intval($_GET['topic']) && $rept[0] == 0 && $rept[2] == $uid){
						$already = true;
					}
				}

			}
		}

		if($already === true){
			$template->assign_block_vars ( 'reputation_error' , array ( 
			'TXT' => ALREADY_INCREASE,
			'URL' => 'index.php?mods=forum&page=viewtopic&id='.intval( $_GET['topic'] ),
			'BACK' => back ) );
		}
		else if($uid == intval($_GET['increase'])){
			$template->assign_block_vars ( 'reputation_error' , array ( 
			'TXT' => CANT_UPDATE_YOUR_REP,
			'URL' => 'index.php?mods=forum&page=viewtopic&id='.intval( $_GET['topic'] ),
			'BACK' => back ) );
		}
		else{

			if(isset($_POST['points'])){

				$points = intval($_POST['points']);

				switch($points){
				case 1:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':1;') : ('0:'.intval($_GET['topic']).':'.$uid.':1;') );
				break;
				case 2:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':2;') : ('0:'.intval($_GET['topic']).':'.$uid.':2;') );
				break;
				case 5:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':5;') : ('0:'.intval($_GET['topic']).':'.$uid.':5;') );
				break;
				case 10:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':10;') : ('0:'.intval($_GET['topic']).':'.$uid.':10;') );
				break;
				case 20:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':20;') : ('0:'.intval($_GET['topic']).':'.$uid.':20;') );
				break;
				}
				$new_rept = $sql['reputation'].$new_rept;
				$Bdd->sql('UPDATE '.PT.'_users SET reputation = "'.$new_rept.'" WHERE id="'.intval($_GET['increase']).'"' );

				$template->assign_block_vars ( 'reputation_valid' , array ( 
				'TXT' => REPUTATION_SUCCESSFULLY_UPDATED,
				'URL' => 'index.php?mods=forum&page=viewtopic&id='.intval( $_GET['topic'] ),
				'BACK' => back ) );
			}
			else{

				$template->assign_block_vars ( 'reputation_form' , array ( 
				'TITLE' => INCREASE_REPUTATION,
				'U_CAN_CHOOSE_DECREASE' => U_CAN_CHOOSE_INCREASE,
				'ADD' => add,
				'PTS_TO_USER' => PTS_TO_USER,
				'PSEUDO' => $sql['pseudo'],
				'VALID' => valid ) );

				$pts = array ( 1 , 2 , 5 , 10 , 20 );
				foreach ( $pts AS $pt ){
					$template->assign_block_vars ( 'reputation_form.reputation_form_choix' , array ( 
					'VALEUR' => $pt ) );
				}
			}
		}
		// On charge le bas du bloc
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else if(isset($_GET['decrease'])){

		// On charge le haut du bloc
		$template->set_filename ( 'haut_mods.tpl' );
		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => UPDATE_USER_REPUTATION ) );

		$template->set_filename ( './modules/forum/reputation.tpl' );

		$query = $Bdd->sql('SELECT pseudo, reputation FROM '.PT.'_users WHERE id="'.intval($_GET['decrease']).'"' );
		$sql = $Bdd->get_array($query);

		// On verifie que l'utilisateur na pas deja donne des points sur ce post
		$rep = explode(';',$sql['reputation']);
		$already = false;
		foreach ( $rep as $value){
			if($value != ''){
				$rept = explode(':',$value);

				if(isset($_GET['reply'])){
					if($rept[1]==intval($_GET['reply']) && $rept[0] == 1 && $rept[2] == $uid){
						$already = true;
					}
				}
				else if(isset($_GET['topic'])){
					if($rept[1]==intval($_GET['topic']) && $rept[0] == 0 && $rept[2] == $uid){
						$already = true;
					}
				}
			}
		}

		if($already === true){
			$template->assign_block_vars ( 'reputation_error' , array ( 
			'TXT' => ALREADY_INCREASE,
			'URL' => 'index.php?mods=forum&page=viewtopic&id='.intval( $_GET['topic'] ),
			'BACK' => back ) );
		}
		else if($uid == intval($_GET['decrease'])){
			$template->assign_block_vars ( 'reputation_error' , array ( 
			'TXT' => CANT_UPDATE_YOUR_REP,
			'URL' => 'index.php?mods=forum&page=viewtopic&id='.intval( $_GET['topic'] ),
			'BACK' => back ) );
		}
		else{

			if(isset($_POST['points'])){

				$points = htmlspecialchars($_POST['points'],ENT_QUOTES);

				switch($points){
				case -1:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':-1;') : ('0:'.intval($_GET['topic']).':'.$uid.':-1;') );
				break;
				case -2:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':-2;') : ('0:'.intval($_GET['topic']).':'.$uid.':-2;') );
				break;
				case -5:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':-5;') : ('0:'.intval($_GET['topic']).':'.$uid.':-5;') );
				break;
				case -10:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':-10;') : ('0:'.intval($_GET['topic']).':'.$uid.':-10;') );
				break;
				case -20:
					$new_rept = ( (isset($_GET['reply'])) ? ('1:'.intval($_GET['reply']).':'.$uid.':-20;') : ('0:'.intval($_GET['topic']).':'.$uid.':-20;') );
				break;
				}
				$new_rept = $sql['reputation'].$new_rept;
				$Bdd->sql('UPDATE '.PT.'_users SET reputation = "'.$new_rept.'" WHERE id="'.intval($_GET['decrease']).'"' );

				$template->assign_block_vars ( 'reputation_valid' , array ( 
				'TXT' => REPUTATION_SUCCESSFULLY_UPDATED,
				'URL' => 'index.php?mods=forum&page=viewtopic&id='.intval( $_GET['topic'] ),
				'BACK' => back ) );
			}
			else{
				$template->assign_block_vars ( 'reputation_form' , array ( 
				'TITLE' => DECREASE_REPUTATION,
				'U_CAN_CHOOSE_DECREASE' => U_CAN_CHOOSE_DECREASE,
				'ADD' => add,
				'PTS_TO_USER' => PTS_TO_USER,
				'PSEUDO' => $sql['pseudo'],
				'VALID' => valid ) );

				$pts = array ( -1 , -2 , -5 , -10 , -20 );
				foreach ( $pts AS $pt ){

					$template->assign_block_vars ( 'reputation_form.reputation_form_choix' , array ( 
					'VALEUR' => $pt ) );

				}
			}
		}
		// On charge le bas du bloc
		$template->set_filename ( 'bas_mods.tpl' );
	}
	else{
		// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
		$template->set_filename('error_page.tpl' );
		$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
	}
}
else{
	// Si l'utilsiateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>