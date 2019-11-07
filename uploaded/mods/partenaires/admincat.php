<?php
/*****************************************
* Module Partenaires pour CCMS by Calfou *
*                                        *
* Page admincat.php du  8 décembre 2007  *
*****************************************/

if(!defined('CCMS')) die('' );
if($grade==4 || ereg('admin_partenaire;',$permissions)){

/*****************************************
*    Modification/Ajout des catégories   *
*****************************************/
  if(isset($_GET['modcat'])){
  //Création de la liste déroulante..
$req = $Bdd->sql('SELECT id,cat FROM '.PT.'_partenaires_cat ORDER BY cat ASC' );
       //Compte le nombre de catégories
        $aff_cat = '<select name="id_cat">';
        if($Bdd->get_num_rows($req) == '0'){
                $aff_cat .= '<option value="" selected="selected">Pas de cat&eacute;gories!</option>';
				$aff_cat .= '<option value="new">'.new_cat.'</option>';
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
        $aff_cat .= '<option value="new">'.new_cat.'</option>';
        $aff_cat .= '</select>&nbsp;';
        }
        //Affichage du bloc
        $cont ='<strong><img src="../../themes/crazycms1.0/img/puce.gif" title="puce" />'.cat_part.'&nbsp;&nbsp;<img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;page=admincat&amp;delcat">'.del_part.'</a></strong><br /><br />';
        $cont .='<form action="index.php?mods=partenaires&amp;page=admincat&amp;catok" method="post">
				<table><tr><td>'.cat_sel_to_mod.'</td><td>'.$aff_cat.'</td>
					</tr>
                                        <tr><td>'.cat_sel_to_mod1.'</td><td><input type="text" name="cat_mod" id="cat_mod"/></td>
					</tr>
					<tr><td></td><td><input type="submit" value="'.cat_mod_propose.'" /></td></tr>
					</table>
					</form>';
  }
  //Validation des modifs des catégories
  if(isset($_GET['catok'])){
        if( isset ( $_POST['id_cat'] ) AND $_POST['id_cat'] == 'new' ){
			$Bdd->sql('INSERT INTO '.PT.'_partenaires_cat VALUES ("","'.$Bdd->secure($_POST['cat_mod']).'") ' );
        }
        else if ( $_POST['id_cat'] != '' ){
			$Bdd->sql('UPDATE '.PT.'_partenaires_cat SET cat="'.$Bdd->secure($_POST['cat_mod']).'" WHERE id='.intval ( $_POST['id_cat'] ) );
	    }
		else{
			header ( 'Location: ./index.php?mods=partenaires&page=admin' );
		}
        $cont = cat_wait_validation;
		$cont .= $alerte->redir('index.php?mods=partenaires&page=admin' );
  }
/*****************************************
*    Suppréssion d'un/des catégories   *
*****************************************/
  if(isset($_GET['delcat'])){
  //Création de la liste déroulante..
$req = $Bdd->sql('SELECT id,cat FROM '.PT.'_partenaires_cat ORDER BY cat ASC' );
       //Compte le nombre de catégories
        $aff_cat = '<select name="id_cat">';
        if($Bdd->get_num_rows($req) == '0'){
                $aff_cat .= '<option value="" selected="selected">Pas de cat&eacute;gories!</option>';
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
        //Affichage du bloc
  $cont ='<strong><img src="../../themes/crazycms1.0/img/puce.gif" title="puce" /><a href="index.php?mods=partenaires&amp;page=admincat&amp;modcat">'.cat_part.'</a>&nbsp;&nbsp;
  <img src="../../themes/crazycms1.0/img/puce.gif" title="puce" />'.cat_part.'</strong><br /><br />';
  $cont .='<form action="index.php?mods=partenaires&amp;page=admincat&amp;delok" method="post">
				<table><tr><td>'.cat_sel_to_del.'</td><td>'.$aff_cat.'</td>
					</tr>
					<tr><td></td><td><input type="submit" value="'.cat_del_propose.'" /></td></tr>
					</table>
					</form>';
  }
  //Validation des modifs des catégories
  if(isset($_GET['delok'])){
        $Bdd->sql('DELETE FROM '.PT.'_partenaires_cat WHERE id='.intval ( $_POST['id_cat'] ) );
	$cont = cat_wait_validation;
	$cont .= $alerte->redir('index.php?mods=partenaires&page=admin' );
  }
/***************************************************
*     Lien de retour et affichage de la page..     *
***************************************************/
  $cont .='<br /><br /><center><a href="javascript:history.go(-1)">Retour</a></center>';
	$template->assign_block_vars('module',array('TITRE_MODULE' => '', 'CONTENU_MODULE'=>$cont));
}
?>