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

class Class_Forum {

	var $query;
	var $sql;
	var $sql_topic;
	var $permis;
	var $redir;

	// Fonction pour recalculer les derniers messages lors suppressions, deplacement, etc ...
	function give_lastmess($forum_parent=0,$topic_parent=0,$only_top=0,$forbid = 0,$rep_id=0){

		global $Bdd;

		// On regarde si on doit partir d'une reponse ou d'un sujet
		if($topic_parent != 0){
			// On recupere le lastmess a appliquer au topic parent ;)

			$this->query = $Bdd->sql('SELECT '.PT.'_forum_reply.date as date, '.PT.'_users.pseudo as pseudo FROM '.PT.'_users, '.PT.'_forum_topic, '.PT.'_forum_reply WHERE '.PT.'_users.id = '.PT.'_forum_reply.auteur AND '.PT.'_forum_reply.parent = "'.$topic_parent.'" '.( ($forbid!=0) ? ('AND '.PT.'_forum_reply.id != "'.$forbid.'" ') : ('') ).'ORDER BY date DESC LIMIT 0,1' );

			$this->sql = $Bdd->get_array($this->query);

			$this->last_mess = str_replace('|*--*|' , '|*- -*|',$Bdd->secure($this->sql['pseudo'])).'|*--*|'.$this->sql['date'];

			$Bdd->free_result($this->query);

			return $this->last_mess;

		}
		else if($forum_parent != 0){

			if($only_top==0){
				// On recupere le lastmess à appliquer aux forums parents
				// On recupere le lastmess en cherchant parmis les reponses
				$this->query = $Bdd->sql('SELECT '.PT.'_forum_reply.parent as id, '.PT.'_forum_topic.nom as nom, '.PT.'_forum_reply.date as date, '.PT.'_users.pseudo as pseudo FROM '.PT.'_forum_reply, '.PT.'_forum_topic, '.PT.'_users WHERE '.PT.'_forum_topic.parent="'.$forum_parent.'" AND '.PT.'_forum_reply.parent = '.PT.'_forum_topic.id AND '.PT.'_users.id = '.PT.'_forum_reply.auteur '.( ($forbid!=0) ? ('AND '.PT.'_forum_topic.id != "'.$forbid.'" ') : ('') ).'ORDER BY '.PT.'_forum_reply.date DESC LIMIT 0,1' );
				// Puis on cherche dans les topics

				$this->query_topic = $Bdd->sql('SELECT '.PT.'_forum_topic.id as id, '.PT.'_forum_topic.nom as nom, '.PT.'_forum_topic.date as date, '.PT.'_users.pseudo as pseudo FROM '.PT.'_forum_topic, '.PT.'_users WHERE '.PT.'_forum_topic.parent="'.$forum_parent.'" AND '.PT.'_users.id = '.PT.'_forum_topic.auteur ORDER BY '.PT.'_forum_topic.date DESC LIMIT 0,1' );

				$this->sql = $Bdd->get_array($this->query);

				$this->sql_topic = $Bdd->get_array($this->query_topic);
				if($this->sql['date']>$this->sql_topic['date']){
					$this->last_mess = str_replace('|*--*|' , '|*- -*|',$Bdd->secure($this->sql['pseudo'])).'|*--*|'.$this->sql['date'].'|*--*|'.$this->sql['id'].'&amp;last_page#r-'.$rep_id.'|*--*|'.str_replace('|*--*|' , '|*- -*|',$Bdd->secure($this->sql['nom']));
				}
				else{
					$this->last_mess = str_replace('|*--*|' , '|*- -*|',$Bdd->secure($this->sql_topic['pseudo'])).'|*--*|'.$this->sql_topic['date'].'|*--*|'.$this->sql_topic['id'].'&amp;last_page#r-'.$rep_id.'|*--*|'.str_replace('|*--*|' , '|*- -*|',$Bdd->secure($this->sql_topic['nom']));
				}
				$Bdd->free_result($this->query);
				$Bdd->free_result($this->query_topic);
			}
			else{
				// On recupere le lastmess à appliquer aux forums parents
				$this->query = $Bdd->sql('SELECT '.PT.'_forum_topic.id as id, '.PT.'_forum_topic.nom as nom, '.PT.'_forum_topic.date as date, '.PT.'_users.pseudo as pseudo FROM '.PT.'_forum_topic, '.PT.'_users WHERE '.PT.'_forum_topic.parent="'.$forum_parent.'" AND '.PT.'_users.id = '.PT.'_forum_topic.auteur '.( ($forbid!=0) ? ('AND '.PT.'_forum_topic.id != "'.$forbid.'" ') : ('') ).'ORDER BY '.PT.'_forum_topic.date DESC LIMIT 0,1' );
				$this->sql = $Bdd->get_array($this->query);

				$this->last_mess = str_replace('|*--*|' , '|*- -*|',$Bdd->secure($this->sql['pseudo'])).'|*--*|'.$this->sql['date'].'|*--*|'.$this->sql['id'].'&amp;last_page#r-'.$rep_id.'|*--*|'.str_replace('|*--*|' , '|*- -*|',$Bdd->secure($this->sql['nom']));
				$Bdd->free_result($this->query);
			}
			return $this->last_mess;

		}

	}

	// Fonction pour donner le rang de l'utilisateur en question
	function give_rank ( $nb_posts ){

		global $Bdd;

		$this->ranks = '';

		// Si on a deja recupere le tableau des rangs, on cherche le bon rang dedans
		if ( isset ( $this->forum_rank_array ) ){

			foreach ( $this->forum_rank_array AS $array ){

				// On récupère le rang associé au nombre de post de l'utilisateur ;)
				if ( $nb_posts >= $array['nb_posts'] )
					$this->ranks = $array['name'];

			}

		}
		else{
			// Sinon, on recupere tous les rangs dispo déja ;)
			$this->forum_rank_array = array ();

			$this->query = $Bdd->get_cached_data ( 'SELECT nb_posts, name FROM '.PT.'_forum_ranks ORDER BY nb_posts ASC' , 86400 , 'forum' );
			foreach ( $this->query AS $array ){

				$this->forum_rank_array [ ] = array ( 'name' => $array [ 'name' ], 'nb_posts' => $array['nb_posts'] );

				// On récupère le rang associé au nombre de post de l'utilisateur ;)
				if ( $nb_posts >= $array['nb_posts'] )
					$this->ranks = $array['name'];

			}

		}

		return stripslashes ( $this->ranks );

	}

	// Fonction pour determiner si un utilisateur est moderateur du forum ;)
	function is_mod ( $modos_forum ){

		global $grade_3, $uid;
		$this->ismod = FALSE;
		$this->perms = '';

		$modos = explode ( ',' , $modos_forum );

		if ( in_array ( $uid , $modos ) ){
			$this->ismod = TRUE;
			$this->perms = $grade_3['permissions'];
		}



		return array ( 'is_mod' => $this->ismod , 'perms' => $this->perms );

	}

	// Fonction pour vérifier les autorisations de suppressions, d'edit, ...
	function give_permissions($permissions,$grade,$requis_1,$requis_2,$type=1, $auteur =''){

		$this->permis = FALSE;

		global $uid;
		if($type==1){
			// Si il a permission globale
			if( eregi(';'.$requis_1.';',$permissions ) || eregi('^'.$requis_1.';',$permissions) || $grade==4){
				$this->permis = TRUE;
			}
			elseif(eregi(';'.$requis_2.';',$permissions ) || eregi('^'.$requis_2.';',$permissions)){
			// Si il a permission limite a ses propres messages, on verifie que le message est bien de lui
				if($auteur==$uid && $uid!=0){
					$this->permis = TRUE;
				}

			}
		}
		return $this->permis;
	}

	function verif_groupes ( $groupes , $ecriture , $lecture = true , $ecrit = true){

		global $groupe;
		global $grade;

		if ( $grade != 4 ){

			$grpes = false;

			if ( ereg ( '^0;' , $groupes ) || ereg ( ';0;' , $groupes ) || ereg ( '^0;' , $ecriture ) || ereg ( ';0;' , $ecriture )){
				$grpes = true;
			}
			else{

				if ( $lecture === true ){
					$grp_arr = explode ( ';' , $groupes );
					foreach ( $grp_arr as $grp ){
						if ( $grp != '' ){
							if ( ereg ( '^'.$grp.';' , $groupe ) || ereg ( ';'.$grp.';' , $groupe ) ){
								$grpes = true;
							}
						}
					}
				}

				if ( $grpes === false && $ecrit === true ){
					$grp_arr = explode ( ';' , $ecriture );
					foreach ( $grp_arr as $grp ){
						if ( $grp != '' ){
							if ( ereg ( '^'.$grp.';' , $groupe ) || ereg ( ';'.$grp.';' , $groupe ) ){
								$grpes = true;
							}
						}
					}
				}

			}

		}
		else{
			$grpes = true;
		}

		return $grpes;
	}

	// Fonction pour rediriger l'utilisateur
	function redir($url,$time=2500){
		$this->redir = '
			<script type="text/javascript">
				<!--
					function redir(){
						window.location.href = "'.$url.'";
					}
					setTimeout("redir()",'.$time.' );
				-->
			</script>';
		echo $this->redir;
	}

}
?>