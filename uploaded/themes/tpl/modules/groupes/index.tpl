<!-- BEGIN text -->
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN list -->
	<a href="index.php?mods=groupes&amp;id={list.ID}">
		{list.NOM} ( {list.NB_USER} {list.MEMBERS} )
	</a>
	<br/>
	{list.DESCRIPTION}
	<br/><br/>
<!-- END list -->

<!-- BEGIN see -->
	<!-- BEGIN see.mb -->
		&raquo; {see.mb.PSEUDO}<br />
	<!-- END see.mb -->
	<!-- BEGIN see.join -->
		<p align="center">
			<a href="index.php?mods=groupes&amp;id={see.join.ID}&amp;join">
				{see.join.JOIN}
			</a>
		</p>
	<!-- END see.join -->
<!-- END see -->