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

FICHIER D'INSTALLATION DU CHAT

*/

// On vérifie que tous les fichiers nécessaires au fonctionnement du forum marchent ;)
if ( file_exists ( $rep.'/mods/tchat/ajax.php' ) && file_exists ( $rep.'/mods/tchat/index.php' ) && file_exists ( $rep.'/mods/tchat/admin.php' ) && file_exists ( $rep.'/mods/tchat/tchat.js' ) ){

//Requete pour supprimer permissions forums si y sont déja ( vu qu'on va les remettre vaut mieux qu'elle ne soient pas en double );
$Bdd->sql('DELETE FROM '.PT.'_permissions WHERE element="tchat"' );

// Ajout des permissions relatives au forum
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "view_chat", "'.ACCESS_TO_CHAT.'", "tchat", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "post_chat", "'.POST_TO_CHAT.'", "tchat", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "tchat_grade_admin","4")' );

	$cont .= '<font color="green">'.CHAT_INSTALLED.'</font>';

}
else{

	$cont .= '<font color="red">'.CHAT_ERROR.'</font><br />';


if(!file_exists($rep.'/mods/tchat/admin.php')){
	$cont .= ' - '.file.' "admin.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/tchat/index.php')){
	$cont .= ' - '.file.' "index.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/tchat/ajax.php')){
	$cont .= ' - '.file.' "ajax.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/tchat/tchat.js')){
	$cont .= ' - '.file.' "tchat.js" '.is_requis.'<br />';
}

}
?>