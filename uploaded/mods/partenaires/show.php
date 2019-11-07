<?php
/*****************************************
* Module Partenaires pour CCMS by Calfou *
*                                        *
*   Page show.php du 8 décembre 2007     *
*****************************************/
$Bdd->sql('UPDATE '.PT.'_partenaires SET nb_aff=nb_aff+1 WHERE id='.intval ( $_GET['id'] ) );
$req = $Bdd->sql('SELECT * FROM '.PT.'_partenaires WHERE id='.intval ( $_GET['id'] ) );
$row = $Bdd->get_array($req);
$cont ='<tr><td><strong><h2><img src="../../themes/crazycms1.0/img/puce.gif" title="'.cat_of_site.'" />'.htmlspecialchars($row['nom']).'</h2></strong></td>';

	$cont .= '<table><tr><td></td>
        <td></td></tr><tr><td><a href="index.php?mods=partenaires&amp;page=visite&amp;id='.htmlspecialchars($row['id']).'" title="'.htmlspecialchars($row['nom']).'" target="_blank">
        <img style="float: left;" src="http://open.thumbshots.org/image.pxf?url='.htmlspecialchars($row['url_site']).'" border="0" height="90" width="120" title="'.to_html ( $row['short_desc'] ).'" /></a></td>
				<td></td><td>'.date.' : '.ccmsdate ( $fuseaux , $row [ 'date' ] ).'<br />
                                '.nbr_hit.' : '.to_html ( $row['nb_click'] ).'<br /><br />
                                '.url_site.' : <a href="index.php?mods=partenaires&amp;page=visite&amp;id='.htmlspecialchars($row['id']).'" title="'.htmlspecialchars($row['nom']).'" target="_blank">'.htmlspecialchars($row['url_site']).' </a><br />
                                <a href="'.to_html ( $row['rss'] ).'" title="Flux"><img src="../../themes/crazycms1.0/img/rss1.png" title="RSS" border="0" /></a> <a href="index.php?mods=partenaires&amp;page=mort&amp;id='.htmlspecialchars($row['id']).'" title="Signaler un lien mort">'.lien_mort.'</a> </td></tr>
                                <tr><td><br /></td></tr></table>';

        $cont .='<br /><strong>'.description_site.' :</strong> '.to_html ( $row['description'] ).'<br /><br />';

       $cont .= '<center><a href="index.php?mods=partenaires" title="retour">Retour</a></center>';
$template->assign_block_vars('module',array('TITRE_MODULE' =>'', 'CONTENU_MODULE'=>$cont));
?>