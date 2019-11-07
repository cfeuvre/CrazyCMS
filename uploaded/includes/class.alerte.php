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
class Alerte{
	
		function getAlerte(){
		global $Bdd,$default_alert;
			$text_alerte ='';
			$tab_alerte = array();
			$req = $Bdd->sql('SELECT '.PT.'_alerte.id,'.PT.'_alerte.auteur,'.PT.'_alerte.mod,'.PT.'_alerte.date,'.PT.'_alerte.message FROM '.PT.'_alerte' );
			while($rep = $Bdd->get_object($req)){
				if(!file_exists('./mods/'.$rep->mod.'/alerte.php')){
					$tab_alerte[$rep->mod] = $default_alert.'dans le module '.$rep->mod.' par '.$rep->auteur.'';
				}
				else{
					$alerte = fopen('./mods/'.$rep->mod.'/alerte.php', 'r' );
					while(!feof($alerte)){
						$tab_alerte[$rep->mod] .= fgets($alerte,4096);
					}
					fclose($alerte);
					
				}
			}
			return $tab_alerte;
		}
		
		function delAlerte($id_a){
			global $Bdd;
			$bool = FALSE;
			$verif = $Bdd->sql('SELECT id FROM '.PT.'_alerte WHERE id="'.intval($id_a).'"' );
			if($Bdd->get_num_rows($verif) == 1){
				$Bdd->sql('DELETE FROM '.PT.'_alerte WHERE id="'.$id_a.'"' );
				$bool = TRUE;
			}
			return $bool;
		}
		
		function modifAlerte($contenu,$module){
			global $Bdd;
			
			if($module=='default_alerte'){
				 $Bdd->sql('UPDATE '.PT.'_parametres SET '.PT.'_parametres.valeur="'.$contenu.'" WHERE nom="default_alert"' );
			}
			else{
					$fp = fopen('./mods/'.$module.'/alerte.php' , 'w+' );
					@flock($fp,2);
					fputs($fp, $contenu);
					@flock($fp,3);
					fclose($fp);
			}
		}
		
		function messAlerte(){
		global $default_alert;
			$messalert = array();
			$var = opendir('./mods' );
			while ( ( $file = readdir($var))!=false){
				if(is_dir('./mods/'.$file)){
					if(file_exists('./mods/'.$file.'/alerte.php')){
					$contenu ='';
						$alerte = fopen('./mods/'.$file.'/alerte.php', 'r' );
						while(!feof($alerte)){
							$contenu.= fgets($alerte,4096);
						}
					$messalert[$file] = $contenu;
					fclose($alerte);
					}
				}
			}
			$messalert['default_alert'] = $default_alert;
			return $messalert;
		}
		function redir($url,$time=2500){
		$redir = '
			<script type="text/javascript">
				<!--
					function redir(){
						window.location.href = "'.$url.'";
					}
					setTimeout("redir()",'.$time.' );
				-->
			</script>';
		return $redir;
	}
		
			
		
		
}
?>