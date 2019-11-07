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
class Log{

	// Fonction pour ajouter un evenement dans les logs
	function add_event ( $event , $module ){
		
		global $uid, $grade, $god_user;
		
		$gx = $grade;
		
		// Si l'utilisateur est un admin dieu
		$arr = explode(', ',$god_user);
		if ( in_array ( $uid , $arr ) )
			$gx = 'god';
		
		if ( file_exists ( './cache/logs/log_'.$gx.'.ini' ) ){
			$file = parse_ini_file ( './cache/logs/log_'.$gx.'.ini' , TRUE );
			$id = 0;
			foreach ( $file AS $id => $content )
				$nm = $id;
				
			$id++;
			$event = str_replace ( '=' , 'egaltorepinlog%µ' , base64_encode ( $event ) );
			$module = str_replace ( '=' , 'egaltorepinlog%µ' , base64_encode ( $module ) );
			$content = "\n[$id]\nuid = $uid;\nevent = $event;\nmodule = $module;\ntime = ".convertime ( time() ).";";
			$file = fopen ( './cache/logs/log_'.$gx.'.ini' , 'a+' );
			fputs ( $file , $content );
			fclose ( $file );
		}
		else{
			$event = str_replace ( '=' , 'egaltorepinlog%µ' , base64_encode ( $event ) );
			$module = str_replace ( '=' , 'egaltorepinlog%µ' , base64_encode ( $module ) );
			$content = "[0]\nuid = $uid;\nevent = $event;\nmodule = $module;\ntime = ".convertime ( time() ).";";
			$file = fopen ( './cache/logs/log_'.$gx.'.ini' , 'w+' );
			fputs ( $file , $content );
			fclose ( $file );
		}
		
	}

	// Fonction pour supprimer un evenement discretement pr po sfaire tapper sur doigt (^^)
	function del_event ( $grade , $id ){
		
		if ( file_exists ( './cache/logs/log_'.$grade.'.ini' ) ){
			
			$file = fopen ( './cache/logs/log_'.$grade.'.ini' , 'r+' );
			$content = '';
			while ( !feof ( $file ) )
				$content .= fgets ( $file , 4096 );
			fclose ( $file );
			
			$content = preg_replace ( '!\['.$id.'\]\nuid = ([0-9]+);\nevent = ([^;]+);\nmodule = ([^;]+);\ntime = ([0-9]+);!' , '' , $content );
			
			$file = fopen ( './cache/logs/log_'.$grade.'.ini' , 'w+' );
			fputs ( $file , $content );
			fclose ( $file );
			
		}
		
	}

}
?>