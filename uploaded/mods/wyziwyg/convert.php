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

include ( '../../includes/fonctions.php' );
include ( '../../langues/'.htmlspecialchars ( $_POST['lang'] ).'/lang.php' );
$contenu = str_replace ( 'varandtoreplace' , '&' , str_replace ( 'varegaltoreplace' , '=' , $_POST['contenu'] ) );

 // On veut convertir en bb Code
if ( $_POST['type'] == 'to_bb' ){

		$contenu = preg_replace ( '!&(amp;)+!isU' , '&' , $contenu );
		$contenu = str_replace ( '"' , '&quot;' , $contenu ) ;
		$contenu = str_replace ( '\&quot;' , '&quot;' , $contenu ) ;
		$contenu = str_replace ( '%22' , '', $contenu);		
		$contenu = str_replace ( '%20' , '', $contenu);		
		
		// On convertit le contenu de chaque balise en minuscule
		$contenu = preg_replace_callback ( '!<(.+)?>!isU' , "to_min" , $contenu );
		
		$contenu = str_replace ( '&lt;' , '<' , str_replace ( '&gt;' , '>' , $contenu ) );
		
		// Images
		$contenu = preg_replace ( '!<img( )?(style=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?width=(&quot;)?([0-9]+)(&quot;)?( )?height=(&quot;)?([0-9]+)(&quot;)?( )?(align=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(src=(&quot;)?([^&|>|"|=]+)?(&quot;)?)?( )+(alt=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )+>!isU' , '[img]$22[/img]' , $contenu );
		$contenu = preg_replace ( '!<img( )?(style=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?width=(&quot;)?([0-9]+)(&quot;)?( )?height=(&quot;)?([0-9]+)(&quot;)?( )?(align=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(alt=(&quot)?([^&|>|"]+)?(&quot;)?)?( )?(src=(&quot;)?([^&|>|"|=]+)?(&quot;)?)?( )?>!isU' , '[img]$22[/img]' , $contenu );
		$contenu = preg_replace ( '!<img( )?height=(&quot;)?([0-9]+)(&quot;)?( )?(alt=(&quot;)?([^&|>|"]+)(&quot;)?)?( )?(src=(&quot;)?([^&|>|"|=]+)?(&quot;)?)?( )?(width=(&quot)?([0-9]+)?(&quot;)?( )?)+>!isU' , '[img]$13[/img]' , $contenu );
		$contenu = preg_replace ( '!<img( )?(style=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(src=(&quot;)?([^&|>|"|=]+)?(&quot;)?)?( )?(alt=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(align=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?height=(&quot;)?([0-9]+)(&quot;)?( )?width=(&quot;)([0-9]+)?(&quot;)?( )?/?( )?>!isU' , '[img]$9[/img]' , $contenu );
		$contenu = preg_replace ( '!<img( )?(style=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(align=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(src=(&quot;)?([^&|>|"|=]+)?(&quot;)?)?( )+(alt=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )+>!isU' , '[img]$14[/img]' , $contenu );
		$contenu = preg_replace ( '!<img( )?(style=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(align=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(alt=(&quot)?([^&|>|"]+)?(&quot;)?)?( )?(src=(&quot;)?([^&|>|"|=]+)?(&quot;)?)?( )?>!isU' , '[img]$19[/img]' , $contenu );
		$contenu = preg_replace ( '!<img( )?(style=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(src=(&quot;)?([^&|>|"|=]+)?(&quot;)?)?( )?(alt=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(align=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?/?( )?>!isU' , '[img]$9[/img]' , $contenu );
		
		$contenu = preg_replace ( '!<a (style=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(title=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?(class=(&quot;)?([^&|>|"]+)?(&quot;)?)?( )?href=(&quot;)?([^&|>|"]+)?(&quot;)?( )?(target=(&quot;)?_?blank(&quot;)?)*( )?>([^>|"]+)?</a>!isU' , '[url=$17]$24[/url]' , $contenu );		
		$min_bal = array ( 
		'</em>' => '[/i]' , 
		'<em>' => '[i]' , 
		'</i>' => '[/i]' , 
		'<b>' => '[b]' , 
		'</b>' => '[/b]' , 
		'<i>' => '[i]' , 
		'<strong>' => '[b]' , 
		'<strike>' => '[s]' , 
		'</strike>' => '[/s]' , 
		'<u>' => '[u]' , 
		'<code>' => '[code]' , 
		'</strong>' => '[/b]' , 
		'</u>' => '[/u]' , 
		'</code>' => '[/code]' ) ;

		foreach ( $min_bal as $min => $new ) $contenu = str_replace ( $min , $new , $contenu ) ;
		
		$contenu = preg_replace ( '!<( )*br( )*/?>!' , "\n" , $contenu );
		
		$contenu = preg_replace ( '!<([^<|>]+)>!' , '' , $contenu );
	
	echo $contenu;
}
else{
 // On converti en html :)
	echo to_html ( $contenu , '../..' );
}

?>