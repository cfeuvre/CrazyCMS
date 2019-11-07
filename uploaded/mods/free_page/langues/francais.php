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

define ( 'FREE_PAGE' , 'Pages libres' );
define ( 'NONE_PAGE' , 'Aucune Page' );
define ( 'PAGE_CONTENT' , 'Contenu de votre page' );
define ( 'FREEPAGES_DISPO' , 'Pages libres disponibles' );
define ( 'FREEPAGE_HELP' , 'A quoi servent les pages libres ?' );
define ( 'FREEPAGE_HELPS' , 'Une Page libre est une page que vous pouvez créer en y insérant du code Html ou Php sans qu\'il ne soit bloqué ;)

Remarque : 

Afin de fonctionner avec CrazyCMS, une page php ne peut pas comprendre de "echo" : Pour afficher un texte, vous devez placer la ligne suivante : 

$template->assign_block_vars(\'module\' , array(\'TITRE_MODULE\' => $titre, \'CONTENU_MODULE\' => \'&lt;br /&gt;&lt;br /&gt;\'.$contenu));

a la fin de votre fichier, avant le \'?>\'.

Vous devez également définir les variables $titre qui contiendra le titre de la page et $contenu qui contiendra le contenu de la page ;)' );
define ( 'PAGE_NAME' , 'Titre de la Page' );
define ( 'PAGE_CODE' , 'Contenu de la page' );
define ( 'NAME_ALREADY_USED' , 'Nom déja utilisé ! Veuillez en choisir un autre.' );
define ( 'PAGE_SUCCESSFULLY_ADDED' , 'Page ajouté avec succès.' );
define ( 'PAGE_SUCCESSFULLY_UPDATED' , 'Page mise à jour avec succès.' );
define ( 'PAGE_DELETED_SUCCESSFULLY' , 'Page supprimé avec succès' );
define ( 'ADD_PAGE' , 'Ajouter une Page' );
define ( 'PAGES_DISPO' , 'Pages disponibles' );

?>