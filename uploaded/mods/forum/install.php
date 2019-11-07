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

/*
FICHIER D'INSTALLATION DU FORUM
*/

// On vérifie que tous les fichiers nécessaires au fonctionnement du forum marchent ;)
if(file_exists($rep.'/mods/forum/delete.php') AND file_exists($rep.'/mods/forum/index.php') AND file_exists($rep.'/mods/forum/admin.php') AND file_exists($rep.'/mods/forum/admin2.php') AND file_exists($rep.'/mods/forum/edit.php') AND file_exists($rep.'/mods/forum/post.php') AND file_exists($rep.'/mods/forum/search.php') AND file_exists($rep.'/mods/forum/viewfor.php') AND file_exists($rep.'/mods/forum/viewtopic.php')){

//Création de la table des categories
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_forum_cat (
  id int(11) NOT NULL auto_increment,
  nom varchar(255) NOT NULL default "",
  def varchar(255) NOT NULL default "",
  position int(11) NOT NULL default "0",
  ecriture text NOT NULL,
  groupes text NOT NULL,
  PRIMARY KEY  (id)
) ' );

$Bdd->sql('INSERT INTO '.PT.'_forum_cat VALUES ("", "'.FIRST_CAT_NAME.'", "'.FIRST_CAT_DEF.'", 0, "0;", "0;")' );

//Création de la table des forums
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_forum_for (
  id int(11) NOT NULL auto_increment,
  parent int(11) NOT NULL default "0",
  nom varchar(255) NOT NULL default "",
  def varchar(255) NOT NULL default "",
  sujets int(11) NOT NULL default "0",
  messages int(11) NOT NULL default "0",
  is_sub int(1) NOT NULL default "0",
  position int(11) NOT NULL default "0",
  ecriture text NOT NULL,
  groupes text NOT NULL,
  locked int(1) NOT NULL default "0",
  lastmess varchar(255) NOT NULL,
  moderators varchar(50) NOT NULL,
  cat_parent int (11) NOT NULL,
  PRIMARY KEY  (id)
)' );

$Bdd->sql('INSERT INTO '.PT.'_forum_for VALUES ("", 1, "'.FIRST_FORUM_NAME.'", "'.FIRST_FORUM_DEF.'", 1, 0, 0, 0, "0;", "0;", 0, "'.ADMIN.'|*--*|1150799400|*--*|1|*--*|'.FIRST_TOPIC_DEF.'", "","")' );

//Création de la table des topics
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_forum_topic (
  id int(11) NOT NULL auto_increment,
  parent int(11) NOT NULL default "0",
  auteur int(11) NOT NULL default "0",
  nom varchar(255) NOT NULL default "",
  contenu text NOT NULL,
  date int(11) NOT NULL default "0",
  smileys int(1) NOT NULL default "0",
  bb int(1) NOT NULL default "0",
  messages int(11) NOT NULL default "0",
  ecriture text NOT NULL,
  groupes text NOT NULL,
  vue int (11) NOT NULL,
  lastmess text NOT NULL,
  locked int (1) NOT NULL,
  attached int (1) NOT NULL,
  lastreply_date int (11) NOT NULL,
  cat_parent int (11) NOT NULL,
  PRIMARY KEY  (id)
)' );

$Bdd->sql('INSERT INTO '.PT.'_forum_topic VALUES ("", 1, 2, "'.FIRST_TOPIC_DEF.'", "'.FIRST_TOPIC_CONTENU.'", 1150799400, 1, 1, 0, "", "", 0, "", 0, 0,"","")' );

//Création de la table des réponses
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_forum_reply (
  id int(11) NOT NULL auto_increment,
  parent int(11) NOT NULL default "0",
  auteur int(11) NOT NULL default "0",
  contenu text NOT NULL,
  date int(11) NOT NULL default "0",
  smileys int(1) NOT NULL default "0",
  bb int(1) NOT NULL default "0",
  groupes text NOT NULL,
  PRIMARY KEY  (id)
)' );

//Création de la table des réponses
$Bdd->sql('CREATE TABLE IF NOT EXISTS '.PT.'_forum_ranks (
	id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	nb_posts INT( 11 ) NOT NULL ,
	name VARCHAR( 30 ) NOT NULL )' );

$Bdd->sql ( 'TRUNCATE TABLE '.PT.'_forum_ranks' );

$Bdd->sql('INSERT INTO '.PT.'_forum_ranks VALUES 
	("", 0, "'.NOOB.'"),
	("", 10, "'.MEMBER.'"),
	("", 100, "'.MEMBER_INSIDE.'"),
	("", 250, "'.SENIOR_MEMBER.'"),
	("", 500, "'.CRAZY_POSTER.'")');


//Requete pour supprimer permissions forums si y sont déja ( vu qu'on va les remettre vaut mieux qu'elle ne soient pas en double );
$Bdd->sql('DELETE FROM '.PT.'_permissions WHERE element="forum"' );

// Ajout des permissions relatives au forum
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "view_forum", "'.PRINT_FORUM.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "view_forum_for", "'.PRINT_FORUM_CATEGORY.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "view_forum_topic", "'.PRINT_FORUM_TOPIC.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "post_reply", "'.POST_FORUM_REPLY.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "post_topic", "'.POST_FORUM_TOPIC.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "edit_all_topics", "'.EDIT_ALL_TOPICS.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "delete_all_topics", "'.DELETE_ALL_TOPICS.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "edit_our_topics", "'.EDIT_OUR_OWN_TOPIC.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "delete_our_topics", "'.DELETE_OUR_OWN_TOPIC.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "edit_all_replys", "'.EDIT_ALL_REPLY.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "delete_all_replys", "'.DELETE_ALL_REPLY.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "edit_our_replys", "'.EDIT_OUR_OWN_REPLY.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "delete_our_replys", "'.DELETE_OUR_OWN_REPLY.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "move_topic", "'.MOVE_A_TOPIC.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "lock_topic", "'.LOCK_A_TOPIC.'", "forum", "module")' );
$Bdd->sql('INSERT INTO '.PT.'_permissions VALUES ("", "attach_topic", "'.ATTACH_A_TOPIC.'", "forum", "module")' );

$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "flood_time", "30")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "forum_rules", "'.NO_RULES.'")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "forum_nb_topic_page", "30")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "forum_use_ranks", "1")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "forum_nb_reponses_page", "10")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "forum_grade_admin", "4")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "function_reputation", "0")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "forum_rules", "")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "new_reply_posted_mail", "'.FORUM_INSTALL_MAIL_REPLY.'")' );
$Bdd->sql('INSERT INTO '.PT.'_parametres VALUES ("", "new_topic_posted_mail", "'.FORUM_INSTALL_MAIL_TOPIC.'")' );

		$cont .= '<font color="green">'.FORUM_INSTALL_SUCCESS.'</font>';
}
else{

		$cont .= '<font color="red">'.FORUM_INSTALL_ERROR.'</font><br />';

if(!file_exists($rep.'/mods/forum/index.php')){
	$cont_forum .= ' - '.file.' "index.php" '.is_requis.' <br />';
}
if(!file_exists($rep.'/mods/forum/delete.php')){
	$cont_forum .= ' - '.file.' "delete.php" '.is_requis.' <br />';
}
if(!file_exists($rep.'/mods/forum/admin.php')){
	$cont_forum .= ' - '.file.' "admin.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/forum/admin2.php')){
	$cont_forum .= ' - '.file.' "admin2.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/forum/edit.php')){
	$cont_forum .= ' - '.file.' "edit.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/forum/post.php')){
	$cont_forum .= ' - '.file.' "post.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/forum/search.php')){
	$cont_forum .= ' - '.file.' "search.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/forum/viewfor.php')){
	$cont_forum .= ' - '.file.' "viewfor.php" '.is_requis.'<br />';
}
if(!file_exists($rep.'/mods/forum/viewtopic.php')){
	$cont_forum .= ' - '.file.' "viewtopic.php" '.is_requis.'<br />';
}



}
?>