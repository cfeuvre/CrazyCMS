<?php
/*****************************************
* Module Partenaires pour CCMS by Calfou *
*                                        *
* Page index.php du  8 décembre 2007     *
*****************************************/

if(!defined('CCMS')) die('' );
//Test javascript
$testjavascript = '<script language="JavaScript">
function makevisible( id , nm)
   {
		document.getElementById("pic_" + id).style.opacity = nm;
		document.getElementById("pic_" + id).style.filter = "alpha(opacity=" + ( nm * 100 ) + ")";
   }
</script>';


//Choix du type d'affichage
//Par nombre de click
if(isset($_GET['click'])){
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
                           FROM '.PT.'_partenaires LEFT JOIN '.PT.'_partenaires_cat ON '.PT.'_partenaires.cat = '.PT.'_partenaires_cat.id WHERE valid="1" ORDER BY '.PT.'_partenaires.nb_click DESC' );
  $cont ='<p><img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;page=register">'.become_partenaire.'</a>&nbsp;&nbsp;<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;aff">'.order_by_aff.'</a>&nbsp;&nbsp;<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires">'.order_by_cat.'</a></p>';
}
//Par nombre d'affichage
elseif(isset($_GET['aff'])){
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
                           FROM '.PT.'_partenaires LEFT JOIN '.PT.'_partenaires_cat ON '.PT.'_partenaires.cat = '.PT.'_partenaires_cat.id WHERE valid="1" ORDER BY '.PT.'_partenaires.nb_aff DESC' );
  $cont ='<p><img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;page=register">'.become_partenaire.'</a>&nbsp;&nbsp;<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires">'.order_by_cat.'</a>&nbsp;&nbsp;<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;click">'.order_by_click.'</a></p>';
}
//Sinon affichage par défaut (par catégories)
else {
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
                           FROM '.PT.'_partenaires LEFT JOIN '.PT.'_partenaires_cat ON '.PT.'_partenaires.cat = '.PT.'_partenaires_cat.id WHERE valid="1" ORDER BY '.PT.'_partenaires_cat.cat ASC' );
  $cont ='<p><img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;page=register">'.become_partenaire.'</a>&nbsp;&nbsp;<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;aff">'.order_by_aff.'</a>&nbsp;&nbsp;<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;click">'.order_by_click.'</a></p>';
}

$titre = liste_partenaire;
$cont .= $testjavascript;
//Puis on boucle pour l'affichage des sites avec catégories.. (Marche pas pareil si order by nbr_clic ou aff)
$cat = '';
while($row = $Bdd->get_array($req)){
  if ($cat != $row['cat_id'] ) {
    $cont .='<tr><td><strong><h2><img src="../../themes/crazycms1.0/img/puce.gif" title="'.cat_of_site.'" />'.cat_of_site.' : '.to_html ( $row['cat_cat'] ).'</h2></strong></td>';
  }
	$cont .= '
	<table><tr><td><strong>'.htmlspecialchars($row['nom']).' </strong></td>
        <td></td></tr><tr><td><a href="index.php?mods=partenaires&amp;page=visite&amp;id='.htmlspecialchars($row['part_id']).'" title="'.htmlspecialchars($row['nom']).'" target="_blank">
		<img id="pic_'.$row['part_id'].'" style="float: left;filter: alpha(opacity=20);opacity: 0.2;" src="http://open.thumbshots.org/image.pxf?url='.htmlspecialchars($row['url_site']).'" onMouseover="makevisible( \''.$row['part_id'].'\' , 0.9 )" onMouseout="makevisible( \''.$row['part_id'].'\' , 0.4 )" border="0" height="90" width="120" title="'.to_html ( $row['short_desc'] ).'" /></a></td>
				<td></td><td>'.date.' : '.ccmsdate ( $fuseaux , $row [ 'date' ] ).'<br />
                                '.nbr_hit.' : '.to_html ( $row['nb_click'] ).'<br />
                                '.nbr_aff.' : '.to_html ( $row['nb_aff'] ).'<br /><br />
                                '.url_site.' : <a href="index.php?mods=partenaires&amp;page=visite&amp;id='.htmlspecialchars($row['part_id']).'" title="'.htmlspecialchars($row['nom']).'" target="_blank">'.htmlspecialchars($row['url_site']).' </a><br />
                                <a href="'.to_html ( $row['rss'] ).'" title="Flux"><img src="../../themes/crazycms1.0/img/rss1.png" title="RSS" border="0" /></a> <a href="index.php?mods=partenaires&amp;page=show&amp;id='.htmlspecialchars($row['part_id']).'" title="Plus d\'info">'.lien_view.'</a> <a href="index.php?mods=partenaires&amp;page=mort&amp;id='.htmlspecialchars($row['part_id']).'" title="Signaler un lien mort">'.lien_mort.'</a> </td></tr>
                                <tr><td><br /></td></tr></table>';
                                $cat = $row['cat_id'];
}
$cont .= '';


$template->assign_block_vars('module',array('TITRE_MODULE' => $titre, 'CONTENU_MODULE'=>$cont));
?>
