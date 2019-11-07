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

header('Content-type: text/html; charset=iso-8859-15' ); 


$handle = opendir("../../smileys/"); 

		while (($file = readdir($handle))!=false) { 
				
			if($file!=".." && $file!="." && $file!="Thumbs.db" && $file != 'index.html')
			{	
				$bal = substr($file,0,strlen($file)-4);

				echo"<a href=\"javascript:smil('$file' , '{DIV_REPLACE}');\"><img src=\"./smileys/$file\" alt=\"$file\" border=\"0\" style=\"-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;\"/></a>&nbsp;&nbsp;";
			}
		}
	closedir($handle); 
?>