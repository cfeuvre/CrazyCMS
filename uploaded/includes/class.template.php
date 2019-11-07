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

class Template {

	// Array contenant les fichiers parsés requis pour la page demandé
	var $files = array();
	var $bloc_name = array();
	
	// Mettre FALSE pour forcer la compilation des tpl a chaque chargement (Utile si vous modifiez les fichiers .tpl ;)) 
	var $debog = TRUE;
	
	// Variable indiquant si la classe est appele par une page ajax ou pas
	var $ajax = '';
	
	// Variables necessaires pour les bloc
	var $bloc_parents_level = 0;
	var $bloc_names = array();
	
	//Constructeur : Met en place le dossier d'où sont extraits les templates
	function Template ( $theme , $ajax = FALSE ){
		// Thème dans lequel recuperer les templates
		if ( $ajax === TRUE )
			$this->ajax = '../.';
		else
			$this->ajax = '';
			
		$this->root = './'.$theme.'/';

		unset ( $theme );
	}
	
	// Ajout d'un fichier de tpl
	function set_filename ( $filename , $ajax = FALSE , $colonne = NULL ){
	
		$this->colonne = $colonne;

		// Gestion des blocs qui ne sont pas 100% geres par les tpl ;)
		if ( ereg ( '{|}' , $filename ) ){
			$filename = explode ( '{|}' , $filename );
			$bloc = $filename[1];
			$filename = $filename[0];
		
			$filename = $this->root.$filename;
				
			// On vérifie que le fichier existe
			if ( !is_file ( $filename ) )
				die ( 'Error : File : "'.$filename.'" missing !' );

			// Fichier deja existant ?
			$compiled = $this->ajax.'./cache/templates/'.md5 ( $filename.'-'.$bloc ). '.php';

			if( is_file( $compiled ) && $this->debog ){
				$this->files[] = $compiled;
			}
			else{
				$this->compile( $filename , $this->ajax.'./cache/templates/'.md5( $filename.'-'.$bloc ) , $bloc );
				$this->files[] = $compiled;
			}
		}
		else{
			
			$filename = $this->root.$filename;
				
			// On vérifie que le fichier existe
			if ( !is_file ( $filename ) )
				die ( 'Error : File : "'.$filename.'" missing !' );

			// Fichier deja existant ?
			$compiled = $this->ajax.'./cache/templates/'.md5 ( $filename ). '.php';

			if( is_file( $compiled ) && $this->debog ){
				$this->files[] = $compiled;
			}
			else{
				$this->compile( $filename , $this->ajax.'./cache/templates/'.md5( $filename ) );
				$this->files[] = $compiled;
			}
		}
		unset ( $filename , $compiled );
	}
	
	// Ecriture d'un fichier de tpl
	function compile ( $filename , $compiled , $bloc = NULL ){
		
		// Récuperation du fichier du thème
		$file = fopen ( $filename , 'r' );
			$contenu = '';
			while ( !feof ( $file ) ){
				$contenu .= fgets ( $file , 4096 );
			}
		fclose ( $file );

		if ( $bloc != NULL ){
			$contenu = str_replace ( '<!-- BEGIN bloc -->' , '<!-- BEGIN bloc-'.$bloc.' -->' , $contenu );
			$contenu = str_replace ( '<!-- END bloc -->' , '<!-- END bloc-'.$bloc.' -->' , $contenu );
			$contenu = str_replace ( '{bloc.' , '{bloc-'.$bloc.'.' , $contenu );
		}

		// On converti les templates du thèmes en fichiers parsés prêt à être envoyés ;)
		$contenu = preg_replace('#{([a-zA-Z0-9-_]+)}#', '<?php if(isset($this->tpl_content[\'var\'][\'$1\'])){ echo $this->tpl_content[\'var\'][\'$1\']; }?>', $contenu );
		// Remplissage des blocs
		$contenu = preg_replace_callback('#{([a-zA-Z0-9\._-]+)}#', array($this, 'bloc_var'),$contenu);
		// Parsage des blocs
		$contenu = preg_replace_callback('#<!-- (BEGIN|END) ([a-zA-Z0-9\._-]+) -->#', array ( $this , 'bloc_parse' ) , $contenu );
		
		// Gestion des Blocs
		$contenu = preg_replace_callback('#<!-- DEFAULT (HEAD|FOOT)( )?(~[a-zA-Z0-9\._-]+~)? -->#', array ( $this , 'blocs_parse' ) , $contenu );
		// Remplacement du titre des blocs
		$contenu = preg_replace('#~([a-zA-Z0-9\._-]+)~#', '<?php if(isset($this->bloc_name[\'$1\']))echo $this->bloc_name[\'$1\']; ?>' , $contenu );
		
		// Balise pour limiter ou autoriser l'accès a certains modules ;)
		$contenu = preg_replace_callback('#<!-- (GRANT|LIMIT) \(([;a-zA-Z0-9\._-]+)\) -->#', array ( $this , 'limit' ) , $contenu );
		$contenu = str_replace('<!-- CLOSE -->', '<?php } ?>' , $contenu );

		// Ecriture du fichier de template
		$file = fopen ( $compiled.'.php', 'w+' );
			fputs ( $file , '<?php if(!defined(\'CCMS\')){die(\'Nothing to do here ;)\');} ?>' );
			fputs ( $file , $contenu );
		fclose ( $file );

		unset( $filename , $compiled , $contenu , $file );
	}
	
	function limit ( $var ){
		$return = '';
		if ( $var[1] == 'GRANT' ){
			$return .= '<?php if(';
			$lm = explode ( ';' , $var[2] );
			foreach ( $lm AS $l )
				$return .= '$_GET[\'mods\']==\''.$l.'\' OR';
			$return .= ' FALSE){ ?>';
		}
		else{
			$return .= '<?php if(';
			$lm = explode ( ';' , $var[2] );
			foreach ( $lm AS $l )
				$return .= '$_GET[\'mods\']!=\''.$l.'\' AND';
			$return .= ' TRUE){ ?>';
		}
		return $return;
		unset ( $return );
	}
	
	function assign_bloc_name ( $id , $name ){
		$this->bloc_name[$id] = $name;
	}
	
	function blocs_parse ( $var ){
	
		if ( $var[1] == 'HEAD' ){
			$cont = '';
			$file = fopen ( $this->root.'haut_blocs_'.$this->colonne.'.tpl' , 'r' );
			while ( !feof ( $file ) ){
				$cont .= fgets ( $file , 4096 );
			}
			fclose ( $file );
			
			$cont = str_replace ( '{TITRE_BLOC}' , $var[3] , $cont );
			return $cont;
			unset ( $cont , $file );
		}
		else{
			$cont = '';
			$file = fopen ( $this->root.'bas_blocs_'.$this->colonne.'.tpl' , 'r' );
			while ( !feof ( $file ) ){
				$cont .= fgets ( $file , 4096 );
			}
			fclose ( $file );
			return $cont;
			unset ( $cont , $file );
		}
	}
	
	// Remplissage des blocs
	function bloc_var ( $var ){
		
		// On récupere l'arborescence
		$infos = explode('.', $var[1]);
		$count_infos = count($infos);
		
		// Nom du bloc actuel
		$nom_var = $infos[$count_infos - 1];
		
		// On retire le bloc actuel de l'arborescence pour ne parcourir que les blocs parents
		unset ( $infos[$count_infos - 1] );
		
		// On recupere les blocs parents
		$blocs_parents = '$this->tpl_donnees[\'bloc\']';
		for($i=0; $i<($count_infos-1); $i++)
		{
			$blocs_parents .= '[\''.$infos[$i].'\']';
			$blocs_parents .= '[$i[\''.$infos[$i].'\']]';
		}
		
		// On insere le code d'affichage des variables
		$retour = '<?php echo ( ( isset ( '.$blocs_parents.'[\''.$nom_var.'\'] ) ) ? ( '.$blocs_parents.'[\''.$nom_var.'\'] ) : ( \'\' ) ); ?>';
		
		// On retourne le code
		return $retour;
	}
	
	// Parsage des bloc
	function bloc_parse ( $var ){

		// Si on a une balise de debut de bloc
		if ( $var[1] == 'BEGIN' ){
		
			// On recupere l'arborescence dans un array
			$parents = explode ( '.' , $var[2] );

			// On indique que l'on vient de baisser d'un niveau dans l'arborescence
			$this->bloc_parents_level++;
			$this->bloc_names[$this->bloc_parents_level] = $parents[count($parents)-1];

			// Nom de ce bloc
			$nom = $parents[count($parents)-1];
			
			// On retire le nom de ce bloc de l'arborescence
			unset ( $parents[count($parents)-1] );
			
			$count_blocs = count ( $parents );
		
			// 
			$blocs_parents = '$this->tpl_donnees[\'bloc\']';
			for($i=0; $i<$count_blocs; $i++)
			{
				$blocs_parents .= '[\''.$parents[$i].'\']';
				$blocs_parents .= '[$i[\''.$parents[$i].'\']]';
			}
			$blocs_parents .= '[\'' .$nom. '\'][$i[\''.$nom.'\']]';
			// Si il n'y a pas de bloc parent, on assigne directement les variables
			if ( $this->bloc_parents_level < 2 ){
				$back ='<?php $count[\''.$nom.'\'] = (isset($this->tpl_donnees[\'bloc\'][\''.$nom.'\']) ) ? count($this->tpl_donnees[\'bloc\'][\''.$nom.'\']) : 0; for ($i[\''.$nom.'\']=0; $i[\''.$nom.'\']<$count[\''.$nom.'\']; $i[\''.$nom.'\']++) { ';
			}
			else{
				// Sinon , on assigne les variables en prenant compte de l'arborescence
				$count = $this->bloc_parents_level;
				$varref = '$this->tpl_donnees[\'bloc\']';
				//  On recupere l'arborescence
				for ($i = 1; $i < $count; $i++){
					$varref .= '[\''.$this->bloc_names[$i].'\']';
					$varref .='[$i[\''.$this->bloc_names[$i].'\']]';
				}

				$back = '<?php $count[\''.$nom.'\'] = ( isset('.$varref.'[\''.$nom.'\']) ) ? count('.$varref.'[\''.$nom.'\']) : 0; for($i[\''.$nom.'\']=0; $i[\''.$nom.'\']<$count[\'' .$nom. '\']; $i[\''.$nom.'\']++) { ';
			}
			$back .= 'if(isset(' .$blocs_parents. ')){ ?>';
		
		}
		else{
			// On remonte d'un niveau dans l'arborescence
			$this->bloc_parents_level--;
			// On ferme le bloc
			$back ='<?php }} ?>';
		}
		return $back;
	}
	
	// Assignation de variables à un fichier de tpl
	function assign_vars ( $var_array ){
		foreach ( $var_array AS $cle => $valeur ){
			$this->tpl_content['var'][$cle] = $valeur;
		}
		unset ( $var_array , $cle , $valeur );
	}

	// Assignation de variables à un fichier de tpl pour un bloc
	function assign_block_vars ( $bloc , $var_array ){

		// Si il n'y a pas de parents on assigne les variables directement
		if(!preg_match('!\.!', $bloc))
		{
			$this->tpl_donnees['bloc'][$bloc][] = $var_array;
		}
		else
		{
			// Si il y a des parents, on commence par recuperer l'arborescence de ces parents
			$liste_blocs = explode('.', $bloc);
			$count_blocs = count($liste_blocs) -1 ;
			$blocs = '$this->tpl_donnees[\'bloc\']';
			for($i=0; $i<$count_blocs; $i++)
			{
				$blocs .= '[\''.$liste_blocs[$i].'\']';
				eval('$count_blocs_parents = count('.$blocs.') - 1;' );
				$blocs .= '['.$count_blocs_parents.']';
			}
			// Puis on assigne les variables de ce bloc
			$blocs .= '[\''.$liste_blocs[$count_blocs].'\'][] = $var_array;';
			eval($blocs);
		}
	}
	
	// Génération de la page
	function gen(){
		// Recuperation des fichiers de template compilés et mis en cache ;)
		foreach ( $this->files AS $filename )
		{
			require ( $filename );
		}
		unset($filename);
	}
	
}
?>