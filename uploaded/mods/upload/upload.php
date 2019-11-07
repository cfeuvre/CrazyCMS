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
echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<title></title>
</head>

<body>';

	include('../../includes/config.php' );
	
		// On importe les parametres
		$req_param=$Bdd->sql('SELECT nom,valeur FROM '.PT.'_parametres' );
		while ($result_param =$Bdd->get_object($req_param)){
			${$result_param->nom} = $result_param->valeur;				 
		}
	include('../../mods/upload/langues/'.$default_langage.'.php' );

//Parametres :
$req_param= $Bdd->sql('SELECT nom,valeur FROM '.PT.'_parametres' );
while ($result_param = $Bdd->get_object($req_param)){
	${$result_param->nom} = $result_param->valeur;
}

	if( isset($_POST['upload']) )
	{
		$content_dir = './uploaded/';

		$tmp_file = htmlspecialchars($_FILES['fichier']['tmp_name'],ENT_QUOTES);

		if( !is_uploaded_file($tmp_file) )
		{
			$error = UNFOUNDABLE_FILE;
			echo '
			<script type="text/javascript">
				window.location.href="upload.php?error='.$error.'";
			</script>';
			exit;
	    }

		$type_file = htmlspecialchars($_FILES['fichier']['type'],ENT_QUOTES);
		$name_file = htmlspecialchars($_FILES['fichier']['name'],ENT_QUOTES);
		$userfile_error = htmlspecialchars($_FILES['fichier']['error'],ENT_QUOTES);

		//Verification de l'extension
		$ext_min = substr($name_file,-3);
		$ext_max = substr($name_file,-4);

		//Verification du type
		$format = false;
		$type = array('jpg' , 'jpeg' , 'gif', 'png', 'zip', 'rar', 'swf' );
		foreach ($type as $var){
			if(strstr($type_file,$var)){
				if($var == 'jpg')$var2 = 'jpeg';
				if($var == 'jpeg')$var2 = 'jpg';
				//echo 'VAR : '.$var.'<br />VAR 2 :'.$var2.'<br />TYPE='.$ext_min.' || '.$ext_max;
				if($ext_min == $var || $ext_max == $var || $ext_min == $var2 || $ext_max == $var2){
					$format = true;
				}
			}
		}

		if($format == false){
				$error = BAD_EXTENSION;
				echo '
				<script type="text/javascript">
					window.location.href="upload.php?error='.$error.'";
				</script>';
				exit;
		}

		// On renomme le fichier et on fait une boucle pour le renommer jusqu'a ce qu'aucun autre fichier n'ait le meme nom.
		$name_file = (time()/mt_rand(0,65)+mt_rand(0,10)).'.'.$ext_max;
		while(file_exists('./uploaded/'.$name_file)){
			$name_file = (time()/mt_rand(0,65)+mt_rand(0,10)).'.'.$ext_max;
		}

		//On copie le fichier dans le dossier de destination
		if(!move_uploaded_file($tmp_file, $content_dir . $name_file) )
		{
			echo $name_file;
			$error = MOVING_ERROR;

			echo '
			<script type="text/javascript">
				window.location.href="upload.php?error='.$error.'";
			</script>';
			exit;
		}
	
		//On regarde si le serveur a retourné une erreur
		if ($userfile_error > 0){
			echo UPLOAD_ERROR.' : ';
			switch($userfile_error){
				case 1:
					$error = WEIGHT_SERVER_EXCEDED;
				break ;
				case 2:
					$error = WEIGHT_ADMIN_EXCEDED;
				break ;
				case 3:
					$error = UPLOADING_ERROR;
				break ;
				case 4:
					$error = NONE_FILE;
				break ;
			}

			echo '
			<script type="text/javascript">
				window.location.href="upload.php?error='.$error.'";
			</script>';
			exit;
		}
			if(isset($_GET['avatarz'])){
				echo '
				<script type="text/javascript">
					parent.document.getElementById(\'input_extern\').value = "./mods/upload/uploaded/'.$name_file.'";
					parent.update_img(\'input_extern\' );
					parent.lch_rad(\'raddeu\' );
				</script>
				<a href="upload.php?avatarz">'.SEND_NEW_FILE.'</a><br />'.UPLOADED;
			}
			else{

			echo '<a href="./uploaded/'.$name_file.'">'.FILES_URL.'</a><br /><input type="text" onclick="this.select();" value="[img]./mods/upload/uploaded/'.$name_file.'[/img]" '.( ($ext_max == '.rar' || $ext_max == '.zip') ? ('disabled="true" style="background-color:#999999;"') : ('') ).'/><br /><br />
			<a href="upload.php">'.SEND_NEW_FILE.'</a>';
		}
	}
	else{
		echo '<u>'.SEND_FILES.'</u>';
		if(isset($_GET['error'])){
			echo ' : <font color="red">'.htmlspecialchars($_GET['error'],ENT_QUOTES).'</font>';
		}

		echo'
		<form method="post" enctype="multipart/form-data" action="">
			<p>
				<input type="file" name="fichier" size="30" />
				<input type="hidden" name="MAX_FILE_SIZE" value="'.$up_moy_size.'" />
				<input type="submit" name="upload" value="Uploader" />
			</p>
		</form>';

	}

echo'</body>
</html>';

?>
