<?php
$Bdd->sql ( 'DROP TABLE '.PT.'_download_cat' );
$Bdd->sql ( 'DROP TABLE '.PT.'_download_comments' );
$Bdd->sql ( 'DROP TABLE '.PT.'_download_files' );

$Bdd->sql ( 'DELETE FROM '.PT.'_permissions WHERE element="download"' );
$Bdd->sql ( 'DELETE FROM '.PT.'_parametres WHERE nom = "download_reco_mess" OR nom="download_grade_admin"' );
?>