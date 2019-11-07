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
if(!defined('CCMS'))die('' );

if( ereg("view_gallery;",$permissions) OR $grade==4){

	$template->set_filename ( 'haut_mods.tpl' );
	$template->set_filename ( './modules/galerie_photo/index.tpl' );

	if(isset($_GET['add_comment'])){

		if(ereg("comment_photo;",$permissions) OR $grade == 4){

			if(isset($_POST['contenu']) AND $_POST['contenu']!=NULL){
			
				$contenu = htmlspecialchars($_POST['contenu'],ENT_QUOTES);
				$query = $Bdd->sql('SELECT id FROM '.PT.'_gallery WHERE nom="'.htmlspecialchars( base64_decode ( $_GET['add_comment'] ) , ENT_QUOTES ).'" AND galerie="'.htmlspecialchars ( base64_decode ( $_GET['gallery'] ) , ENT_QUOTES ).'"' );  
				$sql =$Bdd->get_array($query);

				$Bdd->sql('INSERT INTO '.PT.'_gallery_comment VALUES ("", "'.$sql['id'].'", "'.$uid.'", "'.convertime(time()).'", "0", "'.$HTTP_SERVER_VARS['REMOTE_ADDR'].'", "'.$Bdd->secure ( $_POST['contenu'] ).'")' );
				
				$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => add_comment ));
				
				$template->assign_block_vars ( 'text' , array (
				'TXT' => comments_added,
				'URL' => 'index.php?mods=galerie_photo&amp;picture='.base64_encode( htmlspecialchars( base64_decode ( $_GET['gallery'] ) ).'/'.htmlspecialchars( base64_decode ( $_GET['add_comment'] ) ,ENT_QUOTES) ),
				'BACK' => back ) );			
			}
			else{
				$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => add_comment ) );
				$template->assign_block_vars ( 'text' , array (
				'TXT' => '<form method="post" action="">'.default_form( FALSE ).'</form>',
				'URL' => 'index.php?mods=galerie_photo&amp;picture='.base64_encode( htmlspecialchars( base64_decode ( $_GET['gallery'] ) ).'/'.htmlspecialchars( base64_decode ( $_GET['add_comment'] ) ,ENT_QUOTES) ),
				'BACK' => back ) );
			}
		}
		else{
			$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => add_comment ) );	
			$template->assign_block_vars ( 'text' , array (
			'TXT' => cant_add,
			'URL' => 'index.php?mods=galerie_photo&amp;picture='.base64_encode( htmlspecialchars( base64_decode ( $_GET['gallery'] ) ).'/'.htmlspecialchars( base64_decode ( $_GET['add_comment'] ) ,ENT_QUOTES) ),
			'BACK' => back ) );
		
		}

	}
	else if(isset($_GET['gallery'])){

	$obj = '{';
	$obj2 = '{';
	$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => view_gallery.' : '.htmlspecialchars(base64_decode($_GET['gallery']),ENT_QUOTES) ) );
	$template->assign_block_vars ( 'gallery' , array(
	'STYLE' => '
		<style type="text/css">
			#picture {
				visibility: hidden; 
				z-index: 100; 
				position: fixed;
				top: 100px;
				left: 100px;
			}
			#im_page {
				position : fixed;
				visibility: hidden;
				top: 0px; 
				left: 0px;
				background-color: #000;
				width: 100%; 
				height:100%;
				z-index: 99;
				opacity: 0;
				filter: alpha(opacity=0);
			}
		</style>',
	'BACK' => back ) );
	$a = 0;
	$handle = opendir("./mods/galerie_photo/galeries/".htmlspecialchars(base64_decode($_GET['gallery']),ENT_QUOTES).'/'); 
	while (($file = readdir($handle))!=false) { 
		if($file!=".." AND $file!="."){
			$longueur = strlen($file);
			$type = substr($file,$longueur-3,$longueur);
			$types = substr($file,$longueur-4,$longueur);
							
			if( strtolower ( $type ) == 'png' OR  strtolower ( $types ) == 'jpeg' OR strtolower ( $type ) == 'jpg' OR  strtolower ( $type ) == 'gif'){

				$a++;
				$obj .= $a.': "./mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['gallery']),ENT_QUOTES).'/'.$file.'",';
				$imz = getimagesize ( './mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['gallery']),ENT_QUOTES).'/'.$file ) ;

				$new_size = resize ( 140 , 140 , $imz[0] , $imz[1] );			
				
				$template->assign_block_vars ( 'gallery.pic' , array (
				'HREF' => 'index.php?mods=galerie_photo&amp;picture='.base64_encode( ( htmlspecialchars(base64_decode($_GET['gallery']),ENT_QUOTES).'/' ).( $file ) ),
				'ID' => 'img:'.$a,
				'SRC' => './mods/galerie_photo/galeries/'.htmlspecialchars(base64_decode($_GET['gallery']),ENT_QUOTES).'/'.$file,
				'WIDTH' => $new_size[0],
				'HEIGHT' => $new_size[1] ) );
			}
		}
	}
	closedir($handle); 
	
	$obj = substr ( $obj , 0 , strlen ( $obj ) - 1 );
	
	$obj .= '}';
	
	$template->assign_block_vars ( 'gallery' , array ( 'JS' =>
	'		<script type="text/javascript">
			<!--
				window.cont = true;
			
				// Permet de reduire les images si getimagesize() n\'a pas pu faire son boulot ;)
				function resize ( img ){
					if ( document.getElementById( img ).width  > 140 )
						document.getElementById( img ).style.width = "140px";
					if ( document.getElementById( img ).height  > 140 )
						document.getElementById( img ).style.height = "140px";
				}
				
				var xobj = '.$obj.';
				for ( img in xobj ){
					resize ( "img:" + img );
				}			
				
				function diaporama(){
					
					// Objet contenant la liste des images
					var obj = '.$obj.';
					
					// Temps entre deux images dans le diaporama
					var tps = 5000;
					
					document.getElementById(\'im_page\').style.visibility = "visible";
					
					for (i=0.1; i<=0.95; i = i + 0.05) {
						var t = ( i * 500 );
						setTimeout ( "fondu(" + i + ")" , t );
					}
					
					var time = 0;
					var t = 0;
					for ( img in obj ){
						if ( cont ){
							setTimeout ( "show_pic ( \'" + obj [ img ] +  "\')" , (  t * tps ) );
							time = t * tps ;
							t = t +1;
						}
					}
					setTimeout ( "close_pic()" , ( time + tps ) );
					
				}
				
				function fondu ( opacity ){
					document.getElementById(\'im_page\').style.opacity = opacity;
					document.getElementById(\'im_page\').style.filter = "alpha(opacity=" + ( opacity * 100 ) + ")";
				}
		
				function show_pic( picture ){
					if ( window.cont == true ){

						document.getElementById(\'picture\').style.visibility = "visible";
						document.getElementById(\'pic\').src = picture;
						
						// On trouve la position idéale de l\'image
						var height = document.getElementById(\'pic\').height ;
						var width = document.getElementById(\'pic\').width ;
						
						var sheight = screen.availHeight;
						var swidth = screen.availWidth;
						
						if ( width == 0 )
							width = swidth - 100 ;
						if ( height == 0)
							height = sheight - 300 ;
						
						var w = ( swidth / 2 ) - ( width / 2 );
						var h = ( ( sheight / 2 ) - ( height / 2 ) ) - 100 ;

						document.getElementById(\'picture\').style.top = h + "px";
						document.getElementById(\'picture\').style.left = w + "px";			
						
					}
					
				}
				function close_pic( ){
					window.cont = false;
					
					j = 0.1;
					for (i=0.95; i>=0.1; i = i - 0.05) {
						var t = ( j * 500 );
						setTimeout ( "fondu(" + i + ")" , t );
						j = j + 0.05;
					}
					
					setTimeout ( "cl()" , 401 );
				}
				function cl(){
					document.getElementById(\'im_page\').style.visibility = "hidden";
					document.getElementById(\'picture\').style.visibility = "hidden";
					document.getElementById(\'pic\').src = "";
					document.location.reload();
				}
			-->
		</script>' ) ) ;
		
		if ( $a == 0 ){
			$template->assign_block_vars ( 'gallery.none' , array ( 'TXT' => NOONE_PICTURES ) );
		}
		else{
			$template->assign_block_vars ( 'gallery.diap' , array ( 'TXT' => SHOW_DIAPORAMA ) );		
		}
	}
	else if ( isset ( $_GET['picture'] ) ){

		$chemin = htmlspecialchars ( base64_decode ( $_GET['picture'] ) );
		$chems = explode ( '/' , $chemin );

		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => PRINTING_PICTURE.' : '.$chems[1] ) );

		$imz = array ( 1 , 1 );
		$imz = @getimagesize('./mods/galerie_photo/galeries/'.$chemin );
		
		$query = $Bdd->sql ( 'SELECT description, votes FROM '.PT.'_gallery WHERE nom = "'.$chems[1].'"' );
		$sql = $Bdd->get_array ( $query );
		
		if ( $sql['description'] != '' )
			$description = $sql['description'];
		else
			$description = NO_DESCRIPTION;
		
		$new_size = resize ( 400 , 400 , $imz[0] , $imz[1] );

		$template->assign_block_vars ( 'picture' , array (
		'ONCLICK' => 'show_pic( \' ./mods/galerie_photo/galeries/'.$chemin.' \');return false;',
		'SRC' => './mods/galerie_photo/galeries/'.$chemin,
		'WIDTH' => $new_size[0],
		'HEIGHT' => $new_size[1],
		'JS' => '
			<script type="text/javascript">
				<!--
					function fondu ( opacity ){
						document.getElementById(\'im_page\').style.opacity = opacity;
						document.getElementById(\'im_page\').style.filter = "alpha(opacity=" + ( opacity * 100 ) + ")";
						
					}
			
					function show_pic( picture ){
						document.getElementById(\'im_page\').style.visibility = "visible";
						
						for (i=0.1; i<=0.95; i = i + 0.05) {
							var t = ( i * 500 );
							setTimeout ( "fondu(" + i + ")" , t );
						}
						
						document.getElementById(\'picture\').style.visibility = "visible";
						document.getElementById(\'pic\').src = picture;
						
						// On trouve la position idéale de l\'image
						var height = document.getElementById(\'pic\').height ;
						var width = document.getElementById(\'pic\').width ;
						
						var sheight = screen.availHeight;
						var swidth = screen.availWidth;
						
						if ( width == 0 )
							width = swidth - 100 ;
						if ( height == 0)
							height = sheight - 300 ;
						
						var w = ( swidth / 2 ) - ( width / 2 );
						var h = ( ( sheight / 2 ) - ( height / 2 ) ) - 100 ;

						document.getElementById(\'picture\').style.top = h + "px";
						document.getElementById(\'picture\').style.left = w + "px";							
						
					}
					
					function close_pic( picture ){
					
						j = 0.1;
						for (i=0.95; i>=0.1; i = i - 0.05) {
							var t = ( j * 500 );
							setTimeout ( "fondu(" + i + ")" , t );
							j = j + 0.05;
						}
						
						setTimeout ( "cl()" , 401 );

					}
					
					function cl(){
						document.getElementById(\'im_page\').style.visibility = "hidden";
						document.getElementById(\'picture\').style.visibility = "hidden";
						document.getElementById(\'pic\').src = "";
					}
					
					function viewcomment(){

						if(document.getElementById(\'view_comment\').style.visibility == "hidden"){
							document.getElementById(\'view_comment\').style.visibility = "visible";
							document.getElementById(\'view_comment\').style.height = "350px";

						var xhr_object = null; 
						 
						if(window.XMLHttpRequest) // Navigateur Normal :
						   xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
						   xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
						  
						var  data = "id='.$uid.'&password='.$user_password.'&dossier='.base64_encode ( $chems[0] ).'&picture='.base64_encode ( $chems[1] ).'&theme='.$u_theme.'" ; 
						 
						xhr_object.open("POST", "./mods/galerie_photo/view_comment.php", true); 
						 
						xhr_object.onreadystatechange = function() { 
						
							if(xhr_object.readyState == 4) { 
								document.getElementById(\'view_comment\').style.height = "";
								document.getElementById(\'view_comment\').innerHTML = xhr_object.responseText;
							}	
						}
						
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
						
						xhr_object.send(data);
						
						}
						else{
							document.getElementById(\'view_comment\').style.visibility = "hidden";
							document.getElementById(\'view_comment\').style.height = "3px";
						}

					}
					
					function voter(){

						var xhr_object = null; 
						 
						if(window.XMLHttpRequest) // Navigateur Normal :
							xhr_object = new XMLHttpRequest(); 
						else if(window.ActiveXObject) // Internet Explorer 
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
						  
						var  data = "pic='.$chems[1].'&uid='.$uid.'&vote=" + document.getElementById(\'vote\').value + "&password='.$user_password.'" ; 
						 
						xhr_object.open("POST", "./mods/galerie_photo/voter.php", true); 
						 
						xhr_object.onreadystatechange = function() { 
						
							if(xhr_object.readyState != 4) {
								document.getElementById(\'div_voter\').innerHTML = "<img src=\"./mods/news/images/loading.gif\">";
								load_infos(picture);
							}
							else{
								document.getElementById(\'div_voter\').innerHTML = xhr_object.responseText;
								if ( xhr_object.responseText == "'.VOTE_SUCCESSFULLY_ADDED.'" ){
									history.go(0);
								}
							}	
						}
						
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
						
						xhr_object.send(data);

					}
				-->
			</script>',
		'STYLE' => '
			<style type="text/css">
				#picture {
					visibility: hidden; 
					z-index: 100; 
					position: fixed;
					top: 100px;
					left: 100px;
				}
				#im_page {
					position : fixed;
					visibility: hidden;
					top: 0px; 
					left: 0px;
					background-color: #000;
					width: 100%; 
					height:100%;
					z-index: 99;
					opacity: 0;
					filter: alpha(opacity=0);
				}
			</style>',
		'DESCRIPTION' => PICTURE_DESCRIPTION,
		'DES' => to_html ( $description ),
		'HREF' => 'index.php?mods=galerie_photo&amp;add_comment='.base64_encode ( $chems[1] ).'&amp;gallery='.base64_encode ( $chems[0] ),
		'ADD_COMMENT' => ADD_COMMENT,
		'SEE_COMMENTS' => SEE_COMMENTS,
		'VOTES' => VOTES,
		'MARK' => MARK_THIS_PICTURE,
		'BACK_URL' => 'index.php?mods=galerie_photo&amp;gallery='.base64_encode ( $chems[0] ),
		'BACK' => back ) );
		
		if($sql['votes'] == NULL){
			$template->assign_block_vars ( 'picture.nonevote' , array ( 'TXT' => NO_MARKS ) );
		}
		else{
			$votes = $sql['votes'];
			$nombre = strlen($votes);
			$total = $nombre / 4;
			$vote = explode(";",$votes);
			$d = 0;
			$compte = 0;
			while($d<=$total){
				$vote_actuel = preg_replace('!\|[0-9]!', "", $vote[$d]);	
				$compte = $compte + $vote_actuel;
				$d++;
			}
			
			$compte = $compte / $total;
			$compte = round($compte);
			
			$template->assign_block_vars ( 'picture.vote' , array() );
			
			$e = 0;
			while($e<5){
				
				if($e<$compte){
					$template->assign_block_vars ( 'picture.vote.v' , array ( 'SRC' => './themes/'.$u_theme.'/img/galerie_photo/vote_good.png' ) );
				}
				else{
					$template->assign_block_vars ( 'picture.vote.v' , array ( 'SRC' => './themes/'.$u_theme.'/img/galerie_photo/vote_false.png' ) );
				}
				$e++;
			}
		}
	}
	else{

		$template->assign_block_vars ( 'mod_titre' , array ( 'TITRE' => photo_gallery ));
		$template->assign_block_vars ( 'index' , array() );

		$b = 0;
		$handle = opendir("./mods/galerie_photo/galeries/"); 
		while (($file = readdir($handle))!=false) { 
			clearstatcache(); 
			if($file!=".." AND $file!="." AND is_dir('./mods/galerie_photo/galeries/'.$file))
			{
				$b++;
				
				$template->assign_block_vars ( 'index.gal' , array (
				'HREF' => 'index.php?mods=galerie_photo&amp;gallery='.base64_encode($file) ,
				'NAME' => $file ) );
				
				$find = 0;
				$handle2 = opendir("./mods/galerie_photo/galeries/".$file."/"); 
				while (($file2 = readdir($handle2))!=false AND $find != 1) { 
				
					if($file2!=".." AND $file2!=".")
					{
						$longueur = strlen($file2);
						$type = substr($file2,$longueur-3,$longueur);
						$ltype = substr($file2,$longueur-4,$longueur);
						if( strtolower ( $type ) == 'png' OR strtolower ( $type ) == 'jpg' OR strtolower ( $type ) == 'gif' OR strtolower ( $ltype ) == 'jpeg'){
							$find = 1;
							
							$imz = @getimagesize('./mods/galerie_photo/galeries/'.$file.'/'.$file2);
							$new_size = resize ( 100 , 100 , $imz[0] , $imz[1] );
							
							$template->assign_block_vars ( 'index.gal.pic' , array (
							'HREF' => 'index.php?mods=galerie_photo&amp;gallery='.base64_encode($file),
							'SRC' => './mods/galerie_photo/galeries/'.$file.'/'.$file2.'" alt="'.$file2,
							'WIDTH' => $new_size[0],
							'HEIGHT' => $new_size[1]) );
						}
					}
				}
				closedir($handle2); 

				if(file_exists('./mods/galerie_photo/galeries/'.$file.'/description.txt')){
					
					$files = fopen('./mods/galerie_photo/galeries/'.$file.'/description.txt' , 'r' );
				
					while (!feof($files)) {
						$contenu = to_html ( fgets ( $files , 4096 ) );
					}
					fclose($files);
					
					$template->assign_block_vars ( 'index.gal.des' , array (
					'HREF' => 'index.php?mods=galerie_photo&amp;gallery='.base64_encode($file),
					'TXT' => $contenu ) );
				
				}	
			}
		}
		closedir($handle); 

		if($b==0){
			$template->assign_block_vars ( 'index.none' , array ( 'TXT' => no_gallery ) );
		}
	}
	$template->set_filename ( 'bas_mods.tpl' );
}
else{
	// Si l'utilisateur n'a rien a faire la, on lui dit ;)
	$template->set_filename('error_page.tpl' );
	$template->assign_vars ( array ( 'ACCESS_UNAUTHORIZED' => ACCESS_UNAUTHORIZED ) );
}
?>