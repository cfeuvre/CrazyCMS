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

// Fonction pour l'ajout de bbCode simple
function bbcode(balise , langue , div){

	var id = "message" + div ;

	//On identifie le navigateur, si le navigateur est IE, alors comme Ie est pourri et que rien ne marche avec IE, le code doit etre different que celui des autres navigateurs 
	var clientPC = navigator.userAgent.toLowerCase();
	var is_ie = ((clientPC.indexOf('msie') != -1) && (clientPC.indexOf('opera') == -1));

	//Si le navigateur est IE, le code est adapte pour marcher avec IE
	if(is_ie){

		var selection = document.selection.createRange().text;

		if(!selection){
			document.getElementById(id).value = "[" + balise + "]" + (document.getElementById(id).value) + "[/" + balise + "]";
		}
		else{
			document.selection.createRange().text = "[" + balise + "]" + selection + "[/" + balise + "]";
	}

	}
	else{
		
		//Si le navigateur n'est pas IE, le code marche tres bien tout seul ;)
		var obj = document.getElementById(id), sel;

		var debut = obj.selectionStart ;
		var fin = obj.selectionEnd ;

		//Si il n'y a pas de selection de faite, la balise se place a la fin
		if(debut == fin){
			obj.value = (obj.value) + "[" + balise + "]" + "[/" + balise + "]";
		}
		else{
			// Si il y a une selection de faite, on place les balises autour de la selection
			var longueur= parseInt(obj.textLength);
			obj.value = obj.value.substring(0,debut) + "[" + balise + "]" + obj.value.substring(debut,fin) + "[/" + balise + "]" + obj.value.substring(fin,longueur);
		}
	}

	instant_preview( langue , div );
}

// Fonction de prévisualisation automatique du texte
function instant_preview( langue , div ){
	
	var xhr_object = null; 
	 
	if(window.XMLHttpRequest) // Navigateur Normal :
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // Internet Explorer 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 

	var mess = document.getElementById('message' + div ).value;
	mess = mess.replace( /[+]/g,"varplustoreplace").replace( /[&]/g,"varandtoreplace");
	
	var data = "mess=" + mess + "&langue=" + langue; 
	 
	xhr_object.open("POST", "./mods/ajax/preview.php", true); 
	 
	xhr_object.onreadystatechange = function() { 
	
		if(xhr_object.readyState == 4) { 
			document.getElementById('preview' + div ).innerHTML = xhr_object.responseText;
		}	   
	} 
	
	xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	
	xhr_object.send(data); 
}

// Fonction de bbCode avance ( police, couleur, taille );
function formatage(type, langue , div){

	var balise = document.getElementById(type);
	var obj = document.getElementById('message' + div);

	//On identifie le navigateur, si le navigateur est IE, alors comme Ie est pourri et que rien ne marche avec IE, le code doit etre different que celui des autres navigateurs 
	var clientPC = navigator.userAgent.toLowerCase();
	var is_ie = ((clientPC.indexOf('msie') != -1) && (clientPC.indexOf('opera') == -1));

	//Si le navigateur est IE, le code est adapte pour marcher avec IE
	if(is_ie){

		var selection = document.selection.createRange().text;

		if(!selection){
			document.getElementById('message' + div ).value = (obj.value) + "[" + type + "=" + balise.value + "]" + "[/" + type + "]";
		}
		else{
			document.selection.createRange().text = "[" + type + "=" + balise.value + "]" + selection + "[/" + type + "]";
		}

	}
	else{

		//Si le navigateur n'est pas IE, le code marche tres bien tout seul ;)
		var obj = document.getElementById('message' + div), sel;

		var debut = obj.selectionStart ;
		var fin = obj.selectionEnd ;

		//Si il n'y a pas de selection de faite, la balise place a fin
		if(debut == fin){
			obj.value = (obj.value) + "[" + type + "=" + balise.value + "]" + "[/" + type + "]";
		}
		else{
			// Si il y a une selection de faite, on place les balises autour de la selection
			var longueur= parseInt(obj.textLength);
			obj.value = obj.value.substring(0,debut) + "[" + type + "=" + balise.value + "]" + obj.value.substring(debut,fin) + "[/" + type + "]" + obj.value.substring(fin,longueur);
		}
	}

instant_preview( langue , div );

}

// Fonction pour ajouter un smiley
function smi(balise , div ){
	var obj = document.getElementById('message' , div );
	obj.value = obj.value + ":" + balise;
}