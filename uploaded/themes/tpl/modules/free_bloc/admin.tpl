<!-- BEGIN index -->
	<p>
		<u>
			{index.BLOCS_DISPO}
		</u>
	</p>
	<table style="width: 99%;" border="0">
		<tr>
			<td style="width: 50%">
				{index.BLOC_NAME}
				<br /><br />
			</td>
			<td colspan="3">
				{index.BLOC_TYPE}
				<br /><br />
			</td>
		</tr>
	<!-- BEGIN index.bl -->
		<tr>
			<td>
				{index.bl.NAME}
			</td>
			<td>
				{index.bl.TYPE}
			</td>
			<td>
				<a href="./index.php?mods=free_bloc&amp;page=admin&amp;edit={index.bl.NM}&amp;{index.bl.EXT}&amp;name={index.bl.NNM}">{index.bl.EDIT}</a>
			</td>
			<td>
				<a href="./index.php?mods=free_bloc&amp;page=admin&amp;delete={index.bl.NM}&amp;{index.bl.EXT}&amp;name={index.bl.NNM}">{index.bl.DELETE}</a>
			</td>
		</tr>
	<!-- END index.bl -->
	<!-- BEGIN index.none -->
		<tr>
			<td colspan="4">
				{index.none.TXT}
			</td>
		</tr>
	<!-- END index.none -->
	</table>
	<br /><br />
	<a href="index.php?mods=free_bloc&amp;page=admin&amp;add">
		{index.ADD_BLOC}
	</a><br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN choix -->
	<p>
		<u>
			{choix.CHOOSE_BLOC_TYPE}
		</u>
	</p>
	<br />
	<a href="index.php?mods=free_bloc&amp;page=admin&amp;add&amp;free">
		{choix.BLOC_CODE}
	</a>
	<br /><br />
	<a href="index.php?mods=free_bloc&amp;page=admin&amp;add&amp;txt">
		{choix.BLOC_TXT}
	</a>
	<br /><br />
	<fieldset>
		<legend>
			{choix.DIFFERENCE_BETWEEN_CODE_AND_TXT}
		</legend>
		<br />
		{choix.DIFFERENCE_TXT}
		<br /><br />
	</fieldset>
	<br /><br />
	<a href="index.php?mods=free_bloc&amp;page=admin">
		{choix.BACK}
	</a>
<!-- END choix -->

<!-- BEGIN form_txt -->
	<p>
		<u>
			{form_txt.TXT}
		</u>
	</p>
	<form method="post" action="">
	<br />
		{form_txt.FORM}
	<br /><br />
	</form>
	<a href="{form_txt.URL}">
		{form_txt.BACK}
	</a>
<!-- END form_txt -->

<!-- BEGIN form_free -->
	<p>
		<u>
			{form_free.ADD_BLOC}
		</u>
	</p>
	<form method="post" action="">
		<br />
		<table style="width: 99%;" border="0">
			<tr>
				<td>
					{form_free.BLOC_NAME}
				<td>
					<input type="text" name="title" value="{form_free.BLOC_NAME_VALUE}"/>
				</td>
			</tr>
			<tr>
				<td>
					{form_free.BLOC_CODE}
				</td>
				<td>
					<textarea name="contenu" cols="30" rows="20">{form_free.BLOC_CODE_VALUE}</textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="submit" value="{form_free.VALID}" />
				</td>
			</tr>
		</table>
		<br /><br />
	</form>
	<a href="index.php?mods=free_bloc&amp;page=admin&amp;add">
		{form_free.BACK}
	</a>
<!-- END form_free -->