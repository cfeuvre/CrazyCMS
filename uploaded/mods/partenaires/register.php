<?php
/*****************************************
* Module Partenaires pour CCMS by Calfou *
*                                        *
* Page register.php du  8 décembre 2007  *
*****************************************/
if(!defined('CCMS')) die('' );

	$titre = to_become_partenaire;
        $descript = default_form();
	if(!isset($_GET['ok'])){
//Création de la liste déroulante..
$req = $Bdd->sql('SELECT id,cat FROM '.PT.'_partenaires_cat ORDER BY cat ASC' );
       //Compte le nombre de catégories
        $aff_cat = '<select name="cat_site">';
        if($Bdd->get_num_rows($req) == '0'){
                $aff_cat .= '<option value="cat_site" selected="selected">Pas de cat&eacute;gories!</option>';
        }
        else {
        //Sinon on rempli la liste déroulante !
        $aff_cat .= '<option value="" selected="selected">S&eacute;lectionnez...</option>';
		$temp = '';
        while($row = $Bdd->get_array($req)){
                if ($temp != $row['cat']) {
                        $id_cat = $row['id'];
                        $nom_cat = $row['cat'];
                        $aff_cat .= '<option value="'.$id_cat.'">'.$nom_cat.'</option>';
                }
                $temp=$row['cat'];
        }
        $aff_cat .= '</select>&nbsp;';
        }



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
				<form action="index.php?mods=partenaires&amp;page=register&amp;ok" method="post">
				<table>
					<tr> '.to_html ( $cdt_partenaires ).'<br /><br /></tr><tr>
						<td>'.cat_of_site.'</td><td>'.$aff_cat.'</td>
					</tr>
                                        <tr>
						<td>'.name_of_site.'</td><td><input type="text" name="nom_site" id="nom_site"/></td>
					</tr>
					<tr>
						<td>'.url_site.'</td><td><input type="texte" name="url_site" id="url_site" onblur="verif_url(\'url_site\',\'verifi_site\')"/></td>
					</tr>
					<tr>
						<td><div id="verifi_site"></div></td>
					</tr>
					<tr>
						<td>'.url_rss.'</td><td><input type="texte" name="url_rss" id="url_rss" onblur="verif_url(\'url_rss\',\'verifi_rss\')"/></td>
					</tr>
                                        <tr>
						<td><div id="verifi_rss"></div></td>
					</tr>
					<tr>
						<td>'.short_desc_of_site.'</td><td><input type="text" name="short_desc" id="short_desc"/></td>
					</tr>
					<tr>
						<td>'.description_of_site.'</td><td>'.$descript.'</textarea></td>
					</tr>

					</table>
					</form>';
						
	}
	else{
        $contenu = $Bdd->secure($_POST['contenu']);
	$Bdd->sql('INSERT INTO '.PT.'_partenaires VALUES ("","'.$Bdd->secure($_POST['url_site']).'","'.$Bdd->secure($_POST['url_rss']).'","'.$Bdd->secure($_POST['cat_site']).'","","","'.$contenu.'","'.$Bdd->secure($_POST['nom_site']).'","0",'.time().',"'.$Bdd->secure($_POST['short_desc']).'")' );
	$cont = proposed_wait_validation;
	$cont .= $alerte->redir('index.php?mods=partenaires' );
	}
$template->assign_block_vars('module',array('TITRE_MODULE' => $titre, 'CONTENU_MODULE'=>$cont));

?>