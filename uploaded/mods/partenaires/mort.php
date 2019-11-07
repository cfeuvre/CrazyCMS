<?php
/*****************************************
* Module Partenaires pour CCMS by Calfou *
*                                        *
* Page mort.php du  8 décembre 2007      *
*****************************************/
$Bdd->sql('UPDATE '.PT.'_partenaires SET valid=2 WHERE id='.intval ( $_GET['id'] ) );

	$cont = proposed_dead;
	$cont .= $alerte->redir('index.php?mods=partenaires' );
 
 $template->assign_block_vars('module',array('TITRE_MODULE' => '', 'CONTENU_MODULE'=>$cont));
?>