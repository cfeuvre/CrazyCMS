<!-- BEGIN index -->
	<fieldset>
		<legend>
			<strong>
				<font color="#c00000">
					{index.MENU}
				</font>
			</strong>
		</legend>
		<div align="right">
			<h2>
				{index.MY_BLOC_NOTE}
			</h2>
		</div>
		<p style="text-align:center;">
			<a href="index.php?mods=espace_membre&amp;page=note&amp;action=voir">
				<strong>
					{index.MY_NOTES}
				</strong>
			</a>
			&nbsp;|&nbsp;&nbsp;
			<a href="index.php?mods=espace_membre&amp;page=note&amp;action=notes">
				<strong>
					{index.WRITE_NOTE}
				</strong>
			</a>
		</p>
	</fieldset>
<!-- END index -->

<!-- BEGIN notes -->
	<fieldset>
		<legend>
			<strong>
				<font color="#c00000">
					{notes.FORM}
				</font>
			</strong>
		</legend>
		<br />
		<form method="post" action="index.php?mods=espace_membre&amp;page=note&amp;action=notes" name="notes">
			<table>
				<tr>
					<td>
						<strong>
							{notes.TITLE_NOTE} :
						</strong>
					</td>
					<td>
						<input type="text" size="50" name="notes_title" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{notes.CONTENT_NOTE} :
						</strong>
					</td>
					<td>
						{notes.CONTENU}
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
<!-- END notes -->

<!-- BEGIN confirm -->
	<fieldset>
		<legend>
			<strong>
				<font color="#c00000">
					{confirm.CONFIRMATION}
				</font>
			</strong>
		</legend>
		<p style="text-align:center;">
			{confirm.NOTE_SAVE}
		</p>
		<p style="text-align:center;">
			<a href="index.php?mods=espace_membre&amp;page=note">
				{confirm.BACK}
			</a>
		</p>
	</fieldset>
<!-- END confirm -->

<!-- BEGIN see -->
	<ul>
		<li>
			<a href="index.php?mods=espace_membre&amp;page=note&amp;action=look&amp;id={see.ID}">
				{see.TITLE}
			</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?mods=espace_membre&amp;page=note&amp;action=del&amp;id={see.ID}">
				( {see.DELETE} )
			</a>
		</li>
	</ul>
	<br />
	<hr width="50%" />
	<br />
<!-- END see -->

<!-- BEGIN none_note -->
	<p style="text-align:center;">
		<strong>
			{none_note.NO_NOTE}
		</strong>
		<br />
		{none_note.CLICK}
		 <a href="index.php?mods=espace_membre&amp;page=note&amp;action=notes">
			{none_note.HERE}
		</a>
		 {none_note.TO_POST_NOTE}
	</p>
<!-- END none_note -->

<!-- BEGIN del -->
	<fieldset>
		<legend>
			<strong>
				<font color="#c00000">
					{del.CONFIRMATION}
				</font>
			</strong>
		</legend>
		<p style="text-align:center;">
			{del.DELETED}
			<br />
			 {del.CLICK}
			<a href="index.php?mods=espace_membre&amp;page=note&amp;action=voir">
				 {del.HERE}
			</a>
			 {del.TO_BACK_NOTE}
		</p>
	</fieldset>
<!-- END del -->

<!-- BEGIN print -->
	<fieldset>
		<legend>
			<strong>
				<font color="#c00000">
					{print.NOTE}
				</font>
			</strong>
		</legend>
		<p style="text-align:center;">
			{print.TITLE}
		</p>
		<br /><br /><br />
		{print.CONTENU}
		<br /><br />
		<p style="text-align:center;">
			<a href="index.php?mods=espace_membre&amp;page=note&amp;action=voir">
				{print.BACK}
			</a>
			&nbsp;&nbsp;-&nbsp;&nbsp;
			<a href="javascript:window.print()">
				{print.TO_PRINT_THIS_MESS}
			</a>
		</p>
	</fieldset>
<!-- END print -->