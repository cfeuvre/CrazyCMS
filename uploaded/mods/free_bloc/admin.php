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
// En raison des risques de sécurité, ce module est réservé aux seuls administrateurs dieux!
$arr = explode(',',$god_user);
if ( $grade == 4 && in_array ( $uid , $arr ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => ADMIN_FREEBLOCS ) );
	
	$template->set_filename ( './modules/free_bloc/admin.tpl' );
	
	if ( isset ( $_GET['add'] ) ){

		if ( isset ( $_GET['free'] ) ){

			if ( isset ( $_POST [ 'contenu' ] ) ){
			
				$cont = stripslashes ( $_POST['contenu'] );
				$name = preg_replace ( '![^a-zA-Z0-9-_.]!' , '' , $_POST['title'] );
				
				if ( strlen ( $name ) < 2 ){
					$template->assign_block_vars ( 'text' , array (
					'TXT' => MORE_CHAR,
					'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;add&amp;txt',
					'BACK' => back ) );
				}
				else{
				
					$bid = 0;
					$dir = opendir ( './mods/free_bloc/' );
					while ( $file = readdir ( $dir ) ){
					
						if ( $file != '.' AND $file != '..' AND $file !='admin.php' AND $file != 'install_def.php' AND is_file ( './mods/free_bloc/'.$file ) ){
						
							$bloc = explode ( '-' , $file );
							if ( $bid < $bloc[1] )$bid = $bloc[1];
						}
					
					}
					
					closedir ( $dir );
					
					$bid++;
					
					$titre = 'bloc-'.$bid.'-free-'.$name.'.php';
					
					if ( file_exists ( './mods/free_bloc/'.$titre ) ){
						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_ALREADY_EXIST,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;add&amp;txt',
						'BACK' => back ) );					
					}
					else{		
						$file = fopen ( './mods/free_bloc/'.$titre , 'a+' );
							fputs ( $file , $cont );
						fclose ( $file );
						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_SUCCESSFULLY_CREATED,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin',
						'BACK' => back ) );
					}
				}
			}
			else{

				$minuscules = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );
			    $majuscules = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
			    $nm_aleatoire = ''; 
				for ($i = 1; $i <= 8 ; $i++){
				$type = mt_rand(0,2);
					switch ($type)
					{
						case 0:
							 $caractere = mt_rand(2,9);
										 $nm_aleatoire .= $caractere;
						break;
						
						case 1:
							 $nbre_aleatoire = mt_rand(0, 23);
										 $caractere = $majuscules[$nbre_aleatoire];
										$nm_aleatoire .= $caractere;
						break;
						
						case 2:
							 $nbre_aleatoire = mt_rand(0, 22);
										 $caractere = $minuscules[$nbre_aleatoire];
										$nm_aleatoire .= $caractere;
						break;
					}
				}
	
				$template->assign_block_vars ( 'form_free' , array(
				'ADD_BLOC' => ADD_BLOC,
				'BLOC_NAME' => BLOC_NAME,
				'BLOC_CODE' => BLOC_CODE,
				'BLOC_CODE_VALUE' => '
<?php

$contenu = \''.BLOC_CONTENT.'\';

$template->set_filename ( \'bloc.tpl{|}'.$nm_aleatoire.'\'  , FALSE);
$template->assign_block_vars( \'bloc-'.$nm_aleatoire.'\', array(\'TITRE_BLOC\' => $row[\'tbloc\'], \'CONTENU_BLOC\' => $contenu ) );

?>',
				'VALID' => valid,
				'BACK' => back ) );			
			}
		}
		else if ( isset ( $_GET['txt'] ) ){

			if ( isset ( $_POST [ 'contenu' ] ) ){
			
				$cont = $Bdd->secure ( $_POST['contenu'] );
				$name = preg_replace ( '![^a-zA-Z0-9-_.]!' , '' , $_POST['title'] );
				
				if ( strlen ( $name ) < 2 ){
					$template->assign_block_vars ( 'text' , array (
					'TXT' => MORE_CHAR,
					'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;add&amp;txt',
					'BACK' => back ) );
				}
				else{
				
					$bid = 0;					
					$dir = opendir ( './mods/free_bloc/' );
					
					while ( $file = readdir ( $dir ) ){
					
						if ( $file != '.' AND $file != '..' AND $file !='admin.php' AND $file != 'install_def.php' AND is_file ( './mods/free_bloc/'.$file ) ){
							$bloc = explode ( '-' , $file );
							if ( $bid < $bloc[1] )$bid = $bloc[1];
						}
					
					}
					
					closedir ( $dir );
					
					$bid++;
					
					$titre = 'bloc-'.$bid.'-txt-'.$name.'.php';
					
					if ( file_exists ( './mods/free_bloc/'.$titre ) ){
						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_ALREADY_EXIST,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;add&amp;txt',
						'BACK' => back ) );					
					}
					else{
					
						$minuscules = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );
					    $majuscules = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
					    $nm_aleatoire = ''; 
						for ($i = 1; $i <= 8 ; $i++){
						$type = mt_rand(0,2);
							switch ($type)
							{
								case 0:
									 $caractere = mt_rand(2,9);
												 $nm_aleatoire .= $caractere;
								break;
								
								case 1:
									 $nbre_aleatoire = mt_rand(0, 23);
												 $caractere = $majuscules[$nbre_aleatoire];
												$nm_aleatoire .= $caractere;
								break;
								
								case 2:
									 $nbre_aleatoire = mt_rand(0, 22);
												 $caractere = $minuscules[$nbre_aleatoire];
												$nm_aleatoire .= $caractere;
								break;
							}
						}
						
						$file = fopen ( './mods/free_bloc/'.$titre , 'a+' );
							fputs ( $file , '<?php
							$template->set_filename ( \'bloc.tpl{|}'.$nm_aleatoire.'\'  , FALSE);
							$template->assign_block_vars( \'bloc-'.$nm_aleatoire.'\', array(\'TITRE_BLOC\' => $row[\'tbloc\'], \'CONTENU_BLOC\' => to_html ( "'.stripslashes ( $cont ).'" ) ) );
							?>' );
						fclose ( $file );

						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_SUCCESSFULLY_CREATED,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin',
						'BACK' => back ) );
					}
				}
			}
			else{
				$template->assign_block_vars ( 'form_txt' , array (
				'TXT' => ADD_BLOC,
				'FORM' => default_form ( TRUE ),
				'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;add',
				'BACK' => back ) );
			}
		}
		else{
			// Choix entre Bloc Txt ou Bloc free
			$template->assign_block_vars ( 'choix' , array (
			'CHOOSE_BLOC_TYPE' => CHOOSE_BLOC_TYPE,
			'BLOC_CODE' => BLOC_CODE,
			'BLOC_TXT' => BLOC_TXT,
			'DIFFERENCE_BETWEEN_CODE_AND_TXT' => DIFFERENCE_BETWEEN_CODE_AND_TXT,
			'DIFFERENCE_TXT' => nl2br ( DIFFERENCE_TXT ),
			'BACK' => back ) );
		}
	}
	else if ( isset ( $_GET['edit'] ) ){
		if ( isset ( $_GET['free'] ) ){

			if ( isset ( $_POST [ 'contenu' ] ) ){
			
				$cont = stripslashes ( $_POST['contenu'] );
				$name = preg_replace ( '![^a-zA-Z0-9-_.]!' , '' , $_POST['title'] );
				
				if ( strlen ( $name ) < 2 ){
					$template->assign_block_vars ( 'text' , array (
					'TXT' => MORE_CHAR,
					'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;edit='.intval ( $_GET['edit'] ).'&amp;free',
					'BACK' => back ) );
				}
				else{
				
					$bid = intval ( $_GET['edit'] );
					
					$titre = 'bloc-'.$bid.'-free-'.$name.'.php';
					$last_titre = 'bloc-'.$bid.'-free-'.base64_decode ( $_GET['name'] );
					
					if ( file_exists ( './mods/free_bloc/'.$titre ) AND $name != substr ( base64_decode ( $_GET['name'] ), 0 , strlen ( base64_decode ( $_GET['name'] ) ) - 4 ) ){
						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_ALREADY_EXIST,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;edit='.intval ( $_GET['edit'] ).'&amp;free',
						'BACK' => back ) );
					}
					else{
					
						if ( $name != substr ( base64_decode ( $_GET['name'] ), 0 , strlen ( base64_decode ( $_GET['name'] ) ) - 4 ) ){
							unlink ( './mods/free_bloc/'.$last_titre );
							// On met a jour liste bloc
							$Bdd->sql ( 'UPDATE '.PT.'_blocs SET tbloc="'.$name.'" WHERE tbloc="'.substr ( $Bdd->secure ( base64_decode ( $_GET['name'] ) ) , 0 , strlen (  $Bdd->secure ( base64_decode ( $_GET['name'] ) ) ) - 4 ).'"' );
							$Bdd->delete_cached_data ( 'bloc' );
						}
						
						$cont = str_replace ( '\r\n' , "\r" , $cont );
						
						$file = fopen ( './mods/free_bloc/'.$titre , 'w+' );
							fputs ( $file , html_entity_decode ( $cont ) );
						fclose ( $file );
						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_SUCCESSFULLY_MODIFIED,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin',
						'BACK' => back ) );
					}
				}
			
			}
			else{
			
				$file = './mods/free_bloc/bloc-'.intval ( $_GET['edit'] ).'-free-'.base64_decode ( $_GET['name'] );
				$cont = '';
				$f = fopen ( $file , 'r' );
				
				while ( !feof ( $f ) ){
					$cont .= fgets ( $f , 4096 );
				}
				fclose ( $f );
				
				$titre = substr ( base64_decode ( $_GET['name'] ) , 0 , strlen ( base64_decode ( $_GET['name'] ) ) - 4 );
				$template->assign_block_vars ( 'form_free' , array(
				'ADD_BLOC' => MODIFY_BLOC,
				'BLOC_NAME' => BLOC_NAME,
				'BLOC_NAME_VALUE' => $titre,
				'BLOC_CODE' => BLOC_CODE,
				'BLOC_CODE_VALUE' => $cont,
				'VALID' => valid,
				'BACK' => back ) );
			}
		
		}
		else{
		
			if ( isset ( $_POST [ 'contenu' ] ) ){
			
				$cont = $Bdd->secure ( $_POST['contenu'] );
				$name = preg_replace ( '![^a-zA-Z0-9-_.]!' , '' , $_POST['title'] );
				
				if ( strlen ( $name ) < 2 ){
					$template->assign_block_vars ( 'text' , array (
					'TXT' => MORE_CHAR,
					'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;edit='.intval ( $_GET['edit'] ).'&amp;txt',
					'BACK' => back ) );
				}
				else{
				
					$bid = intval ( $_GET['edit'] );
					
					$titre = 'bloc-'.$bid.'-txt-'.$name.'.php';
					$last_titre = 'bloc-'.$bid.'-txt-'.base64_decode ( $_GET['name'] );
					
					if ( file_exists ( './mods/free_bloc/'.$titre ) AND $name != substr ( base64_decode ( $_GET['name'] ), 0 , strlen ( base64_decode ( $_GET['name'] ) ) - 4 ) ){
						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_ALREADY_EXIST,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin&amp;edit='.intval ( $_GET['edit'] ).'&amp;txt',
						'BACK' => back ) );					
					}
					else{
					
						$ct = '';
						$f = fopen ( './mods/free_bloc/'.$last_titre , 'r' );
						while ( !feof ( $f ) ){
							$ct .= fgets ( $f , 4096 );
						}
						fclose ( $f );
						$ct = htmlspecialchars ( str_replace ( '\r\n' , '<br />' , $ct ) );
						$nm = preg_replace ( '!(.+)\$template-&gt;set_filename \( \'bloc.tpl\{\|\}(.{0,10})\'(.+)!s' , '$2' , $ct );
						if ( $name != substr ( base64_decode ( $_GET['name'] ), 0 , strlen ( base64_decode ( $_GET['name'] ) ) - 4 ) ){
							unlink ( './mods/free_bloc/'.$last_titre );
							// On met a jour liste bloc
							$Bdd->sql ( 'UPDATE '.PT.'_blocs SET tbloc="'.$name.'" WHERE tbloc="'.substr ( $Bdd->secure ( base64_decode ( $_GET['name'] ) ) , 0 , strlen (  $Bdd->secure ( base64_decode ( $_GET['name'] ) ) ) - 4 ).'"' );
							$Bdd->delete_cached_data ( 'bloc' );
						}

					$file = fopen ( './mods/free_bloc/'.$titre , 'w+' );
						fputs ( $file , '<?php
						$template->set_filename ( \'bloc.tpl{|}'.$nm.'\'  , FALSE);
						$template->assign_block_vars( \'bloc-'.$nm.'\', array(\'TITRE_BLOC\' => $row[\'tbloc\'], \'CONTENU_BLOC\' => to_html ( "'.stripslashes ( $cont ).'" ) ) );
						?>' );
						fclose ( $file );
						$template->assign_block_vars ( 'text' , array (
						'TXT' => BLOC_SUCCESSFULLY_MODIFIED,
						'URL' => 'index.php?mods=free_bloc&amp;page=admin',
						'BACK' => back ) );				
					}
				}
			}
			else{
			
				$file = './mods/free_bloc/bloc-'.intval ( $_GET['edit'] ).'-txt-'.base64_decode ( $_GET['name'] );
				
				$cont = '';
				
				$f = fopen ( $file , 'r' );
				
				while ( !feof ( $f ) ){
					$cont .= fgets ( $f , 4096 );
				}
				
				fclose ( $f );
				$cont = htmlspecialchars ( str_replace ( '\r\n' , '<br />' , $cont ) );
				$tot = preg_replace ( '!(.+)\$template-&gt;assign_block_vars\( \'bloc\-(.+)\', array\(\'TITRE_BLOC\' =&gt; \$row\[\'tbloc\'\], \'CONTENU_BLOC\' =&gt; to_html \( &quot;(.+)&quot; \) \) \);(.+)!s' , '$3' , $cont );
				
				$cont = to_html ( stripslashes ( $tot ) );

				$titre = htmlspecialchars ( substr ( base64_decode ( $_GET['name'] ) , 0 , strlen ( base64_decode ( $_GET['name'] ) ) - 4 ) );
			
				$template->assign_block_vars ( 'form_txt' , array (
				'TXT' => MODIFY_BLOC,
				'FORM' => default_form ( TRUE , $titre , $cont ),
				'URL' => 'index.php?mods=free_bloc&amp;page=admin',
				'BACK' => back ) );
			}
		}
	}
	else if ( isset ( $_GET['delete'] ) ){
		$file = './mods/free_bloc/bloc-'.intval ( $_GET['delete'] ).'-'.( ( isset ( $_GET['txt'] ) ) ? ('txt') : ('free') ).'-'.base64_decode ( $_GET['name'] );
		unlink ( $file );
		$template->assign_block_vars ( 'text' , array (
		'TXT' => BLOC_SUCCESSFULLY_DELETED,
		'URL' => 'index.php?mods=free_bloc&amp;page=admin',
		'BACK' => back ) );
	}
	else{

		// Affichage blocs + Lien pr ajouter
		$template->assign_block_vars ( 'index' , array (
		'BLOCS_DISPO' => BLOCS_DISPO,
		'BLOC_NAME' => BLOC_NAME,
		'BLOC_TYPE' => BLOC_TYPE,
		'ADD_BLOC' => ADD_BLOC,
		'BACK' => back ) );
		
		$a = TRUE;
		
		$dir = opendir ( './mods/free_bloc/' );
		
		while ( $file = readdir ( $dir ) ){
			if ( $file != '.' AND $file != '..' AND $file !='admin.php' AND $file != 'install_def.php' AND is_file ( './mods/free_bloc/'.$file ) ){
				$bloc = explode ( '-' , $file );
				$a = FALSE;	
				$template->assign_block_vars ( 'index.bl' , array (
				'NAME' => ( substr ( $bloc[3] , 0 , strlen ( $bloc[3]) - 4  ) ),
				'TYPE' => ( ( $bloc[2] == 'txt' ) ? ( BLOC_TXT ) : ( BLOC_CODE ) ),
				'NM' => $bloc[1],
				'EXT' => ( ( $bloc[2] == 'txt' ) ? ( 'txt' ) : ( 'free' ) ),
				'NNM' => base64_encode ( $bloc[3] ),
				'EDIT' => modify,
				'DELETE' => delete
				) );
			}
		}
		
		closedir ( $dir );
		
		if ( $a === TRUE ){
			$template->assign_block_vars ( 'index.none' , array ( 'TXT' => NONE_BLOCS ) );
		
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>