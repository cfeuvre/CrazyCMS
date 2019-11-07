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

class Mysql {
	//Ca c'est les vars
	var $host ;
	var $user;
	var $pass;
	var $base;
	var $sql_time;
	var $cache_time;
	var $connect_id = 0;
	
	var $cache_path = 'cache/cache';
	var $error;
	
	// Fonction pour incrementer un compteur de ms
	function time_calc ( $type ){

		$tmp_time = explode ( ' ' , $this->temp_time );
		$temp_end = explode ( ' ' , microtime() );
		$this->{$type} = $this->{$type} + ( $temp_end[1] - $tmp_time[1] ) + ( $temp_end[0] - $tmp_time[0] );
		return $this->{$type};
	
	}
	
	// Ca c'est un constructeur pour initialiser les variables(vive le tuto sur phpdebutant)
	function Mysql($Host='localhost', $User='root', $Pass='', $Base='') {
		$this->host=$Host;
		$this->user=$User;
		$this->pass=$Pass;
		$this->base=$Base;
		$this->nb = 0;
	}

	// Permet de retirer les elements dangereux d'une chaine ;)
	function secure($string){
	
		return mysql_escape_string($string);
	
	}
	
	//on se connecte
	function connect($Host, $User, $Pass, $Base) {
		$this->temp_time = microtime();
		$this->connect_id = @mysql_connect($Host, $User, $Pass);
		if ($this->connect_id) {
			if(mysql_select_db($Base, $this->connect_id)){
				$this->time_calc ( 'sql_time' );
				return $this->connect_id;
			}
			else{
				$this->error='Impossible de se connecter a la base : '.$this->base.'.';
				$this->time_calc ( 'sql_time' );
				die($this->return_error());
			}
		}
		else {
			$this->error='Impossible de se connecter au serveur '.$this->host.'.';
			$this->time_calc ( 'sql_time' );
			die($this->return_error());
		}
	}
	// retourne le même resultat que mysql_query et ca incrément le compteur de requette quand elle est bonne!
	function sql ( $query , $mod = 'cachemod' ){
		$this->temp_time = microtime();
		global $table_prefixe;
		$this->mod = $mod;
		if ( !$this->connect_id ) $this->connect($this->host,$this->user,$this->pass,$this->base);
		
		if ( $this->result_id = mysql_query($query, $this->connect_id) ) {
			$this->nb++;
			$this->query = trim($query);
			$this->error = '';
			
			$this->time_calc ( 'sql_time' );
			
			return $this->result_id;
		} 
		else {
			$this->error= mysql_error();
			
			$this->time_calc ( 'sql_time' );
			
			die('Erreur MySQL : <i>'.$this->return_error().'</i><br />Dans la requête : <i>'.$query.'</i>' );
		}
	}
	//on renvoi le message d'erreur
	function return_error() {
		return $this->error;
	}
	//Retourne le dernier id de la table aprés une insertion! La perle rare que j'ai tant cherché 
	function last_insert_id() {
		return @mysql_insert_id();
	}
	// renvoi le nombre d'enregistrement de la requette
	function num_rows($request) {
		return @count($request);
	}
	//mysql_fetch_object que j'aime bien :D
	function get_object($query) {
		return @mysql_fetch_object($query);
	}
	//retourne mysql_fetch_array avec par default le mode assoc
	function get_array($query, $mode='ASSOC') {
		switch($mode) {
			case 'NUMERIC' :
			return @mysql_fetch_array($query, MYSQL_NUM);
			break;
			case 'BOTH' :
			return @mysql_fetch_array($query, MYSQL_BOTH);
			break;
			case 'ASSOC' :
			return @mysql_fetch_assoc($query);
			break;
			default :
			return mysql_fetch_assoc($query);
		}
	}
	//ferme la connection;
	function close() {
		return mysql_close( $this->connect_id ) ;
	}
	//vide les resultat des requetes ! Trés pratique ;)
	function free_result() {
		return @mysql_free_result($this->connect_id);
	}
	// Renvoie le nombre de ligne renvoyées
	function get_num_rows($query){
		return @mysql_num_rows($query);
	}
	
	
/*
	FONCTIONS RELATIVES AU CACHE
*/
	
	// Utilise le cache pour renvoyer des données provenant de la bdd ;)
	function get_cached_data($request,$time=3600,$mod='cachemod') {
		$this->temp_time = microtime();
		$this->req = $request;
		$records = array();
		$this->request = $request;
		$this->time = $time;
		$this->mod = $mod;
		if(is_readable($this->cache_path.'/'.$mod.'/')){
			$this->cachename=$this->cache_path.'/'.$mod.'/'.md5($request).'.ini';
			
			if ( file_exists($this->cachename) && filemtime($this->cachename) > (time() - $time)) {
			
				$temp = parse_ini_file($this->cachename, true);
				foreach($temp as $id => $array){
				
					$sub_array = array();
				
					foreach($array as $nom => $valeur){

						$nom = base64_decode(str_replace('egaltorep' , '=',$nom));
						$valeur = base64_decode(str_replace('egaltorep' , '=',$valeur));
						$sub_array[$nom] = $valeur;
					
					}
					
					$records[$id] = $sub_array;
				}
			}
			else {
				if (!($this->result=$this->sql($request)))return FALSE;
				$a = 0;
				$ini = '';
				while ($record = $this->get_array($this->result) ) {
					$records[] = $record;
					$b = false;
					$ini .= '
						['.$a.']
					';
					foreach($record as $type => $value){
					
						$value = str_replace('=' , 'egaltorep',base64_encode($value));
						$type = str_replace('=' , 'egaltorep',base64_encode($type));
						$ini .= $type.' = '.$value.';
					';
						
						$b = true;
					}
					$a ++;
				}
				// On stocke requete dans un .ini
				$fp = fopen($this->cachename,"wb");
				@flock($fp,2);
				fputs($fp, $ini);
				@flock($fp,3);
				fclose($fp);
			}
			
			$this->time_calc ( 'cache_time' );
			return $records;
		}
		else{
		
			$this->time_calc ( 'cache_time' );
			
			if(mkdir($this->cache_path.'/'.$mod.'/')){
				return $this->get_cached_data($request,$time=3600,$mod);
			}
			else{
				$this->error='Le dossier '.$this->cache_path.'/'.$mod.'/'.' n\'existe pas.';
				die($this->return_error());
			}
		}
	}

	// Suprime des données du cache
	function delete_cached_data($mod='cachemod',$chemin=NULL){
	
		$this->temp_time = microtime();
		$chemin = $chemin.$this->cache_path.'/'.$mod;
		if ($chemin[strlen($chemin)-1] != '/') { $chemin .= '/'; } // rajoute '/'
			if (is_dir($chemin)) {
			$sq = @opendir($chemin); 
			while ($f = readdir($sq)) {
				if ($f != '.' && $f != '..'){
					$fichier = $chemin.$f; 
					if (is_dir($fichier)){
						delete_cached_data($fichier);
					}
					else{
						@unlink($fichier);
					}
				}
			}
			@closedir($sq);
                
        }
		else{
                @unlink($chemin);  
         }
		$this->time_calc ( 'cache_time' );
		return TRUE;
	}
	
/*
	FONCTIONS STATISTIQUES
		Temps de chargement, pourcentages, etc...
*/

	//Affiche le temps total de chargement
	function aff_time_total($vir='3'){
		global $time_start;
		
		$time_starts = explode ( ' ' , $time_start );
		$time_end = explode ( ' ' , microtime() );
		
		$this->ttim = ( $time_end[1] - $time_starts[1] ) + ( $time_end[0] - $time_starts[0] );
		
		return round ( $this->ttim , $vir );
	}
	// Affiche le temps de generation de php
	function aff_time_php($vir='3'){
		$this->time_php = $this->ttim - $this->sql_time - $this->cache_time;
		return round($this->time_php , $vir );
	}
	//affiche le temps de génération sql ca sert a rien mais bon :D
	function aff_sql_time($vir='3'){
		return round($this->sql_time,$vir);
	}
	//affiche le temps de génération cache ca sert a rien mais bon :D
	function aff_cache_time($vir='3'){
		return round($this->cache_time,$vir);
	}

	//Pourcentage PHP:
	function php_pourcent($vir="1"){
		
		$this->php_pourcent = 100 - ( $this->sql_pourcent() + $this->cache_pourcent() );
		
		return $this->php_pourcent;
		
	}
	//Pourcentage SQL :
	function sql_pourcent($vir="1"){
		$this->sql_pourcent = round($this->sql_time/($this->ttim/100),$vir);

		return $this->sql_pourcent;
	}
	//Pourcentage CACHE : 
	function cache_pourcent($vir="1"){
		$this->cache_pourcent = round($this->cache_time/($this->ttim/100),$vir);

		return $this->cache_pourcent;
	}
	
	//Renvoi le nb de requette
	function getNbrReq () {
		return $this->nb ;
   	}
	
	
}
?>
