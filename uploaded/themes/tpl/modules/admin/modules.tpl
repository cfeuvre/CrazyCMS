<!-- BEGIN index -->
	<br />
	<fieldset>
		<legend>
			{index.INSTALL_MOD}
		</legend>
		<br />
		<!-- BEGIN index.none_install -->
			{index.none_install.TXT}<br />
		<!-- END index.none_install -->
		<!-- BEGIN index.install -->
			<a href="{index.install.URL}">
				{index.install.MOD}
			</a><br />
		<!-- END index.install -->
		<br />
	</fieldset>
	<br /><br />
	<fieldset>
		<legend>
			{index.UNINSTALL_MOD}
		</legend>
		<!-- BEGIN index.none_uninstall -->
			{index.none_uninstall.TXT}<br />
		<!-- END index.none_uninstall -->
		<!-- BEGIN index.uninstall -->
			<a href="{index.uninstall.URL}">
				{index.uninstall.MOD}
			</a><br />
		<!-- END index.uninstall -->
		<br />
	</fieldset>
	<br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN text -->
	<br />{text.TXT}
	<br /><br />
	<a href="index.php?mods=admin&amp;page=modules">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN confirm -->
	<br />
	{confirm.SURE_TO_DEL} : 
		<b>
			{confirm.MOD}
		</b>
		<br /><br />
		<i>
			{confirm.THIS_WILL_DESTROY_DATA}
		</i>
		<br />
		<a href="index.php?mods=admin&amp;page=modules">
			{confirm.NO}
		</a> 
		{confirm.OR} 
		<a href="index.php?mods=admin&amp;page=modules&amp;uninstall={confirm.UNINSTALL}&amp;confirm=true">
			{confirm.YES}
		</a>
<!-- END confirm -->