<?php/*Copyright CrazyCMS : Valmori Quentin	quentin.valmori@gmail.comFeuvre Christophe	neowan@live.frHaustrate Kevin	gippel5@hotmail.comThis software is a computer program whose purpose is to make our own website. You just have to follow the automatic installation procedureand you website is operational. Moreover, He is securized and optimized as much as possible.This software is governed by the CeCILL� license under French law andabiding by the rules of distribution of free software.  You can  use, modify and/ or redistribute the software under the terms of the CeCILL�license as circulated by CEA, CNRS and INRIA at the following URL"http://www.cecill.info". The fact that you are presently reading this means that you have hadknowledge of the CeCILL� license and that you accept its terms.*/if(!defined('CCMS'))die('' );if( ereg("poster_comment;",$permissions) || $grade==4){	$news_parent = intval($_REQUEST['news']);	$template->set_filename ( 'haut_mods.tpl' );	$template->set_filename ( './modules/news/post_comment.tpl' );		$template->assign_block_vars ( 'mod_titre' , array (	'TITRE' => add_comment ) );	if(isset($_POST['contenu'])){		$contenu = $Bdd->secure($_POST['contenu']);		$Bdd->sql('INSERT INTO '.PT.'_comment VALUES("","'.$news_parent.'","'.$contenu.'","'.convertime(time()).'","'.$uid.'","0")' );		$Bdd->sql('UPDATE '.PT.'_news SET comments=comments+1 WHERE id="'.$news_parent.'"' );				$q = $Bdd->sql ( 'SELECT COUNT(*) AS nb_com FROM '.PT.'_comment WHERE parent="'.$news_parent.'"' );		$s = $Bdd->get_array ( $q );		$idd = $s['nb_com'];				$Bdd->delete_cached_data('news' );		$Bdd->delete_cached_data('comment' );				$template->assign_block_vars ( 'text' , array (		'TXT' => comment_successfully_posted,		'URL' => 'index.php?mods=news&page=viewnews&news='.$news_parent.'#n'.$idd,		'BACK' => back ) );	}	else{		$template->assign_block_vars ( 'form' , array (		'ID' => intval($_GET['news']),		'FORM' => default_form() ) );	}	$template->set_filename ( 'bas_mods.tpl' );}else{	// Si l'utilisateur n'a rien a faire la, on lui dit ;)	$template->set_filename('error_page.tpl' );	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );}?>