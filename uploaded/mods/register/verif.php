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

include('../../includes/config.php' );
// On importe les parametres

$req_param=$Bdd->sql('SELECT nom,valeur FROM '.PT.'_parametres' );
while ($result_param = mysql_fetch_object($req_param)){
	${$result_param->nom} = $result_param->valeur;				 
}

include('./langues/'.$default_langage.'.php' );

if(isset($_GET['email'])){

	//Variable de continuation pour indiquer si le formulaire est correct ou non ;)
	$continue = false;

	//On verifie tout d'abord si l'adresse email est valide
	if (!ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $Bdd->secure($_POST['e-mail']))){
		echo  '<font color="red">'.email_not_valid.'</font><br />';
		$continue = false;
	}
	else{
		echo  '<font color="green">'.email_valid.'</font><br />';
		$continue = true;
		
		//Puis on regarde si l'adresse email n'est pas deja utilise
		$query = $Bdd->sql('SELECT id FROM '.PT.'_users WHERE email="'.$Bdd->secure($_POST['e-mail']).'"' );
		if($Bdd->get_num_rows($query)==0){
			echo  '<font color="green">'.email_non_utilise.'</font><br />';
			if($continue === true){
				$continue = true;
			}
		}
		else{
			echo  '<font color="red">'.email_utilise.'</font><br />';
			$continue = false;
		}
	}

	echo  '|**|-|**|'.$continue;

}
else if(isset($_GET['pseudo'])){
	
	//Puis on regarde si l'adresse email n'est pas deja utilise
	$query = $Bdd->sql('SELECT id FROM '.PT.'_users WHERE pseudo="'.$Bdd->secure($_POST['pseudos']).'"' );
	if($Bdd->get_num_rows($query)==0){
		echo '<font color="green">'.pseudo_non_utilise.'</font><br />';
		$continue = true;
	}
	else{
		echo '<font color="red">'.pseudo_utilise.'</font><br />';
		$continue = false;
	}
	echo  '|**|-|**|'.$continue;
}
else if(isset($_GET['code'])){
	if(${'register:'.$Bdd->secure($_POST['ip'])} == $Bdd->secure($_POST['code'])){
		echo 'good';
	}
}

?>