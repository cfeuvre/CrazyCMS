// Fonction pour tester compatibilité de l'editeur avec le navigateur du client
function check_navig (){

	var navig = navigator.userAgent.toLowerCase() ;

	// Internet Explorer > 6
	if ( /*@cc_on!@*/false && navig.indexOf('msie ') != -1 )
		return ( navig.match( / msie (\d+)/ )[1] >= 6 );

	// Navigateurs Gecko ( Firefox, Mozilla, Netscape,... )
	if ( navigator.product == "Gecko" && navigator.productSub >= 20030210 && !( typeof(opera) == 'object' && opera.postError ) )
		return true ;

	// Opera > 9
	if ( window.opera && window.opera.version && parseFloat( window.opera.version() ) >= 9 )
			return true ;

	// Safari > 3
	if ( navig.indexOf( ' applewebkit/' ) != -1 )
		return ( navig.match( / applewebkit\/(\d+)/ )[1] >= 522 ) ;

	return false ;

}

// Fonction afin de passer de l'eidteur wysiwyg à l'editeur bbcode
function change_editor( height , first , div , langue , wysi){
	
	if ( !wysi )var wysi = false;
	
	var compatible = check_navig();
	
	// Si on change d'editeur manuellement, on recupere le contenu actuel pour le convertir en bbCode ou en HTML
	if ( height == null ){
		convert_content( div , langue );
	}
	
	if ( compatible && document.getElementById('wysiwyg').style.visibility == "hidden" && !wysi ){
	
		document.getElementById('wysiwyg').style.visibility = "visible"; 
		document.getElementById('wysiwyg_toolbar').style.visibility = "visible"; 
		document.getElementById('wysiwyg').style.height = ""; 
		document.getElementById('wysiwyg_toolbar').style.height = ""; 
		document.getElementById('wysiwyg').style.width = ""; 		
		document.getElementById('wysiwyg_toolbar').style.width = ""; 		

		document.getElementById('preview' + div).innerHTML = ""; 		

		document.getElementById('compatible').style.visibility = "visible"; 
		document.getElementById('compatible').style.height = ""; 
		document.getElementById('compatible').style.width = ""; 
		
		document.getElementById('bbcode').style.visibility = "hidden"; 
		document.getElementById('bbcode_toolbar').style.visibility = "hidden"; 
		document.getElementById('bbcode').style.height = "0px"; 
		document.getElementById('bbcode_toolbar').style.height = "0px"; 
		document.getElementById('bbcode').style.width = "0px"; 
		document.getElementById('bbcode_toolbar').style.width = "0px"; 
		
		if ( first )load_wysi( height , div );
		
	}
	else{
	
		document.getElementById('bbcode').style.visibility = "visible"; 
		document.getElementById('bbcode_toolbar').style.visibility = "visible"; 
		document.getElementById('bbcode').style.height = ""; 
		document.getElementById('bbcode_toolbar').style.height = ""; 
		document.getElementById('bbcode').style.width = ""; 
		document.getElementById('bbcode_toolbar').style.width = ""; 
		
		document.getElementById('wysiwyg').style.visibility = "hidden"; 
		document.getElementById('wysiwyg_toolbar').style.visibility = "hidden"; 
		document.getElementById('wysiwyg').style.height = "0px"; 
		document.getElementById('wysiwyg_toolbar').style.height = "0px"; 
		document.getElementById('wysiwyg').style.width = "0px";
		document.getElementById('wysiwyg_toolbar').style.width = "0px";
	}
}

//On charge le cadre d'edition ( div pour ie, iframe pour les autres navigateurs ) 
function load_wysi ( height , div ){
	
	var navig = navigator.userAgent.toLowerCase() ;
	if ( /*@cc_on!@*/false ){
		document.getElementById('wysiwyg').innerHTML = "<div id=\"edit"+div+"\" contenteditable=\"true\" class=\"wysiwyg_editor\" style=\"height:" + height + "px;\"></div>";
	}
	else{

		document.getElementById('wysiwyg').innerHTML = "<center><iframe id=\"edit"+div+"\" class=\"wysiwyg_editor\" style=\"height:" + height + "px;\"></iframe></center>";
		setTimeout("zone('"+div+"')", 1 );
	}
	
}

// on rend l'iframe editable
function zone( div ){
		var zone = document.getElementById('edit' + div ).contentDocument;
		zone.designMode = "On";
}

// On copie le contenu de la zone vers le textera
function getContent( div ){
	// On applique que si l'on est en mode wysiwyg
	if ( document.getElementById('wysiwyg').style.visibility == "visible" ){
		if ( /*@cc_on!@*/false ){
			document.getElementById('message' + div ).value = document.getElementById('edit' + div ).innerHTML; 
		}
		else{
			document.getElementById('message' + div ).value = document.getElementById('edit' + div ).contentDocument.body.innerHTML; 
		}
	}
}

// Ajout d'une URL
function add_url ( div ){

	if ( !/*@cc_on!@*/false ){
	
		var zone = document.getElementById('edit' + div ).contentDocument;
		
		// On insert une balise temoin pour recuperer la position du curseur, sous Safari t Opera, on rajoute la selection qui à été supprimé lors de l'ajout de la balise temoin
		if ( navigator.product == "Gecko" && navigator.productSub >= 20030210 && !( typeof(opera) == 'object' && opera.postError ) )
			zone.execCommand ( "insertHTML" , false , "||@_-*-_@||" );
		else
			zone.execCommand ( "insertHTML" , false , "||@_-*-_@||" + document.getElementById('edit' + div ).contentWindow.window.getSelection() );

		var contenu = zone.body.innerHTML;
			
		var position = contenu.indexOf ( "||@_-*-_@||" );
	
	}
	
	// On récupère l'url :
	var url = prompt ( 'Url ?' , 'http://' );

	// On vérifie la syntaxe de l'url entrée
	if ( url != null && !url.match(  /<|>/g ) && url.match( /^http:\/\//g ) ){
		
		// On demande le texte associé au lien
		var txt = prompt ( 'Entrez un texte pour le lien' , url );

		if ( !/*@cc_on!@*/false ){
			// On met à jour la zone avec la balise en retirant le temoin
			zone.body.innerHTML = contenu.substring ( 0 , position ) + "<a href=\"" + url + "\">" + txt + "</a>" + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
		}
		else{
			add_content ( "<a href=\"" + url + "\">" + txt + "</a>" , div);
		}
	}
	else{
		alert ( 'L\'Url doit débuter par http:// et ne pas contenir de caractères spéciaux !' );

		// On met à jour la zone en retirant le temoin
		zone.body.innerHTML = contenu.substring ( 0 , position ) + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
	
	}
	getContent( div );
}

// Fonction pour remplir la zone
function insert ( contenu , div ){
	
	if ( /*@cc_on!@*/false ){
	
		 document.getElementById('edit' + div ).innerHTML = contenu;
	}
	else{
		var zone = document.getElementById('edit' + div ).contentDocument;
		zone.body.innerHTML = contenu;
		
		// Pour que la zone soit totalement editable des le debut, on rajoute un truc qu'on vire apres ( sinn sous firefox on ne peut supprimerv un truc avt davoir mi qqch ^^ )
		zone.execCommand ( "insertHTML" , false , "@_-éèçà_@_@" );
		window.location.href="#top";
		var reg = new RegExp("(@_-éèçà_@_@)", "g");
		zone.body.innerHTML = zone.body.innerHTML.replace(reg,'');
	}
}

// Fonction pour ajouter du contenu sous IE
function add_content ( contenu , div ){

	var zone = document.getElementById('edit' + div ).document.selection.createRange();
	var selection = zone.txt;
	if ( selection != undefined ){
		zone.text += contenu;
	}
	else{
		document.getElementById('edit' + div ).innerHTML += contenu;
	}

}

//Ajout d'une image ou d'un smiley
function add_img ( img , div ){

	if ( !/*@cc_on!@*/false ){
		
		var zone = document.getElementById('edit' + div ).contentDocument;
		
		// On insert une balise temoin pour recuperer la position du curseur, sous Safari t Opera, on rajoute la selection qui à été supprimé lors de l'ajout de la balise temoin
		if ( navigator.product == "Gecko" && navigator.productSub >= 20030210 && !( typeof(opera) == 'object' && opera.postError ) )
			zone.execCommand ( "insertHTML" , false , "||@_-*-_@||" );
		else
			zone.execCommand ( "insertHTML" , false , "||@_-*-_@||" + document.getElementById('edit' + div ).contentWindow.window.getSelection() );

		var contenu = zone.body.innerHTML;
		
		var position = contenu.indexOf ( "||@_-*-_@||" );
	
	}
	
	// Si l'image a rajouter n'est pas un smiley :
	if ( img == "null" ){
		
		// On récupère l'url :
		var url = prompt ( 'Url de l\'image ?' , 'http://' );

		// On vérifie la syntaxe de l'url entrée
		if ( url != null && !url.match(  /<|>/g ) && url.match( /^http:\/\//g ) ){

			if ( /*@cc_on!@*/false ){
				add_content ( "<img src=\"" + url + "\" />" , div );
			}
			else{
				// On met à jour la zone avec la balise en retirant le temoin
				zone.body.innerHTML = contenu.substring ( 0 , position ) + "<img src=\"" + url + "\" />" + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
			}
		}
		else{
			alert ( 'L\'Url doit débuter par http:// et ne pas contenir de caractères spéciaux !' );

			// On met à jour la zone en retirant le temoin
			zone.body.innerHTML = contenu.substring ( 0 , position ) + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
		
		}
	}
	else{
		if ( /*@cc_on!@*/false ){
			add_content ( "<img src=\"" + img + "\" />" , div );
		}
		else{
			// On ajoute le smiley
			zone.body.innerHTML = contenu.substring ( 0 , position ) + "<img src=\"" + img + "\" />" + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
		}
	}
	
	getContent( div );
}

// Ajout d'une citation ou d'un code
function add_quote ( type , auteur , url , div ){

	if ( !/*@cc_on!@*/false ){

		var zone = document.getElementById('edit' + div ).contentDocument;
		
		// On insert une balise temoin pour recuperer la position du curseur, sous Safari t Opera, on rajoute la selection qui à été supprimé lors de l'ajout de la balise temoin
		if ( navigator.product == "Gecko" && navigator.productSub >= 20030210 && !( typeof(opera) == 'object' && opera.postError ) )
			zone.execCommand ( "insertHTML" , false , "||@_-*-_@||" );
		else
			zone.execCommand ( "insertHTML" , false , "||@_-*-_@||" + document.getElementById('edit' + div ).contentWindow.window.getSelection() );

		var contenu = zone.body.innerHTML;
			
		var position = contenu.indexOf ( "||@_-*-_@||" );

	}
	
	if ( type == "code" ){
		if ( !/*@cc_on!@*/false ){
			zone.body.innerHTML = contenu.substring ( 0 , position ) + "<br /><fieldset id=\"code\"><legend>CODE</legend><br /><code>Entrez votre code ici</code><br /></fieldset><br /> " + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
		}
		else{
			add_content ( "<br /><fieldset id=\"code\"><legend>CODE</legend><br /><code>Entrez votre code ici</code><br /></fieldset><br /> " , div );
		}
	}
	else{
	
		if ( auteur == "null" ){

			var auteur = prompt ( 'Voulez vous préciser le nom de l\'auteur de la citation ou cliquez sur annuler' , '' );
			
			if ( auteur == null ){
			
				if ( !/*@cc_on!@*/false ){
					zone.body.innerHTML = contenu.substring ( 0 , position ) + "<br /><fieldset id=\"quote\"><legend>Citation : </legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
				}
				else{
					add_content ( "<br /><fieldset id=\"quote\"><legend>Citation : </legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " , div );
				}
			}
			else{
			
				var url = prompt ( 'Précisez l\'url de la citation ou cliquez sur annuler pour ne pas en rentrer' , 'http://' );

				if ( url == null || url.match(  /<|>/g ) || !url.match( /^http:\/\//g )){
					if ( !/*@cc_on!@*/false ){
						zone.body.innerHTML = contenu.substring ( 0 , position ) + "<br /><fieldset id=\"quote\"><legend>Citation de : " + auteur + "</legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
					}
					else{
						add_content ( "<br /><fieldset id=\"quote\"><legend>Citation de : " + auteur + "</legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " , div )
					}				
				}
				else{
					if ( !/*@cc_on!@*/false ){
						zone.body.innerHTML = contenu.substring ( 0 , position ) + "<br /><fieldset id=\"quote\"><legend><a href=\"" + url + "\">Citation de : " + auteur + "</a></legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
					}
					else{
						add_content ( "<br /><fieldset id=\"quote\"><legend><a href=\"" + url + "\">Citation de : " + auteur + "</a></legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " , div );
					}				
				}
			}
		
		}
		else{
			if ( !/*@cc_on!@*/false ){
				zone.body.innerHTML = contenu.substring ( 0 , position ) + "<br /><fieldset id=\"quote\"><legend><a href=\"" + url + "\">Citation de : " + auteur + "</a></legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " + contenu.substring ( ( position + "||@_-*-_@||".length ) , contenu.length );
			}
			else{
				add_content ( "<br /><fieldset id=\"quote\"><legend><a href=\"" + url + "\">Citation de : " + auteur + "</a></legend><br /><code>Entrez votre citation ici</code><br /></fieldset><br /> " , div );
			}
		}
	
	}
	getContent( div );
}

//Fonctions pour afficher la fenetre des smileys
function view_smilies( div ){
	if ( document.getElementById("smilies" + div).style.visibility == "visible" ){
		document.getElementById("smilies" + div).style.visibility = "hidden";
		document.getElementById("smilies" + div).style.height = "0px";
	}
	else{
		var xhr_object = null; 
		if(window.XMLHttpRequest) // Navigateur Normal :
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
			xhr_object.open("POST", "./mods/wyziwyg/smilies.php", true); 
			xhr_object.onreadystatechange = function(){ 
				if(xhr_object.readyState == 4){
					document.getElementById("smilies" + div ).innerHTML = "<fieldset><legend>Smileys</legend><br />" + xhr_object.responseText.replace ( /\{DIV_REPLACE\}/g , div );
					document.getElementById("smilies" + div ).style.visibility = "visible";
					document.getElementById("smilies" + div ).style.height = "";
				}
			}
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		xhr_object.send("");
	}
}

// Fonction pour ajouter un smiley depuis le wysi
function smil( smi , div ){
	var domaine = window.location.href.replace ( /http:\/\/(.+)index.php.+/g , "http://$1/smileys/" );
	add_img ( domaine + smi , div);
}

// Ajout de balises diverses à l'aide de execCommand
function add_bal ( balise , value , div ){

	if ( /*@cc_on!@*/false ){
		document.execCommand ( balise , false , value );
	}
	else{
		var zone = document.getElementById('edit' + div ).contentDocument;
		zone.execCommand ( balise , false , value );
	}
	getContent( div );

}

// Changement de la taille de la zone editable
	function edit_size_x ( size , id , div ){
		document.getElementById( id + div ).style.height = size + "px";
	}

	function edit_size ( type , id , div){

		var size = document.getElementById( id + div ).style.height;
		size = size.split ( 'px' );
		size = Math.round ( size[0] );
		
		if ( type == "+" ){
			var sizef = ( size + 50 );	
			j = 0;
			for ( i = size ; i <= sizef ; i = i + 1 ) {
				setTimeout ( "edit_size_x(" + i + " , \"" + id + "\" , \"" + div + "\")" , j );
				j = j + 10;
			}
		}
		if ( type == "-" ){
			var sizef = ( size - 50 );
			j = 0;
			for ( i = size ; i >= sizef ; i = i - 1 ) {
				setTimeout ( "edit_size_x(" + i + " , \"" + id + "\" , \"" + div + "\")" , j );
				j = j + 10;
			}
		}
	}
//

// Fonction pour passer le contenu du HTML au BBCODE et inverse lorsque l'on décide de changer de formulaire
function convert_content( div , lang ){

	// Si on est dans le formulaire wysiwyg, on envoie le contenu de la zone vers le textarea pour le recuperer
	if ( document.getElementById('wysiwyg').style.visibility == "visible" ){
		getContent( div );
		var type = 'to_bb';
	}
	else{
		var type = 'to_html';
	}
	
	var contenu = document.getElementById('message' + div ).value;
	contenu = contenu.replace( /[+]/g,"varplustoreplace").replace( /[&]/g,"varandtoreplace");

	var xhr_object = null; 
	 
	if(window.XMLHttpRequest) // Navigateur Normal :
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // Internet Explorer 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 

	var data = "contenu=" + contenu + "&type=" + type + "&lang=" + lang; 
	 
	xhr_object.open("POST", "./mods/wyziwyg/convert.php", true); 
	 
	xhr_object.onreadystatechange = function() { 
	
		if(xhr_object.readyState == 4) { 
			if ( type == 'to_bb' ){
				document.getElementById('message' + div ).value = xhr_object.responseText;
			}
			else{
				if ( /*@cc_on!@*/false ){
					document.getElementById('edit' + div ).innerHTML = xhr_object.responseText;
				}
				else{
					document.getElementById('edit' + div ).contentDocument.body.innerHTML = xhr_object.responseText;
				}
			}
		}	   
	} 
	
	xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	
	xhr_object.send(data); 

}
