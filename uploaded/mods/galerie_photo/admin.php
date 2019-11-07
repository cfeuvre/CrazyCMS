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
if(!defined('CCMS'))die('' );

// On verifie que l'utilisateur a bien le droit d'acceder a l'administration des News
$grades = explode ( ',' , $galerie_photo_grade_admin );
if($grade==4 OR in_array ( $grade , $grades , TRUE ) ){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/galerie_photo/admin.tpl' );

	if(isset($_GET['add'])){

		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => add_gallery ) );

		if(isset($_POST['titre']) AND isset($_POST['contenu'])){

			$titre = htmlspecialchars( preg_replace ( '![^a-zA-Z0-9]!' , '_' ,  $_POST['titre'],ENT_QUOTES ) );
			$contenu = $Bdd->secure ( $_POST['contenu'] );

			if(!file_exists('./mods/galerie_photo/galeries/'.$titre)){

				@mkdir ("./mods/galerie_photo/galeries/$titre", 0777);

				$file2 = fopen("./mods/galerie_photo/galeries/$titre/description.txt",'a+' );
				fputs($file2,$contenu);
				fclose($file2);

				$template->assign_block_vars ( 'text' , array (
				'TXT' => gallery_successfully_added,
				'URL' => 'index.php?mods=galerie_photo&amp;page=admin',
				'BACK' => back ) );
			}
			else{
				$template->assign_block_vars ( 'text' , array (
				'TXT' => gallery_exist,
				'URL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;add',
				'BACK' => back ) );
			}
		}
		else{
			$template->assign_block_vars ( 'form_cat' , array (
			'TITRE' => title,
			'DESCRIPTION' => description,
			'FORM' => default_form ( FALSE , NULL , NULL , 100) ) );
		}
	}
	elseif(isset($_GET['modif'])){

		if(isset($_GET['del'])){
		
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => deleting_galerie ) );
			$template->assign_block_vars ( 'del' , array() );
			
			$handle = @opendir("./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES)."/");
			while (($file = @readdir($handle))!=false) {
						
				if($file!=".." AND $file!="."){	

					if ( @unlink ( "./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES)."/".$file ) == false ){
						$template->assign_block_vars ( 'del.txt' , array ( 'TXT' => $file.' '.peut_po_deleted ) );
					}
					else{
						$template->assign_block_vars ( 'del.txt' , array ( 'TXT' => $file.' '.successfully_deleted ) );
					}

				}
			}
			@closedir($handle);
				
			if(@rmdir("./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES)."/")==true){
				$template->assign_block_vars ( 'bloc.conc' , array (
				'TXT' => gallery_deleted_successfully,
				'URL' => 'index.php?mods=galerie_photo&amp;page=admin',
				'BACK' => back ) );

				$Bdd->sql('DELETE FROM '.PT.'_gallery WHERE galerie="'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'"' );
			}
			else{
				$template->assign_block_vars ( 'bloc.conc' , array (
				'TXT' => gallery_not_deleted_successfully,
				'URL' => 'index.php?mods=galerie_photo&amp;page=admin',
				'BACK' => back ) );
			}
		}
		else{

			if(isset($_POST['new_name'])){
			
				$new_titre = htmlspecialchars($_POST['new_name'],ENT_QUOTES);

				if(!file_exists('./mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES))){		
					$template->assign_block_vars ( 'text' , array (
					'TXT' => old_gal_not_exist,
					'URL' => 'index.php?mods=galerie_photo&page=admin&modif='.htmlspecialchars ( $_GET['modif'] ),
					'BACK' => back ) );
				}
				else{
					if(file_exists('./mods/galerie_photo/galeries/'.$new_titre)){
						$template->assign_block_vars ( 'text' , array (
						'TXT' => gallery_exist,
						'URL' => 'index.php?mods=galerie_photo&page=admin&modif='.htmlspecialchars ( $_GET['modif'] ),
						'BACK' => back ) );
					}
					else{
						$Bdd->sql ( 'UPDATE '.PT.'_gallery SET galerie = "'.$new_titre.'" WHERE galerie = "'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'"' ) ;
						@rename('./mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES), './mods/galerie_photo/galeries/'.$new_titre);
						
						$template->assign_block_vars ( 'text' , array (
						'TXT' => GALLERY_SUCCESSFULLY_UPDATED,
						'URL' => 'index.php?mods=galerie_photo&page=admin&modif='.base64_encode ( $new_titre ),
						'BACK' => back ) );
					}
				}
			}
			elseif(isset($_POST['contenu']) AND !isset ( $_GET['picture'] ) ){

				$file2 = fopen("./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES)."/description.txt",'w' );
				fputs($file2, stripslashes ( $_POST['contenu'] ));
				fclose($file2);

				$template->assign_block_vars ( 'text' , array (
				'TXT' => gallery_updated,
				'URL' => 'index.php?mods=galerie_photo&page=admin&modif='.htmlspecialchars ( $_GET['modif'] ),
				'BACK' => back ) );
			}
			elseif(isset($_GET['picture'])){

				if(isset($_GET['delpict'])){

					if(!unlink('./mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'/'.htmlspecialchars(base64_decode($_GET['picture']),ENT_QUOTES))){
						$template->assign_block_vars ( 'text' , array (
						'TXT' => cant_unlink_picture,
						'URL' => 'index.php?mods=galerie_photo&page=admin&modif='.htmlspecialchars ( $_GET['modif'] ),
						'BACK' => back ) );
					}
					else{
						$template->assign_block_vars ( 'text' , array (
						'TXT' => PICTURE_SUCCESSFULLY_DELETED,
						'URL' => 'index.php?mods=galerie_photo&page=admin&modif='.htmlspecialchars ( $_GET['modif'] ),
						'BACK' => back ) );							
						$Bdd->sql('DELETE FROM '.PT.'_gallery WHERE nom="'.htmlspecialchars(base64_decode($_GET['picture']),ENT_QUOTES).'" AND galerie="'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'"' );
					}

				}
				else{

					$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => modif_image.' : '.htmlspecialchars(base64_decode ( $_GET['picture'] ) , ENT_QUOTES ) ) );

					$template->assign_block_vars ( 'picture' , array ( 'SRC' => './mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'/'.htmlspecialchars(base64_decode($_GET['picture']),ENT_QUOTES) ) );

					if(isset($_POST['contenu'])){
						$Bdd->sql('UPDATE '.PT.'_gallery SET description="'.$Bdd->secure($_POST['contenu']).'" WHERE nom="'.htmlspecialchars(base64_decode($_GET['picture']),ENT_QUOTES).'" AND galerie="'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'"' );
					}

					$query = $Bdd->sql('SELECT nom,description FROM '.PT.'_gallery WHERE nom="'.htmlspecialchars(base64_decode($_GET['picture']),ENT_QUOTES).'"  AND galerie="'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'"' );

					if($Bdd->get_num_rows($query) == 0){
						$template->assign_block_vars ( 'picture.index' , array (
						'TXT' => this_picture_indexation,
						'URL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;index='.$_GET['picture'].'&amp;galerie='.$_GET['modif'].'&amp;pict='.$_GET['modif'],
						'INDEX' => index_photo ) );
					}
					else{
						$sql2 = $Bdd->get_array($query);
						$template->assign_block_vars ( ' picture.form' , array (
						'DESCRIPTION' => description,
						'FORM' => default_form ( FALSE , NULL , to_html ( $sql2['description'] ) , 100),
						'DEL_URL' => htmlspecialchars($HTTP_SERVER_VARS['QUERY_STRING'],ENT_QUOTES).'&delpict',
						'DEL' => delete_picture,
						'BACKURL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;modif='.htmlspecialchars ( $_GET['modif'] ),
						'BACK' => back ) );
					}
				}
			}
			else{

				if ( file_exists ( "./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES)."/description.txt" ) ){
					
					$files = fopen("./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES)."/description.txt",'a+' );

					$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => manage_gallery.' : '.htmlspecialchars(base64_decode ( $_GET['modif'] ) , ENT_QUOTES ) ) );

					$contenu = '';
					while (!feof($files)) {
						$contenu .= stripslashes(fgets($files, 4096));
					}
					
					fclose($files);
					
					$template->assign_block_vars ( 'gallery' , array (
					'JS' => '
					<script type="text/javascript">
						<!--

							function del(name){
								var conf = confirm("'.confirm_deleting_pic.' : '.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'");
								if(conf==true){
									window.location.href = "./index.php?mods=galerie_photo&page=admin&modif='.$_GET['modif'].'&del";
								}
								else{
									window.location.href = "./index.php?mods=galerie_photo&page=admin&modif='.$_GET['modif'].'";
								}
							}
						-->
					</script>',
					'RENAME' => rename_galerie,
					'NAME_VALUE' => htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES),
					'VALID' => valid,
					'RENAME_DEF_GALLERY' => rename_def_galerie,
					'FORM' => default_form ( FALSE , NULL , to_html ( $contenu ) , 100),
					'UPURL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;upload='.$_GET['modif'],
					'UPLOAD_FOR_GALLERY' => upload_for_gallery,
					'JS_MODIF' => $_GET['modif'],
					'DELETE_GALLERY' => delete_gallery,
					'BACKURL' => 'index.php?mods=galerie_photo&amp;page=admin',
					'BACK' => back ) );

					$handle = opendir("./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES)."/");
						while (($file = readdir($handle))!=false) {
						
							if($file!=".." AND $file!=".")
							{
								$longueur = strlen($file);
								$type = substr($file,$longueur-3,$longueur);
								$types = substr($file,$longueur-4,$longueur);
								
								if( strtolower ( $type ) == 'png' OR  strtolower ( $types ) == 'jpeg' OR strtolower ( $type ) == 'jpg' OR  strtolower ( $type ) == 'gif'){
								
									$imz = getimagesize('./mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'/'.$file);
									$new_size = resize ( 130 , 100 , $imz[0] , $imz[1] );
									
									$template->assign_block_vars ( 'gallery.tof' , array (
									'URL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;modif='.$_GET['modif'].'&amp;picture='.base64_encode($file),
									'SRC' => './mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['modif']),ENT_QUOTES).'/'.$file,
									'WIDTH' => $new_size[0],
									'HEIGHT' => $new_size[1]) );
								}
							}
						}
					closedir($handle);	
				}
				else{
					$template->assign_block_vars ( 'text' , array (
					'TXT' => GALLERY_DOESNT_EXIST,
					'URL' => 'index.php?mods=galerie_photo',
					'BACK' => back ) );
				}

			}
		}

	}
	elseif(isset($_GET['index'])){
		$Bdd->sql('INSERT INTO '.PT.'_gallery VALUES("","'.$Bdd->secure ( base64_decode ( $_GET['index'] ) ).'","","","'.$Bdd->secure ( base64_decode ( $_GET['galerie']) ).'")' );
		if(isset($_GET['pict'])){
			$urlo = 'index.php?mods=galerie_photo&page=admin&modif='.htmlspecialchars($_GET['pict'],ENT_QUOTES).'&picture='.$_GET['index'];
		}
		else{
			$urlo = "index.php?mods=galerie_photo&page=admin";
		}
		$template->assign_block_vars ( 'text' , array (
		'TXT' => '',
		'URL' => $urlo,
		'BACK' => clik_to_redirect ) );	
	}
	elseif(isset($_GET['upload'])){

		if(isset($_FILES['userfile']['tmp_name'])){

			//Emplacement actuel fichier
			$userfile = htmlspecialchars($_FILES['userfile']['tmp_name'],ENT_QUOTES);
			//Nom du fichier
			$userfile_name = htmlspecialchars($_FILES['userfile']['name'],ENT_QUOTES);
			//Taille du fichier
			$userfile_size = htmlspecialchars($_FILES['userfile']['size'],ENT_QUOTES);
			//Type du fichier
			$userfile_type = htmlspecialchars($_FILES['userfile']['type'],ENT_QUOTES);
			//Controle des erreurs de transfert
			$userfile_error = htmlspecialchars($_FILES['userfile']['error'],ENT_QUOTES);

			//On regarde si l'envoi a retourne une erreur
			if ($userfile_error > 0){
			
				switch($userfile_error){
				case 1:
					$template->assign_block_vars ( 'text' , array (
					'TXT' => erreur_transfert.' : '.taille_max,
					'URL' => 'index.php?mods=galerie_photo&page=admin&upload='.$_GET['upload'],
					'BACK' => back ) );
				break ;
				case 2:
					$template->assign_block_vars ( 'text' , array (
					'TXT' => erreur_transfert.' : '.taille_max,
					'URL' => 'index.php?mods=galerie_photo&page=admin&upload='.$_GET['upload'],
					'BACK' => back ) );

				break ;
				case 3:
					$template->assign_block_vars ( 'text' , array (
					'TXT' => erreur_transfert.' : '.file_not_completely_send,
					'URL' => 'index.php?mods=galerie_photo&page=admin&upload='.$_GET['upload'],
					'BACK' => back ) );
				break ;
				case 4:
					$template->assign_block_vars ( 'text' , array (
					'TXT' => erreur_transfert.' : '.no_file_uploaded,
					'URL' => 'index.php?mods=galerie_photo&page=admin&upload='.$_GET['upload'],
					'BACK' => back ) );
				break ;
				}
				exit;

			}

			// On verifie que le type du fichier est valide !

			$long = strlen($userfile_name);
			$type = substr($userfile_name,$long-4,$long);
			$types = substr($userfile_name,$long-5,$long);
			if( strtolower ( $type ) !='.jpg' AND strtolower ( $type )!='.png' AND strtolower ( $type )!='.gif' AND strtolower ( $type )!='.bmp' AND strtolower ( $types )!='.jpeg'){
				
				$template->assign_block_vars ( 'text' , array (
				'TXT' => type_erreur,
				'URL' => 'index.php?mods=galerie_photo&page=admin&upload='.$_GET['upload'],
				'BACK' => back ) );
					
			}
			else{

				//On verifie qu'il nexiste pas une meme image dans les galeries
				$handle = opendir("./mods/galerie_photo/galeries/");

				while (($file = readdir($handle))!=false ){
					clearstatcache();
					if($file!=".." AND $file!="." AND is_dir('./mods/galerie_photo/galeries/'.$file)){
						$handle2 = opendir("./mods/galerie_photo/galeries/".$file."/");
							while (($file2 = readdir($handle2))!=false){
								
								if($file2!=".." AND $file2!="." AND $file2!="description.txt" AND $file2!="Thumbs.db"){
									if($file2==$userfile_name){
										$new = mt_rand(10000000000,99999999999999);
										
										$long = strlen($file2);
										$type = substr($file2,$long-4,$long);
										
										$userfile_name = $new.$type;
										clearstatcache();
										$handlez = opendir("./mods/galerie_photo/galeries/");
										
										while (($filez = readdir($handlez))!=false ) {
											clearstatcache();
											if($filez!=".." AND $filez!="." AND is_dir('./mods/galerie_photo/galeries/'.$filez)){
											
												$handlez2 = opendir("./mods/galerie_photo/galeries/".$filez."/");
												while (($filez2 = readdir($handlez2))!=false) {
								
													if($filez2!=".." AND $filez2!="." AND $filez2!="description.txt" ){
														if($filez2==$userfile_name){
															$new = mt_rand(1000000000,9999999999999999999);
															$long = strlen($file2);
															$type = substr($file2,$long-4,$long);
															$userfile_name = $new.$type;
														}
													}
												}
												closedir($handlez2);
											}
										}
										closedir($handlez);
									}
								}
							}	
						closedir($handle2);
					}
				}
				closedir($handle);

				// On place l'image dans son dossier definitif
				$upfile = './mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['upload']),ENT_QUOTES).'/'.$userfile_name;
				if (!move_uploaded_file($userfile, $upfile)){

					$template->assign_block_vars ( 'text' , array (
					'TXT' => peu_po_transfere,
					'URL' => 'index.php?mods=galerie_photo&page=admin&upload='.$_GET['upload'],
					'BACK' => back ) );

					exit;
				}
				else{
					$template->assign_block_vars ( 'text' , array (
					'TXT' => transfered_successfully,
					'URL' => 'index.php?mods=galerie_photo&page=admin&index='.base64_encode($userfile_name).'&pict='.$_GET['upload'].'&galerie='.$_GET['upload'],
					'BACK' => back ) );
				}

			}
		}
		else{
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => send_picture ) );
			$template->assign_block_vars ( 'upload_form' , array ( 
			'SEND_MORE_PICTURES' => SEND_MORE_PICTURES,
			'HOW_TO_SEND_MORE_PICTURES' => nl2br ( HOW_TO_SEND_MORE_PICTURES ),
			'URL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;modif='.htmlspecialchars ( $_GET['upload'] ),
			'UPLOAD_FILE' => send_picture,
			'BACK' => back ) );
		}
	}
	else{

		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => admin_gallery ) );

		$template->assign_block_vars ( 'index' , array (
		'GALERIE_WHO_EXISTS' => galerie_who_exists,
		'ADD_GALLERY' => add_gallery,
		'BACK' => back ) );

		$b = 0;
		$handle = opendir("./mods/galerie_photo/galeries/");
		while (($file = readdir())!=false) {
			clearstatcache();
			if($file!=".." AND $file!="." AND is_dir('./mods/galerie_photo/galeries/'.$file))
				{
					$b++;
					$template->assign_block_vars ( 'index.gal' , array (
					'URL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;modif='.base64_encode($file),
					'FILE' => $file ) );
				}
			}
		closedir($handle);

		if($b==0)
			$template->assign_block_vars ( 'index.ngal' , array ( 'TXT' => no_gallery ) );

		$secu = 0;
		$handle = opendir("./mods/galerie_photo/galeries/");
		while (($file = readdir($handle))!=false) {
			clearstatcache();
			if($file!=".." AND $file!="." AND is_dir('./mods/galerie_photo/galeries/'.$file))
				{

					$handle2 = opendir("./mods/galerie_photo/galeries/".$file."/");
						while (($file2 = readdir($handle2))!=false) {
						
							if($file2!=".." AND $file2!="." AND $file2!="description.txt" AND $file2!="Thumbs.db")
							{
								$query = $Bdd->sql('SELECT nom FROM '.PT.'_gallery WHERE nom="'.$file2.'" AND galerie="'.htmlspecialchars($file,ENT_QUOTES).'"' );
								if($Bdd->get_num_rows($query)==0){
									$secu ++;
									
									if($secu == 1)
										$template->assign_block_vars ( 'index.indexation' , array ( 'TXT' => picture_indexation ) );

									$template->assign_block_vars ( 'index.ind' , array (
									'URL' => 'index.php?mods=galerie_photo&amp;page=admin&amp;index='.base64_encode($file2).'&amp;galerie='.base64_encode ( $file ),
									'FILE' => $file2 ) );
								}
							}
						}	
						closedir($handle2);
					}
				}
		closedir($handle);

		// Mod pour supprimer les doublons de la Base de donnee

		$query = $Bdd->sql('SELECT nom,id FROM '.PT.'_gallery' );
		$complete = "";
		//On fait une boucle qui va enregistrer le nom de toutes les images dans la variable complete, si une image apparait deux fois, la ligne de la base est supprime

		while($sql = $Bdd->get_array($query))
		{
			if(!ereg($sql['nom'],$complete)){
				$complete .= $sql['nom'];
			}
			else{
				$Bdd->sql('DELETE FROM '.PT.'_gallery WHERE id="'.$sql['id'].'"' );
			}
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