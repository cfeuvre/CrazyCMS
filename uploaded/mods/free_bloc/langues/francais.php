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

This software is governed by the CeCILL� license under French law and
abiding by the rules of distribution of free software.  You can  use, 
modify and/ or redistribute the software under the terms of the CeCILL�
license as circulated by CEA, CNRS and INRIA at the following URL
"http://www.cecill.info". 

The fact that you are presently reading this means that you have had
knowledge of the CeCILL� license and that you accept its terms.
*/

define ( 'ADMIN_FREEBLOCS' , 'Administration des Blocs' );
define ( 'BLOCS_DISPO' , 'Blocs disponibles' );
define ( 'BLOC_NAME' , 'Nom du Bloc' );
define ( 'BLOC_TYPE' , 'Type du Bloc' );
define ( 'BLOC_CONTENT' , 'Contenu du Bloc' );
define ( 'BLOC_TXT' , 'Bloc Texte' );
define ( 'BLOC_SUCCESSFULLY_CREATED' , 'Bloc cr�e avec succ�s' );
define ( 'BLOC_CODE' , 'Bloc libre' );
define ( 'BLOC_SUCCESSFULLY_DELETED' , 'Bloc supprim� avec succ�s' );
define ( 'NONE_BLOCS' , 'Aucun Bloc' );
define ( 'MODIFY_BLOC' , 'Modification d\'un Bloc' );
define ( 'BLOC_SUCCESSFULLY_MODIFIED' , 'Bloc modifi� avec succ�s' );
define ( 'BLOC_ALREADY_EXIST' , 'Ce Bloc existe d�ja ! Veuillez choisir un autre nom' );
define ( 'MORE_CHAR' , ' Le Nom doit contenir au moins 2 Caract�res' );
define ( 'ADD_BLOC' , 'Ajouter un Bloc' );
define ( 'CHOOSE_BLOC_TYPE' , 'Choisissez le type de Bloc' );
define ( 'DIFFERENCE_BETWEEN_CODE_AND_TXT' , 'Diff�rence entre un bloc libre et un bloc texte' );
define ( 'DIFFERENCE_TXT' , ' - Un Bloc texte est un bloc que vous cr�ez et qui contient le texte de votre choix ( Texte pouvant �tre mis en page � l\'aide de l\'editeur Wysiwyg ou bien � l\'aide de bbCode ) 

- Un Bloc libre est un bloc que vous pouvez cr�er en y ins�rant du code Html ou Php sans qu\'il ne soit bloqu� ;)

<u>Remarque : </u>

Afin de fonctionner avec CrazyCMS, un bloc libre ne peut pas comprendre de "echo" : Pour afficher un texte, vous devez placer la ligne suivante : 

$template->set_filename ( \'bloc.tpl{|}{CHAINE_ALEATOIRE_DIFFERENT_POUR_CHAQUE_BLOC}\'  , FALSE);
$template->assign_block_vars( \'bloc-{MEME_CHAINE_QUE_CI_DESSUS}\', array(\'TITRE_BLOC\' => $row[\'tbloc\'], \'CONTENU_BLOC\' => $contenu ) );

a la fin de votre fichier, avant le \'?>\'.

Vous devez �galement d�finir la variable $contenu qui contiendra le contenu du bloc ;)' );

?>