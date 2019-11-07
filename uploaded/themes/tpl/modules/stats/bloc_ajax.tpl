<!-- BEGIN bloc -->
	&nbsp; {bloc.VISITES} {bloc.VISITES_TXT}
	<br /><br />
	&nbsp; {bloc.USER} {bloc.USER_TXT}
	<br /><br />
	&nbsp; {bloc.VISITES_TODAY} {bloc.VISITES_TODAY_TXT}
	<br /><br />
	&nbsp; {bloc.PAGES_VUES} {bloc.PAGES_VUES_TXT}
	<!-- BEGIN bloc.visiteurs -->
		<br /><br />
		&nbsp; {bloc.visiteurs.VALUE} {bloc.visiteurs.TXT}
	<!-- END bloc.visiteurs -->
	<!-- BEGIN bloc.users -->
		<br /><br />
		<a href="javascript:show_record('memberlist');">
			<!-- BEGIN bloc.users.value -->
				{bloc.users.value.VALUE}
			<!-- END bloc.users.value -->
			{bloc.users.TXT}
		</a>
		<br /><br />
		<div id="memberlist">
			<!-- BEGIN bloc.users.user -->
				<img src="{bloc.users.user.URL}" alt="{bloc.users.user.ALT}" />
				<a href="index.php?mods=espace_membre&amp;page=profil&amp;id={bloc.users.user.ID}">
					{bloc.users.user.PSEUDO}
				</a>
				<br />
			<!-- END bloc.users.user -->
			<br />
		</div>
	<!-- END bloc.users -->
	 <a href="javascript:show_record('stats_tot');">
		{bloc.SEE_RECORDS}
	</a>
	<div id="stats_tot">
		<br />
		&raquo; {bloc.CONNECTED_MEMBERS} {bloc.RECORD_MBR},<br />
		&nbsp;&nbsp;&nbsp;- {bloc.THE} {bloc.RECORD_MBR_DATE}<br /><br />
		&raquo; {bloc.CONNECTED_GUESTS} {bloc.RECORD_GUEST},<br />
		&nbsp;&nbsp;&nbsp;- {bloc.THE} {bloc.RECORD_GUEST_DATE}<br/><br />
		&raquo; {bloc.VISITES_TXT} : {bloc.RECORD_VISITES},<br />
		&nbsp;&nbsp;&nbsp;- {bloc.THE} {bloc.RECORD_VISITES_DATE}<br/>
	</div>
	<br />
	<a href="index.php?mods=stats">
		{bloc.MORE_STATS}
	</a>
<!-- END bloc -->