<!-- BEGIN theme -->
	{theme.JS}
	<fieldset>
		<legend>
			<strong>
				<font color="#c00000">
					{theme.THEME}
				</font>
			</strong>
		</legend>
		<div align="right">
			<h2>
				<strong>
					{theme.YOUR_THEME}
				</strong>
			</h2>
		</div>
		<form method="post" action="index.php?mods=espace_membre&amp;page=theme">
			<center>
				<strong>
					{theme.PLEASE_CHOOSE_THEME} :
				</strong>
				<select name="theme_choi" id="thm" onchange="update_img();" onkeyup="update_img();">
					<!-- BEGIN theme.thm -->
						<option value="{theme.thm.VALUE}" {theme.thm.SELECTED}>
							{theme.thm.VALUE}
						</option>
					<!-- END theme.thm -->
				</select>
			</center>
			<br /><br />
			<center>
				<img width="95%" id="preview" src="./themes/tpl/capture.jpg" alt="{theme.NONE_PREVIEW}" />
			</center>
			<br /><br />
			<center>
				<input type="submit" value="{theme.VALID}" />
				<input type="hidden" name="theme"  value="theme" />
			</center>
		</form>
	</fieldset>
<!-- END theme -->

<!-- BEGIN locked -->
	<br />
	{locked.TXT}
<!-- END locked -->