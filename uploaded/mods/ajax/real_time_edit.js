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
FONCTION POUR L'EDITION EN TEMPS REEL DE MESSAGES
*/

function real_edit(div,uid,pass,idp,module, navig, lang, theme,sdiv){
	
	var xhr_object = null; 
	 
	if(window.XMLHttpRequest) // Navigateur Normal :
		xhr_object = new XMLHttpRequest(); 
	else if(window.ActiveXObject) // Internet Explorer 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 

	// Données a envoyer à la page
	var  data = "&uid=" + uid + "&pass=" +  pass + "&idp=" + idp + "&module=" + module + "&navig=" + navig + "&lang=" + lang+ "&div=" + div + "&theme=" + theme + "&sdiv=" + sdiv; 
	
	// On appelle la page distante
	xhr_object.open("POST", "./mods/ajax/real_time_edit.php?load", true); 
	 
	xhr_object.onreadystatechange = function() { 
	
		// Une fois la page charge, on affiche l'editeur avec le post a editer
		if(xhr_object.readyState == 4){
		
			// On separe le code javascript du formulaire
			var reponse = xhr_object.responseText.split("|*|ÙÛÞþµµÕõÒÔÓ|*|");
			
			document.getElementById(div).innerHTML = reponse[1];
			// On execute le js :D
			
			window.eval(reponse[0]);
		}
		else{
		// Sinon on affiche une image de chargement pour lui dire de patienter
			document.getElementById(div).innerHTML = "<center><img src=\"./themes/loading.gif\" alt=\"Chargement en cours...\"/></center>";
		}
	}

	xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 

	xhr_object.send(data);

}

function real_post(div,uid,pass,idp,module,navig, lang, titre,sdiv){

	var xhr_object = null; 
	 
	if(window.XMLHttpRequest) // Navigateur Normal :
		xhr_object = new XMLHttpRequest(); 
	else if(window.ActiveXObject) // Internet Explorer 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 

	// Données a envoyer à la page
	// On transforme les caracteres non supportes par l'ajax pour qu'il ne fasse pas tout bugger =)
	var mess = document.getElementById('message'+sdiv).value;
	var mess =  mess.replace( /[+]/g,"varplustoreplace");
	var mess =  mess.replace(/[&]/g,"varandtoreplace");
	var mess =  mess.replace(/[€]/g,"vareurotoreplace");
	
	// On envoi les données
	var  data = "message=" + mess + "&uid=" + uid + "&pass=" +  pass + "&module=" + module + "&idp=" + idp + "&navig=" + navig + "&lang=" + lang ; 
	
	if ( titre == true ){
		var title = document.getElementById('form_title'+sdiv).value;

		var title =  title.replace( /[+]/g ,"varplustoreplace");
		var title =  title.replace( /[&]/g ,"varandtoreplace");
		var title =  title.replace( /[€]/g ,"vareurotoreplace");
		
		data += "&title=+" + title;
	}	
	
	// On appelle la page distante
	xhr_object.open("POST", "./mods/ajax/real_time_edit.php?post", true); 
	 
	xhr_object.onreadystatechange = function() { 
	
		// Une fois la page charge, on affiche l'editeur avec le post a editer
		if(xhr_object.readyState == 4){
			document.getElementById(div).innerHTML = xhr_object.responseText;
		}
		else{
		// Sinon on affiche une image de chargement pour lui dire de patienter
			document.getElementById(div).innerHTML = "<center><img src=\"./themes/loading.gif\" alt=\"Chargement en cours...\"/></center>";
		}
	}
	
	xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	
	xhr_object.send(data);

}