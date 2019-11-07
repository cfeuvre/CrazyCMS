var clik=false,x,y,dobj;

	// Fonction pour deplacer les fenetres
	function movemouse(e)
	{
		//Si l'utilisateur clique sur une fenetre a deplacer, alors on la deplace la ou il place sa souris
		if (clik)
		{
			if(!e) {e = event;}
			dobj.style.left = tx + e.clientX - x + "px";
			dobj.style.top  = ty + e.clientY - y + "px";
			return false;
		}
	}

	//Fonction afin d'indiquer que l'utilisateur veut deplacer une fenetre, qui indique quelle fenetre deplacer et ou la deplacer ;)
	function move(element, e)
	{
		clik = true;
		dobj = element;
		tx = parseInt(element.style.left+(document.body.clientWidth*50/100),10);
		ty = parseInt(element.style.top+(document.body.clientHeight*50/100),10);
		x = e.clientX;
		y = e.clientY;
		return false;
	}

	document.onmouseup= Function("clik=false");

	// Fonction pour actualiser le contenu du ttchat
	function actualise(uid,pseudo,salon,password, salonpwd, is_come, are_come, is_left, are_left, fuseau, langue, first, format_date, theme){
		var cookies = document.cookie.split(";");
		var i =0;
		var cook = "enabled";
		while(i<cookies.length){
			var actual = cookies[i].split("=");
			if(actual[0]==1){
				cook = actual[1];
			}
			var i = i + 1;
		}
		var xhr_object = null; 
		
		if ( first == true ){
			cook = "disabled";
		}
	 
		if(window.XMLHttpRequest) // Navigateur Normal :
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
	 
		xhr_object.open("POST", "./mods/tchat/ajax.php?load", true); 
		
		var data = "salon=" + salon + "&password=" + password + "&pseudo=" + pseudo + "&uid=" + uid + "&salonpwd=" + salonpwd + "&fuseau=" + fuseau + "&langue=" + langue + "&format_date=" + format_date + "&theme=" + theme;
	 
		xhr_object.onreadystatechange = function(){
			var retour = xhr_object.responseText.split("|*|");
	
			if(xhr_object.readyState == 4) { 
				document.getElementById('contenu_tchat').scrollTop = document.getElementById('contenu_tchat').scrollHeight;
				document.getElementById('last_date').value = retour[1];
				var toprint = retour[0];
				var verif_po = toprint.split("|*-*-*|");
				if(verif_po[1] == 0){
					var reg=new RegExp("vareurotoreplace", "g");
					var mess =  verif_po[0].replace(reg,"€");
					document.getElementById('contenu_tchat').innerHTML = mess;
					document.getElementById('message').disabled="disabled";
					document.getElementById('submitb').disabled="disabled";
				}
				else{
					//On regarde si il y a news users ou dotres users ki sont partis
					if( ( document.getElementById('arrivee').value != "" || document.getElementById('departs').value != "" )){
		
						var arrivees = document.getElementById('arrivee').value.split(",");
						var departs = document.getElementById('departs').value.split(",");
	
						if(arrivees.length==2){
							toprint = "<font color=\"green\">" + arrivees[0] + " " + is_come + "</font><br /><br /><hr />" + toprint ;
							if(cook == "enabled"){
								document.getElementById('sound').innerHTML ="<object type=\"application/x-shockwave-flash\" data=\"./mods/tchat/sons/dewplayer.swf?son=mods/tchat/sons/online.mp3&autoplay=1\" width=\"200\" height=\"20\"> <param name=\"movie\" value=\"dewplayer.swf?son=mods/tchat/sons/online.mp3&autoplay=1\" /> </object>";
							}
						}
						else if(arrivees.length>2){
							toprint = "<font color=\"green\">" + document.getElementById('arrivee').value + " " + are_come + "</font><br /><br /><hr />" + toprint;
							if(cook == "enabled"){
								document.getElementById('sound').innerHTML ="<object type=\"application/x-shockwave-flash\" data=\"./mods/tchat/sons/dewplayer.swf?son=mods/tchat/sons/online.mp3&autoplay=1\" width=\"200\" height=\"20\"> <param name=\"movie\" value=\"dewplayer.swf?son=mods/tchat/sons/online.mp3&autoplay=1\" /> </object>";
							}
						}
						
						if(departs.length==2){
							if(departs[0]!="undefined"){
								toprint = "<font color=\"red\">" + departs[0] + " " + is_left + "</font><br /><br /><hr />" + toprint;
								if(cook == "enabled"){
									document.getElementById('sound').innerHTML ="<object type=\"application/x-shockwave-flash\" data=\"./mods/tchat/sons/dewplayer.swf?son=./mods/tchat/sons/offline.mp3&autoplay=1\" width=\"200\" height=\"20\"> <param name=\"movie\" value=\"dewplayer.swf?son=./mods/tchat/sons/offline.mp3&autoplay=1\" /> </object>";
								}
							}
						}
						else if(departs.length>2){
							toprint = "<font color=\"red\">" + document.getElementById('departs').value + " " + are_left + "</font><br /><br /><hr />" + toprint;
							if(cook == "enabled"){
								document.getElementById('sound').innerHTML ="<object type=\"application/x-shockwave-flash\" data=\"./mods/tchat/sons/dewplayer.swf?son=./mods/tchat/sons/offline.mp3&autoplay=1\" width=\"200\" height=\"20\"> <param name=\"movie\" value=\"dewplayer.swf?son=./mods/tchat/sons/offline.mp3&autoplay=1\" /> </object>";
							}
						}
						
						if ( first == true ){
							toprint= "<b>" + retour[3] + "</b><br />" + toprint;
						}
						var reg=new RegExp("vareurotoreplace", "g");
						var toprint =  toprint.replace(reg,"€");
						document.getElementById('contenu_tchat').innerHTML = toprint;
				
					}
					else{
						if(retour[2]!= pseudo){
							if(cook == "enabled"){
								document.getElementById('sound').innerHTML ="<object type=\"application/x-shockwave-flash\" data=\"./mods/tchat/sons/dewplayer.swf?son=./mods/tchat/sons/newmess.mp3&autoplay=1\" width=\"200\" height=\"20\"> <param name=\"movie\" value=\"dewplayer.swf?son=./mods/tchat/sons/newmess.mp3&autoplay=1\" /> </object>";
							}
						}
						var reg=new RegExp("vareurotoreplace", "g");
						var mess =  retour[0].replace(reg,"€");
							
							if ( first == true ){
								document.getElementById('contenu_tchat').innerHTML = "<b>" + retour[3] + "</b><br /><br />" + mess;
							}
							else{
								document.getElementById('contenu_tchat').innerHTML = mess;
							}
					}
					
				}	
			}
		}
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		xhr_object.send(data);
	}
	
	//Fonction afin de verifier les utilisateurs actuellement en ligne, les utilisateurs qui arrivent, ceux qui partent et egalement pour verifier l'arrivee de nouveaux messages
	function verif(uid,pseudo,salon,password, salonpwd, connected, is_come, are_come, is_left, are_left, fuseau, langue, first, format_date, theme){
	window.uid = uid;
	window.pseudo = pseudo;
	window.salon = salon;
	window.password = password;
	window.salonpwd = salonpwd;
	window.connected = connected;
	window.is_come = is_come;
	window.are_come = are_come;
	window.is_left = is_left;
	window.are_left = are_left;
	window.fuseau = fuseau;
	window.langue = langue;
	window.format = format_date;
	window.theme = theme;
	
		var xhr_object = null; 
	 
		if(window.XMLHttpRequest) // Navigateur Normal :
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
			
		var  data = "date=" + document.getElementById('last_date').value + "&salonpwd=" + salonpwd + "&uid=" + uid + "&pseudo=" + pseudo + "&liste=" + document.getElementById('users_liste').value + "&salon=" + salon + "&password=" + password + "&last_our_mess=" + document.getElementById('last_date').value + "&langue=" + langue; 
		xhr_object.open("POST", "./mods/tchat/ajax.php?verif", true); 
		xhr_object.onreadystatechange = function() { 

			if(xhr_object.readyState == 4) {
			
				var reponse = xhr_object.responseText.split("|*|");
				//document.getElementById('contenu_tchat').innerHTML = xhr_object.responseText;
				if(reponse[0] == "new"){
					actualise(window.uid, window.pseudo, window.salon, window.password, window.salonpwd, window.is_come, window.are_come, window.is_left, window.are_left, window.fuseau, window.langue, first, window.format, window.theme);
				}
			
				document.getElementById('currents_user').innerHTML = "<fieldset><u>" + connected + " : </u>" + reponse[1] + "</fieldset>";
				document.getElementById('users_liste').innerHTML = reponse[2];
			
				//Si l'on detecte des arrives ou des departs, on le signale
				if(reponse[3] != "" || reponse[4] != ""){
					document.getElementById('arrivee').innerHTML = reponse[3];
					document.getElementById('departs').innerHTML = reponse[4];
					actualise(window.uid, window.pseudo, window.salon, window.password, window.salonpwd, window.is_come, window.are_come, window.is_left, window.are_left, window.fuseau, window.langue, first, window.format, window.theme);
				}
				else{
					document.getElementById('arrivee').innerHTML = "";
					document.getElementById('departs').innerHTML = "";
				}
				setTimeout('verif(window.uid, window.pseudo, window.salon, window.password, window.salonpwd, window.connected, window.is_come, window.are_come, window.is_left, window.are_left, window.fuseau, window.langue, false, window.format, window.theme);',999);
			}
		}
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		xhr_object.send(data);
	}

	//Fonction pour ajouter un nouveau message sans reactualisation
	function add(uid,pseudo, password, salon, salonpwd){
		document.getElementById('message').disabled = true;
		document.getElementById('loading').innerHTML = "<img src=\"./themes/loading.gif\" alt=\"Loading...\" />";
		var mess = document.getElementById('message').value;
		var reg=new RegExp("[+]", "g");
		var reg2=new RegExp("[&]", "g");
		var reg3=new RegExp("[€]", "g");
		var mess =  mess.replace(reg,"varplustoreplace");
		var mess =  mess.replace(reg2,"varandtoreplace");
		var mess =  mess.replace(reg3,"vareurotoreplace");
		document.getElementById('message').value ="";
		var xhr_object = null; 
	 
		if(window.XMLHttpRequest) // Navigateur Normal :
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
	
		var  data = "message=" + mess + "&pseudo=" + pseudo + "&password=" + password + "&salon=" + salon + "&uid=" + uid + "&salonpwd=" + salonpwd; 
		xhr_object.open("POST", "./mods/tchat/ajax.php?add", true); 
		xhr_object.onreadystatechange = function() { 

			if(xhr_object.readyState == 4) {
				document.getElementById('message').value = "";
				document.getElementById('message').disabled = false;
				document.getElementById('loading').innerHTML = "";
			}	
		}
	
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		xhr_object.send(data);
	}

	//Fonction pour fermer l'une des fenetres
	function closethis(win){
		document.getElementById(win).style.visibility = "hidden";
	}

	//Fonctions pour afficher la fenetre des smileus
	function view_smilies(smilies){
		var xhr_object = null; 
	 
		if(window.XMLHttpRequest) // Navigateur Normal :
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
	
		var  data = ""; 
	 
		xhr_object.open("POST", "./mods/tchat/ajax.php?smil", true); 
	 	xhr_object.onreadystatechange = function() { 
	
			if(xhr_object.readyState == 4) {
				document.getElementById("smilies").innerHTML = "<div class=\"sm_chat\"><p><center><u><b>" + smilies + "</u></b> <a href=\"javascript:closethis('smilies' );\"> X </a></center></p><br />" + xhr_object.responseText + "</div>";
				document.getElementById("smilies").style.visibility = "visible";
			}	
		}
	
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		xhr_object.send(data);
	}

	//Fonction pour changer l'image pour activer ou desactiver le son si celui ci est deja desactive lorsque l'on arrive sur le tchat
	function load(){

		var cookies = document.cookie.split(";");

		var i =0;
		var cook = "enabled";

		while(i<cookies.length){
			var actual = cookies[i].split("=");

			if(actual[0]==1){
				cook = actual[1];
			}

			var i = i + 1;
		}

		if(cook != "enabled"){
			document.getElementById('son_pic').src = "./themes/off.png"
		}
		else{
			document.getElementById('son_pic').src = "./themes/son.png"
		}
	}

	//Fonction pour activer ou desactiver le son
	function load_son(){

		var cookies = document.cookie.split(";");
		var i =0;
		var cook = "enabled";
		while(i<cookies.length){
			var actual = cookies[i].split("=");

			if(actual[0]==1){
				cook = actual[1];
			}
			var i = i + 1;
		}

		if(cook == "enabled"){
			var recup = "disabled";
			document.getElementById('son_pic').src = "./themes/off.png"
		}
		else{
			var recup = "enabled";
			document.getElementById('son_pic').src = "./themes/son.png"
		}

		var date_exp = new Date();
		date_exp.setTime(date_exp.getTime()+(365*24*3600*1000));
		document.cookie="1="+escape(recup)+((date_exp==null) ? "" : ("; date_exp="+date_exp.toGMTString()));
	}
		
	// Fonction pour rediriger l'user vers un salon prive en cryptant le pass en md5 au passage ;)
	function open_salle(salon, give_pass, password){
		var mdp = prompt(give_pass, password);
		if(mdp!=null){
			window.location.href = "index.php?mods=tchat&page=ajax&redir&salon=" + salon + "&pass=" + mdp;
		}
	}