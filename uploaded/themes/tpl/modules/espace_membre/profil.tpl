<!-- BEGIN index -->
	<table width="100%">
		<tr>
			<td valign="top" style="width:60%">
				<fieldset>
					<legend>
						<b>
							{index.PERSO_INFO}
						</b>
					</legend>
					<table width="100%">
						<tr>
							<td valign="top">
								{index.PSEUDO} : {index.PSEUDO_VALUE} <img src="./themes/tpl/img/espace_membre/{index.IMAGE_SEXE}" alt="" /><br />
								{index.TITLE} : {index.TITLE_VALUE}<br />
								{index.AVATAR} : <img alt="{index.AVATAR_VALUE}" src="{index.AVATAR_VALUE}" width="{index.NEW_WIDTH}" height="{index.NEW_HEIGHT}" /><br />
								{index.GRADE} : 
								<span style="color:{index.GRADE_COLOR};">
									<b>
										{index.GRADE_NAME}
									</b>
								</span>
								<br />
								{index.INSCRIPTION_DATE} : {index.DATE_INSCRIPTION}<br />
								<!-- BEGIN index.loca -->
									{index.loca.TXT} : 
									<a href="http://maps.google.fr/maps?q={index.loca.VALUE}&amp;t=h" target="_blank">
										{index.loca.VALUE}
									</a>
									<br />
								<!-- END index.loca -->
								<!-- BEGIN index.nloca -->
									{index.nloca.TXT} : 
									<i>
										{index.nloca.NI}
									</i><br />
								<!-- END index.nloca -->
								<!-- BEGIN index.birth -->
									{index.birth.TXT} : {index.birth.VALUE}
								<!-- END index.birth -->
								<!-- BEGIN index.nbirth -->
									{index.nbirth.TXT} : 
									<i>
										{index.nbirth.NI}
									</i><br />
								<!-- END index.nbirth -->
							</td>
							<td align="right" valign="top">
								<img src="./themes/tpl/img/profil/info.png" alt="info" />
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>
						<b>
							{index.SIGNATURE}
						</b>
					</legend>
					<table width="100%">
						<tr>
							<td valign="top" style="padding-right: 5px">
								{index.SIGN_VALUE}
							</td>
							<td align="right" valign="top">
								<img src="./themes/tpl/img/profil/signature.png" alt="" />
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
			<td valign="top" style="width:40%">
				<fieldset>
					<legend>
						<b>
							{index.CONTACT}
						</b>
					</legend>
					<table width="100%">
						<tr>
							<td valign="top">
								<!-- BEGIN index.email -->
									{index.email.TXT} : 
									<a href="mailto:{index.email.EMAIL}">
										{index.email.MAIL}
									</a>
								<!-- END index.email -->
								<!-- BEGIN index.icq -->
									{index.icq.TXT} : 
									<a href="http://www.icq.com/whitepages/about_me.php?uin={index.icq.ADRESSE}" target="_blank">
										{index.icq.ADRESSE}
									</a><br />
								<!-- END index.icq -->
								<!-- BEGIN index.nicq -->
									{index.nicq.TXT} : <i>{index.nicq.NI}</i><br />
								<!-- END index.nicq -->
								<!-- BEGIN index.msn -->
									{index.msn.TXT} : {index.msn.ADRESSE}<br />
								<!-- END index.msn -->
								<!-- BEGIN index.nmsn -->
									{index.nmsn.TXT} : <i>{index.nmsn.NI}</i><br />
								<!-- END index.nmsn -->
								<!-- BEGIN index.aim -->
									{index.aim.TXT} : 
									<a href="aim:goim?screenname={index.aim.ADRESSE}&amp;message=Qui+es+tu?">
										{index.aim.ADRESSE}
									</a><br />
								<!-- END index.aim -->
								<!-- BEGIN index.naim -->
									{index.naim.TXT} : <i>{index.naim.NI}</i><br />
								<!-- END index.naim -->
								<!-- BEGIN index.yahoom -->
									{index.yahoom.TXT} : {index.yahoom.ADRESSE}<br />
								<!-- END index.yahoom -->
								<!-- BEGIN index.nyahoom -->
									{index.nyahoom.TXT} : <i>{index.nyahoom.NI}</i><br />
								<!-- END index.nyahoom -->
								<!-- BEGIN index.site -->
									{index.site.TXT} : 
									<a href="{index.site.URL}" target="_blank">
										{index.site.URL}
									</a><br />
								<!-- END index.site -->
								<!-- BEGIN index.nsite -->
									{index.nsite.TXT} : <i>{index.nsite.NI}</i><br />
								<!-- END index.nsite -->
							</td>
							<td align="right" valign="top">
								<img src="./themes/tpl/img/profil/contact.png" alt="contact" />
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>
						<b>
							{index.ACTIVITY}
						</b>
					</legend>
					{index.LAST_ACTIVITY} : {index.LAST_ACTIVITY_VALUE}<br />
					{index.LAST_POST} : {index.LAST_POST_VALUE}<br />
					{index.NB_POSTS} : {index.NB_POSTS_VALUE}<br />
					<!-- BEGIN index.reput -->
						{index.reput.PTS} : {index.reput.VALUE}<br />
					<!-- END index.reput -->
					{index.NB_AVERTISSEMENTS} : {index.AVERTISSEMENTS_VALUE}<br />
					{index.PARTICIPATION} : {index.PARTICIPATION_VALUE}%
				</fieldset>
			</td>
		</tr>
	</table>
	<fieldset>
		<legend>
			<strong>
				{index.ACTIVITY}
			</strong>
		</legend>
		<table>
			<tr>
				<td style="margin:0px">
					<a id="top1" href="javascript:aff_div('n1' , {index.ID} );">
						<img src="./mods/espace_membre/images/sujets.png" id="topic" alt="Sujets" border="0"/>
					</a>
				</td>
				<td style="margin:0px">
					<a id="rep" href="javascript:aff_div('n2' , {index.ID} );">
						<img src="./mods/espace_membre/images/replys.png" id="reply" alt="Reponses" border="0"/>
					<a>
				</td>
				<td style="margin:0px">
					<a id="com" href="javascript:aff_div('n3' , {index.ID} );">
						<img src="./mods/espace_membre/images/coms.png" id="commentaire" alt="com" border="0"/>
					<a>
				</td>
			</tr>
		</table><br/>	
		<div id="result"></div>
	</fieldset>
	{index.JS}
<!-- END index -->