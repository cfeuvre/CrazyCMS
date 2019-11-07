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

$Bdd->sql ( 'DROP TABLE '.PT.'_forum_cat' );
$Bdd->sql ( 'DROP TABLE '.PT.'_forum_for' );
$Bdd->sql ( 'DROP TABLE '.PT.'_forum_topic' );
$Bdd->sql ( 'DROP TABLE '.PT.'_forum_reply' );
$Bdd->sql ( 'DELETE FROM '.PT.'_permissions WHERE element="forum"' );
$Bdd->sql ( 'DELETE FROM '.PT.'_parametres WHERE nom = "flood_time" OR nom = "forum_grade_admin" OR nom = "forum_nb_topic_page" OR nom = "forum_nb_reponses_page" OR nom="forum_rules" OR nom="forum_use_ranks" OR nom="function_reputation"' );
?>