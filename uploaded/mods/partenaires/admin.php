<?php
/*****************************************
* Module Partenaires pour CCMS by Calfou *
*                                        *
*  Page admin.php du 8 décembre 2007     *
*****************************************/

if(!defined('CCMS')) die('' );
if($grade==4 || ereg('admin_partenaire;',$permissions)){

//Affichage des liens de navigation
$cont ='<p><img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;page=admin&amp;cdt">'.cdt_part.'</a>&nbsp;&nbsp;
<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;page=admincat&amp;modcat">'.cat_part.'</a></p>';
/***************************************************
*   Affichage des liens à valider ou signalé mort  *
***************************************************/
  if(!isset($_GET[''])){
        $req = $Bdd->sql('SELECT '.PT.'_partenaires.id AS part_id,
                           '.PT.'_partenaires.cat AS part_cat,
                           '.PT.'_partenaires.nom,
                           '.PT.'_partenaires.url_site,
                           '.PT.'_partenaires.rss,
                           '.PT.'_partenaires.nb_click,
                           '.PT.'_partenaires.nb_aff,
                           '.PT.'_partenaires.description,
                           '.PT.'_partenaires.date,
                           '.PT.'_partenaires.short_desc,
                           '.PT.'_partenaires_cat.id AS cat_id ,
                           '.PT.'_partenaires_cat.cat AS cat_cat
                           FROM '.PT.'_partenaires LEFT JOIN '.PT.'_partenaires_cat ON '.PT.'_partenaires.cat = '.PT.'_partenaires_cat.id WHERE valid="0" ORDER BY '.PT.'_partenaires.id' );
	if($Bdd->get_num_rows($req) > '0'){
          $cont .= '<h1>'.partenaire_to_valid.'</h1>';
 }
	
	while($rep = $Bdd->get_array($req)){
	$cont .= '<fieldset>
			<legend>'.fiche_du_site.'</legend><br />
                        '.cat_of_site.' : '.$rep['cat_cat'].'<br/>
                        '.name_of_site.' : '.$rep['nom'].'<br/>
                        '.url_site.' : <a href="'.$rep['url_site'].'" title="'.url_site.'">'.$rep['url_site'].'</a><br/>
			'.url_rss.' : <a href="'.$rep['rss'].'" title="feeds">'.$rep['rss'].'</a><br/>
			'.short_desc_of_site.' : '.to_html ( $rep['short_desc'] ).' <br/>
                        '.description_site.' : '.to_html ( $rep['description'] ).' <br/><br />
			<a href="index.php?mods=partenaires&amp;page=admin&amp;val='.$rep['part_id'].'">'.to_valid_this_part.'</a>&nbsp;&nbsp;
                        <a href="index.php?mods=partenaires&amp;page=admin&amp;del='.$rep['part_id'].'">'.to_delet_this_part.'</a>&nbsp;&nbsp;
                        <a href="index.php?mods=partenaires&amp;page=admin&amp;mod='.$rep['part_id'].'">'.to_change_this_part.'</a>&nbsp;&nbsp;
			</fieldset><br />';
	}
	$req = $Bdd->sql('SELECT '.PT.'_partenaires.id AS part_id,
                           '.PT.'_partenaires.cat AS part_cat,
                           '.PT.'_partenaires.nom,
                           '.PT.'_partenaires.url_site,
                           '.PT.'_partenaires.rss,
                           '.PT.'_partenaires.nb_click,
                           '.PT.'_partenaires.nb_aff,
                           '.PT.'_partenaires.description,
                           '.PT.'_partenaires.date,
                           '.PT.'_partenaires.short_desc,
                           '.PT.'_partenaires_cat.id AS cat_id ,
                           '.PT.'_partenaires_cat.cat AS cat_cat
                           FROM '.PT.'_partenaires LEFT JOIN '.PT.'_partenaires_cat ON '.PT.'_partenaires.cat = '.PT.'_partenaires_cat.id WHERE valid="2" ORDER BY '.PT.'_partenaires.id' );
        if($Bdd->get_num_rows($req) > '0'){
        $cont .= '<h1>'.partenaire_dead.'</h1>';
	}
	while($rep = $Bdd->get_array($req)){
	$cont .= '<fieldset>
			<legend>'.fiche_du_site.'</legend><br />
                        '.cat_of_site.' : '.$rep['cat_cat'].'<br/>
                        '.name_of_site.' : '.$rep['nom'].'<br/>
                        '.url_site.' : <a href="'.$rep['url_site'].'" title="'.url_site.'">'.$rep['url_site'].'</a><br/>
			'.url_rss.' : <a href="'.$rep['rss'].'" title="feeds">'.$rep['rss'].'</a><br/>
			'.short_desc_of_site.' : '.to_html ( $rep['short_desc'] ).' <br/>
                        '.description_site.' : '.to_html ( $rep['description'] ).' <br/><br />
			<a href="index.php?mods=partenaires&amp;page=admin&amp;val='.$rep['part_id'].'">'.to_valid_dead.'</a>&nbsp;&nbsp;
                        <a href="index.php?mods=partenaires&amp;page=admin&amp;del='.$rep['part_id'].'">'.to_delet_dead.'</a>&nbsp;&nbsp;
                        <a href="index.php?mods=partenaires&amp;page=admin&amp;mod='.$rep['part_id'].'">'.to_change_this_part.'</a>&nbsp;&nbsp;
			</fieldset><br />';
	}
  }
/****************************
*   Validation d'un lien    *
****************************/ 
  if(isset($_GET['val'])){
          $cont = partenaire_valid;
          $cont .= $alerte->redir('index.php?mods=partenaires&page=admin' );
          $Bdd->sql('UPDATE '.PT.'_partenaires SET valid=1 WHERE id='.intval ( $_GET['val'] ) );
  }
/****************************
*   Suppression d'un lien    *
****************************/
  if(isset($_GET['del'])){
          $cont = partenaire_deleted;
          $cont .= $alerte->redir('index.php?mods=partenaires&page=admin' );
          $Bdd->sql('DELETE FROM '.PT.'_partenaires WHERE id='.intval ( $_GET['del'] ) );
  }
/****************************
*   Modification d'un lien  *
****************************/
  if(isset($_GET['mod'])){
          $cont = modif_part;
          $req = $Bdd->sql('SELECT '.PT.'_partenaires.id AS part_id,
                           '.PT.'_partenaires.cat AS part_cat,
                           '.PT.'_partenaires.nom,
                           '.PT.'_partenaires.url_site,
                           '.PT.'_partenaires.rss,
                           '.PT.'_partenaires.nb_click,
                           '.PT.'_partenaires.nb_aff,
                           '.PT.'_partenaires.description,
                           '.PT.'_partenaires.date,
                           '.PT.'_partenaires.short_desc,
                           '.PT.'_partenaires_cat.id AS cat_id ,
                           '.PT.'_partenaires_cat.cat AS cat_cat
                           FROM '.PT.'_partenaires LEFT JOIN '.PT.'_partenaires_cat ON '.PT.'_partenaires.cat = '.PT.'_partenaires_cat.id WHERE  '.PT.'_partenaires.id='.intval ( $_GET['mod'] ) );
          $rep = $Bdd->get_array($req);
          //Affichage du formulaire de modification avec les valeurs en bd
          			  $descript = default_form( FALSE , NULL , $rep['description'] );
                                  $cont = '<script type="text/javascript">
					function verif_url(idverif,idmodif){
						
						var url = document.getElementById(idverif).value;
						if ( url.indexOf ( "http://" , 0 ) == 0 ) {
						document.getElementById(idmodif).innerHTML = "";
						}
						else{
						document.getElementById(idmodif).innerHTML = "<font color=\"red\">L\'url doit commencer par http://</font>";
						}
					}
					</script>
				<form action="index.php?mods=partenaires&amp;page=admin&amp;modok='.intval ( $_GET['mod'] ).'" method="post">
				<table>
					<tr>
						<td>'.cat_of_site.'</td><td><input type="text" name="cat_site" id="cat_site" value="'.$rep['cat_cat'].'" /></td>
					</tr>
                                        <tr>
						<td>'.name_of_site.'</td><td><input type="text" name="nom_site" id="nom_site" value="'.$rep['nom'].'" /></td>
					</tr>
					<tr>
						<td>'.url_site.'</td><td><input type="texte" name="url_site" id="url_site" onblur="verif_url(\'url_site\',\'verifi_site\')" value="'.$rep['url_site'].'" /></td>
					</tr>
					<tr>
						<td><div id="verifi_site"></div></td>
					</tr>
					<tr>
						<td>'.url_rss.'</td><td><input type="texte" name="url_rss" id="url_rss" onblur="verif_url(\'url_rss\',\'verifi_rss\')" value="'.$rep['rss'].'" /></td>
					</tr>
                                        <tr>
						<td><div id="verifi_rss"></div></td>
					</tr>
					<tr>
						<td>'.short_desc_of_site.'</td><td><input type="text" name="short_desc" id="short_desc" value="'.$rep['short_desc'].'" /></td>
					</tr>
					<tr>
						<td>'.description_of_site.'</td><td>'.$descript.'</textarea></td>
					</tr>

					</table>
					</form>';
  }
/****************************
*   Validation d'un lien    *
****************************/
  if(isset($_GET['modok'])){
  $contenu = $Bdd->secure($_POST['contenu']);
	$Bdd->sql('UPDATE '.PT.'_partenaires SET `url_site`="'.$Bdd->secure($_POST['url_site']).'", rss="'.$Bdd->secure($_POST['url_rss']).'", cat="'.$Bdd->secure($_POST['cat_site']).'", description="'.$contenu.'", nom="'.$Bdd->secure($_POST['nom_site']).'", short_desc="'.$Bdd->secure($_POST['short_desc']).'" WHERE id='.intval ( $_GET['modok'] ) );
	$cont = cdt_wait_validation;
	$cont .= $alerte->redir('index.php?mods=partenaires&page=admin' );
  }
/************************************************
*   Modification des conditions de partenariat  *
************************************************/
  if(isset($_GET['cdt'])){
          $cont = '<strong>'.cdt_part1.'</strong>';
          $contenu1 = default_form( FALSE , NULL , $cdt_partenaires );
          //Afichage du formulaire
          $cont .='<form action="index.php?mods=partenaires&amp;page=admin&amp;ok" method="post">
				<table><tr>
						<td>'.$contenu1.'</textarea></td>
					</tr>

					</table>
					</form>';

  }
/************************************************
*   Validation des conditions de partenariat    *
************************************************/
  if(isset($_GET['ok'])){
	$contenu = $Bdd->secure($_POST['contenu']);
	$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.$contenu.'" WHERE nom="cdt_partenaires"' );
	$cont = cdt_wait_validation;
	$Bdd->delete_cached_data ( 'config' );
	$cont .= $alerte->redir('index.php?mods=partenaires&page=admin' );
  }

/***************************************************
*     Lien de retour et affichage de la page..     *
***************************************************/
	$cont .='<br /><br /><center><a href="javascript:history.go(-1)">Retour</a></center>';
	$template->assign_block_vars('module',array('TITRE_MODULE' => '', 'CONTENU_MODULE'=>$cont));
}
?>