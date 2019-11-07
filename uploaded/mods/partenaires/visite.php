<?php
/*****************************************
* Module Partenaires pour CCMS by Calfou *
*                                        *
*   Page visite.php du 8 décembre 2007   *
*****************************************/
$Bdd->sql('UPDATE '.PT.'_partenaires SET nb_click=nb_click+1 WHERE id='.intval ( $_GET['id'] ) );
$req = $Bdd->sql('SELECT url_site FROM '.PT.'_partenaires WHERE id='.intval ( $_GET['id'] ) );
$row = $Bdd->get_array($req);
$cont = '<script type="text/javascript">
	window.location.href = "'.$row['url_site'].'";
</script>';
$template->assign_block_vars('module',array('TITRE_MODULE' => '', 'CONTENU_MODULE'=>$cont));
?>
