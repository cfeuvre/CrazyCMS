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

FICHIER CONTENANT ARRAY ET FONCTIONS DE LISTE DES OS, DES NAVIGATEURS ET DES PAYS
*/

// Fonction qui recupere le code navigateur du visiteur ;)
function load_navig($user_infos){

//Variable contenant le code du navigateur
$navig = '0|*|';

	//Si le navigateur est Ms IE
	if (eregi('MSIE[ \/]([0-9\.]+)', $user_infos,$ver))$navig = '1|*|'.$ver[1];
	if (eregi('Mozilla/([0-9.]+)', $user_infos, $version) || eregi('Mozilla', $user_infos)){
		//Si il est a base de moteur mozilla, on l'indique
		$navig = '2|*|';
		if (eregi('Firefox[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '3|*|'.$ver[1];
		if (eregi('netscape[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '4|*|'.$ver[1];
	}
	if (eregi('ICEBrowser[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '5|*|'.$ver[1];
	if (eregi('Konqueror[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '6|*|'.$ver[1];
	if (eregi('Opera[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '7|*|'.$ver[1];
	if (eregi('WebTv[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '8|*|'.$ver[1];
	if (eregi('Safari[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '9|*|'.$ver[1];
	if (eregi('Kanari[[:alnum:]]*[/\ ]([0-9.]+)', $user_infos,$ver))$navig = '10|*|'.$ver[1];
	if (eregi('bot', $user_infos))$navig = '11|*|';
	if (eregi('google', $user_infos))$navig = '12|*|';
	if (eregi('yahoo', $user_infos))$navig = '13|*|';
	if (eregi('altavista', $user_infos))$navig = '14|*|';
	if (eregi('msnbot', $user_infos))$navig = '15|*|';

	return $navig;
}

//Fonction qui recupere le code de l'OS
function load_os($user_infos){

	//Variable contenant le code dde l'os
	$os = '0';

	if (eregi('win', $user_infos)){
		$os = '1';
		if (eregi('(9x ?4\.90|Me)', $user_infos))$os = '2';
		if (eregi('98', $user_infos))$os = '3';
		if (eregi('2000', $user_infos))$os = '4';
		if (eregi('95', $user_infos))$os = '5';
		if (eregi('NT', $user_infos))$os = '6';
		if (eregi('NT [5]', $user_infos))$os = '7'; //Windows XP
		if (eregi('NT [6]', $user_infos))$os = '16'; //Windows Vista
		if (eregi('vista', $user_infos))$os = '16'; //Surment Vista
		if (eregi('longhorn', $user_infos))$os = '16'; // Surement premieres versions de Vista
	}
	if (eregi('debian', $user_infos))$os = '18';
	if (eregi('ux', $user_infos))$os = '8';
	if (eregi('SunOs', $user_infos))$os = '9';
	if (eregi('freebsd', $user_infos))$os = '10';
	if (eregi('openbsd', $user_infos))$os = '11';
	if (eregi('ubuntu', $user_infos))$os = '17';
	if (eregi('unix', $user_infos))$os = '12';
	if (eregi('mac', $user_infos))$os = '13';
	if (eregi('beos', $user_infos))$os = '14';
	if (eregi('bot', $user_infos))$os = '15';
	if(eregi('google',$user_infos))$os = '15';

	return $os;
}
$liste_navigators = array(
	"0" => mods_stats_unknow, 
	"1" => mods_stats_ie, 
	"2" => mods_stats_mozilla, 
	"3" => mods_stats_ff, 
	"4" => mods_stats_ns, 
	"5" => mods_stats_ib, 
	"6" => mods_stats_konqueror, 
	"7" => mods_stats_opera, 
	"8" => mods_stats_webtv, 
	"9" => mods_stats_safari, 
	"10" => mods_stats_kanari, 
	"11" => mods_stats_bots, 
	"12" => mods_stats_bot_google,
	"13" => mods_stats_yahoo, 
	"14" => mods_stats_altavista, 
	"15" => mods_stats_msn);

$liste_os = array(
	"0" => mods_stats_unknow, 
	"1" => mods_stats_windob, 
	"2" => mods_stats_windob_me, 
	"3" => mods_stats_windob_98, 
	"4" => mods_stats_windob_2000, 
	"5" => mods_stats_windob_95, 
	"6" => mods_stats_windob_nt, 
	"7" => mods_stats_windob_xp, 
	"8" => mods_stats_linux, 
	"9" => mods_stats_sunos, 
	"10" => mods_stats_freebsd, 
	"11" => mods_stats_openbsd,
	"12" => mods_stats_unix, 
	"13" => mods_stats_mac, 
	"14" => mods_stats_beos, 
	"15" => mods_stats_bot,
	'16' => mods_stats_vista,
	'17' => mods_stats_ubuntu,
	'18' => mods_stats_debian);

$liste_pays = array(
	'ac' => 'Ascension', 
	'ad' => 'Andorre', 
	'ae' => 'Emirats Arabes Unis', 
	'af' => 'Afghanistan', 
	'ag' => 'Antigua et Barbuda', 
	'ai' => 'Anguilla', 
	'al' => 'Albanie', 
	'am' => 'Armenie', 
	'an' => 'Antilles Neerlandaises', 
	'ao' => 'Angola', 
	'aq' => 'Antarctique', 
	'ar' => 'Argentine', 
	'as' => 'American Samoa', 
	'au' => 'Australie',
	'aw' => 'Aruba', 
	'az' => 'Azerbaijan', 
	'ba' => 'Bosnie Herzegovine', 
	'bb' => 'Barbade', 
	'bd' => 'Bangladesh', 
	'be' => 'Belgique', 
	'bf' => 'Burkina Faso', 
	'bg' => 'Bulgarie', 
	'bh' => 'Bahrain', 
	'bi' => 'Burundi', 
	'bj' => 'Benin', 
	'bm' => 'Bermudes', 
	'bn' => 'Brunei Darussalam', 
	'bo' => 'Bolivie', 
	'br' => 'Bresil', 
	'bs' => 'Bahamas', 
	'bt' => 'Bhoutan', 
	'bv' => 'Bouvet (ile)', 
	'bw' => 'Botswana', 
	'by' => 'Bielorussie', 
	'bz' => 'Belize', 
	'ca0' => 'Canada', 
	'ca' => 'Canada', 
	'ca1' => 'Canada', 
	'ca2' => 'Canada', 
	'ca3' => 'Canada', 
	'ca4' => 'Canada', 
	'cc' => 'Cocos iles', 
	'cd' => 'Congo', 
	'cf' => 'Centrafrique', 
	'cg' => 'Congo', 
	'ch' => 'Suisse', 
	'ci' => 'Cote d\'Ivoire', 
	'ck' => 'Cook (iles)', 
	'cl' => 'Chili', 
	'cm' => 'Cameroun', 
	'cn' => 'Chine', 
	'co' => 'Colombie', 
	'cr' => 'Costa Rica', 
	'cu' => 'Cuba', 
	'cv' => 'Cap Vert', 
	'cx' => 'Christmas (ile)', 
	'cy' => 'Chypre', 
	'cz' => 'Republique Tcheque', 
	'de' => 'Allemagne', 
	'dj' => 'Djibouti', 
	'dk' => 'Danemark', 
	'dm' => 'Dominique', 
	'do' => 'Dominique', 
	'dz' => 'Algerie', 
	'ec' => 'Equateur', 
	'ee' => 'Estonie', 
	'eg' => 'Egypte', 
	'eh' => 'Sahara Occidental', 
	'er' => 'Erythree', 
	'es' => 'Espagne', 
	'et' => 'Ethiopie', 
	'fi' => 'Finlande', 
	'fj' => 'Fiji', 
	'fk' => 'Falkland iles', 
	'fo' => 'Faroe (iles)', 
	'fr' => 'France', 
	'ga' => 'Gabon', 
	'gd' => 'Grenade', 
	'ge' => 'Georgie', 
	'gg' => 'Guernsey', 
	'gh' => 'Ghana', 
	'gi' => 'Gibraltar', 
	'gl' => 'Groenland', 
	'gm' => 'Gambie', 
	'gn' => 'Guinee', 
	'gp' => 'Guadeloupe', 
	'gq' => 'Guinee Equatoriale', 
	'gr' => 'Grece', 
	'gs' => 'Georgie du sud et iles Sandwich du sud', 
	'gt' => 'Guatemala', 
	'gu' => 'Guam', 
	'gy' => 'Guyana', 
	'hk' => 'Hong Kong', 
	'hm' => 'Heard et McDonald (iles)', 
	'hn' => 'Honduras', 
	'hr' => 'Croatie', 
	'ht' => 'Haiti', 
	'hu' => 'Hongrie', 
	'id' => 'Indonesie', 
	'ie' => 'Irlande', 
	'il' => 'Israel', 
	'im' => 'Ile de Man', 
	'in' => 'Inde', 
	'iq' => 'Iraque', 
	'ir' => 'Iran', 
	'is' => 'Islande', 
	'it' => 'Italie', 
	'je' => 'Jersey', 
	'jm' => 'Jamaique', 
	'jo' => 'Jordanie', 
	'jp' => 'Japon', 
	'ke' => 'Kenya', 
	'kg' => 'Kirgizstan', 
	'kh' => 'Cambodge', 
	'ki' => 'Kiribati', 
	'km' => 'Comores', 
	'kn' => 'Saint Kitts et Nevis', 
	'kp' => 'Coree du nord', 
	'kr' => 'Coree du sud', 
	'kw' => 'Koweit', 
	'ky' => 'Caimanes (iles)', 
	'kz' => 'Kazakhstan', 
	'la' => 'Laos', 
	'lb' => 'Liban', 
	'lc' => 'Sainte Lucie', 
	'li' => 'Liechtenstein', 
	'lk' => 'Sri Lanka', 
	'lr' => 'Liberia', 
	'ls' => 'Lesotho', 
	'lt' => 'Lituanie', 
	'lu' => 'Luxembourg', 
	'lv' => 'Latvia', 
	'ly' => 'Libie', 
	'ma' => 'Maroc', 
	'mc' => 'Monaco', 
	'md' => 'Moldavie', 
	'mg' => 'Madagascar', 
	'mh' => 'Marshall (iles)', 
	'mk' => 'Macedoine',
	'ml' => 'Mali', 
	'mm' => 'Myanmar', 
	'mn' => 'Mongolie', 
	'mo' => 'Macao', 
	'mp' => 'Mariannes du nord (iles)', 
	'mq' => 'Martinique', 
	'mr' => 'Mauritanie', 
	'ms' => 'Montserrat', 
	'mt' => 'Malte', 
	'mu' => 'Maurice (ile)', 
	'mv' => 'Maldives', 
	'mw' => 'Malawi', 
	'mx' => 'Mexique', 
	'my' => 'Malaisie', 
	'mz' => 'Mozambique', 
	'na' => 'Namibie', 
	'ne' => 'Niger', 
	'nf' => 'Norfolk (ile)', 
	'ng' => 'Nigeria',
	'ni' => 'Nicaragua', 
	'nl' => 'Pays Bas', 
	'no' => 'Norvege', 
	'np' => 'Nepal', 
	'nr' => 'Nauru', 
	'nu' => 'Niue', 
	'om' => 'Oman', 
	'pa' => 'Panama', 
	'pe' => 'Perou', 
	'pg' => 'Papouasie Nouvelle Guinee', 
	'ph' => 'Philippines', 
	'pk' => 'Pakistan', 
	'pl' => 'Pologne', 
	'pm' => 'St. Pierre et Miquelon', 
	'pn' => 'Pitcairn (ile)', 
	'pr' => 'Porto Rico', 
	'pt' => 'Portugal', 
	'pw' => 'Palau', 
	'py' => 'Paraguay', 
	'qa' => 'Qatar', 
	're' => 'Reunion (ile)', 
	'ro' => 'Roumanie', 
	'ru' => 'Russie', 
	'rw' => 'Rwanda', 
	'sa' => 'Arabie Saoudite', 
	'sb' => 'Salomon (iles)', 
	'sc' => 'Seychelles', 
	'sd' => 'Soudan', 
	'se' => 'Suede', 
	'sg' => 'Singapour', 
	'sh' => 'St. Helene', 
	'si' => 'Slovenie', 
	'sj' => 'Svalbard et Jan Mayen', 
	'sk' => 'Slovaquie', 
	'sl' => 'Sierra Leone', 
	'sm' => 'Saint Marin', 
	'sn' => 'Senegal', 
	'so' => 'Somalie', 
	'sr' => 'Suriname', 
	'st' => 'Sao Tome et Principe', 
	'sv' => 'Salvador', 
	'sy' => 'Syrie', 
	'sz' => 'Swaziland', 
	'td' => 'Tchad', 
	'tg' => 'Togo', 
	'th' => 'Thailande', 
	'tj' => 'Tajikistan',
	'tk' => 'Tokelau', 
	'tm' => 'Turkmenistan', 
	'tn' => 'Tunisie', 
	'to' => 'Tonga', 
	'tp' => 'Timor Oriental', 
	'tr' => 'Turquie', 
	'tt' => 'Trinidad et Tobago', 
	'tv' => 'Tuvalu', 
	'tw' => 'Taiwan', 
	'tz' => 'Tanzanie', 
	'ua' => 'Ukraine', 
	'ug' => 'Ouganda', 
	'uk' => 'Royaume Uni', 
	'gb' => 'Royaume Uni', 
	'um' => 'US Minor Outlying (iles)', 
	'us' => 'Etats Unis', 
	'us0' => 'Etats Unis', 
	'us1' => 'Etats Unis', 
	'us2' => 'Etats Unis', 
	'us3' => 'Etats Unis', 
	'us4' => 'Etats Unis', 
	'uy' => 'Uruguay', 
	'uz' => 'Ouzbekistan', 
	'va' => 'Vatican', 
	'vc' => 'Saint Vincent et les Grenadines', 
	've' => 'Venezuela', 
	'vg' => 'Vierges Britaniques (iles)', 
	'vi' => 'Vierges USA (iles)', 
	'vu' => 'Vanuatu', 
	'wf' => 'Wallis et Futuna (iles)', 
	'ws' => 'Samoa', 
	'ye' => 'Yemen', 
	'yt' => 'Mayotte', 
	'yu' => 'Yugoslavie', 
	'za' => 'Afrique du Sud', 
	'zm' => 'Zambie', 
	'zr' => 'Zaire', 
	'zw' => 'Zimbabwe', 
	'at' => 'autriche', 
	'cs' => 'serbie', 
	'ps' => 'palestine', 
	'lc' => 'Sainte Lucie', 
	'fm' => 'Micronésie',
	'gf' => 'Guyane Francaise', 
	'gw' => 'Guinée-Bissau',
	'io' => 'Territoire Britannique de l\'Océan Indien',
	'nc' => 'Nouvelle Calédonie',
	'nz' => 'Nouvelle Zelande', 
	'pf' => 'Polynésie Francaise',
	'tc' => 'Iles Turks et Caiques', 
	'tf' => 'Territoires Francais du sud', 
	'vn' => 'Vietnam',
	'unknown' => 'Pays non localisé');

?>