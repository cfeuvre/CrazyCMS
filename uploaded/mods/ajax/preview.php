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

header('Content-type: text/html; charset=iso-8859-1' ); 

include ( '../../includes/fonctions.php' );
if ( file_exists ( '../../langues/'.preg_replace ( '![^a-zA-Z0-9_-]!' , '' , htmlentities ( $_POST['langue'] ) ).'/lang.php' ) )
	include ( '../../langues/'.preg_replace ( '![^a-zA-Z0-9_-]!' , '' , htmlentities ( $_POST['langue'] ) ).'/lang.php' );

// On converti le bbcode du message en html pour la previsualisation ;)
$mess = to_html (
			preg_replace('!varplustoreplace!' , '+',
				preg_replace('!varandtoreplace!' , '&',
					$_POST['mess']
				)
			)
		,'../..' );

echo $mess;


?>