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

//Génération de l'image de sécurité
include_once('../../includes/config.php' );

if ( !isset ( $_SERVER ) )$_SERVER = $HTTP_SERVER_VARS;

$sql = $Bdd->sql('SELECT valeur FROM '.PT.'_parametres WHERE nom="register:'.$Bdd->secure($_SERVER['REMOTE_ADDR']).'"' );

if($Bdd->get_num_rows($sql)==0){
	$sql = 'Error...';
}
else{
	$sql = $Bdd->get_array($sql);
	$sql = $sql['valeur'];
}

if ( isset ( $_GET['test'] ) )
	$sql = 'Youpi :D';

header ("Content-type: image/png");

// Création de la zone image en fonction de la longueur de texte à afficher
$image = imagecreatetruecolor(160, 40);
// Création du fond de l'image
for($i = 0; $i < 180; $i++)
{
    for($v = 0; $v < 50; ++$v)
    {
        if (mt_rand(1,5) == 4 )
        {
            $red = mt_rand(0, 100);
            $green = mt_rand(0, 100);
            $blue = mt_rand(0, 100);
        }
        else
        {
            $red = mt_rand(100, 150);
            $green = mt_rand(100, 150);
            $blue = mt_rand(100, 150);
        }

        // Allocation d'une couleur au fond
        $color = imagecolorallocate($image, $red, $green, $blue);

        imagesetpixel($image, $i, $v, $color);
		
		// Suppression la couleur de la bordure allouée
		imagecolordeallocate($image, $color);
    }
}

// Création de la bordure avec une couleur aleatoire
$vred = mt_rand(0, 240);
$vgreen = mt_rand(0, 240);
$vblue = mt_rand(0, 240);

// Allocation d'une couleur à la bordure
$color = imagecolorallocate($image, $vred, $vgreen, $vblue);

// Tracé de la bordure
imagerectangle($image, 0, 0, 179 , 49, $color);

// Suppression la couleur de la bordure allouée
imagecolordeallocate($image, $color);

// Création du texte
for($i = 0; $i < 8; $i++)
{
	// Choix d'une couleur aleatoire
    $red = mt_rand(150, 240);
    $green = mt_rand(150, 240);
    $blue = mt_rand(150, 240);
	$color = imagecolorallocate($image, $red, $green, $blue);
	
	// Taille de la lettre
    $size = mt_rand(17, 22);
	// Choix de l'angle de la lettre
    $angle = mt_rand(-10, 10);
	
	// Position de la lettre
    $x = 20 * $i + 2;
	// Choix de la hauteur de la lettre
    $y = mt_rand(22, 37);

    // On ajoute cette lettre a l'image
    imagettftext($image, $size, $angle, $x, $y, $color, 'arial.ttf', $sql[$i]);
	
	// Suppression la couleur de la bordure allouée
	imagecolordeallocate($image, $color);
}
imagepng($image);
imagedestroy($image);
?>