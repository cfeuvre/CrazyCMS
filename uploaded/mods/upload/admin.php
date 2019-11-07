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
if($grade==4){
$cont = '<br />MODULE EN TRAVAUX<br />
			<a href="index.php?mods=admin">
				'.back.'
			</a>';
$titre_mod ='';
/*
	if(isset($_POST['maxfilesize'])){
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.htmlspecialchars($_POST['maxfilesize'],ENT_QUOTES).'" WHERE nom="up_moy_size"' );
		$cont .='
		<script type="text/javascript">
			window.location.href="";
		</script>';
	}
	else if(isset($_POST['maxsfilesize'])){
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.htmlspecialchars($_POST['maxsfilesize'],ENT_QUOTES).'" WHERE nom="up_max_size"' );
		$cont .='
		<script type="text/javascript">
			window.location.href="";
		</script>';
	}
	else if(isset($_POST['maxfilenbr'])){
		$Bdd->sql('UPDATE '.PT.'_parametres SET valeur="'.htmlspecialchars($_POST['maxfilenbr'],ENT_QUOTES).'" WHERE nom="up_max_nbr"' );
		$cont .='
		<script type="text/javascript">
			window.location.href="";
		</script>';
	}
	else if(isset($_POST['del'])){

		//On supprime tous les fichiers uploades
		$handle = opendir("./mods/upload/uploaded"); 
			while (($file = readdir($handle))!=false) { 
				
				if($file!=".." && $file!="." && $file!="index.php")
				{
					unlink('./mods/upload/uploaded/'.$file);
				}
			}
		closedir($handle); 
	
		//On met a zero tous les compteurs d'uploads des users
		$handle = opendir("./cache/cache/upload/"); 
			while (($file = readdir($handle))!=false) { 
				
				if($file!=".." && $file!=".")
				{
					unlink('./cache/cache/upload/'.$file);
				}
			}
		closedir($handle); 

		$cont .='
		<script type="text/javascript">
			window.location.href="";
		</script>';
		}
		else{

			$titre_mod = ADMIN_UPLOAD;

			$cont .= '
<table>
	<tr>
		<td>
			'.MAX_SIZE_FILE.'
		</td>
		<td>
			<form method="post" action="">
				<p>
				<input type="text" name="maxfilesize" value="'.$up_moy_size.'" />
				<input type="submit" value="'.valid.'" />
				</p>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			'.MAX_SIZE_FILE_2.'
		</td>
		<td>
			<form method="post" action="">
				<p>
				<input type="text" name="maxsfilesize" value="'.$up_max_size.'" />
				<input type="submit" value="'.valid.'" />
				</p>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			'.MAX_NBR_FILES.'
		</td>
		<td>
			<form method="post" action="">
				<p>
				<input type="text" name="maxfilenbr" value="'.$up_max_nbr.'" />
				<input type="submit" value="'.valid.'" />
				</p>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			'.DELETE_ALL.'
		</td>
		<td>
			<form method="post" action="">
				<p>
				<input type="hidden" name="del" />
				<input type="submit" value="'.valid.'" />
				</p>
			</form>
		</td>
	</tr>
</table>';
		
		}*/
$template->assign_block_vars('module' ,array('TITRE_MODULE' =>$titre_mod , 'CONTENU_MODULE' => $cont));
}
?>