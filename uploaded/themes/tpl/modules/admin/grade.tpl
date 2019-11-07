<!-- BEGIN index -->
	<br />
	<a href="./index.php?mods=admin&amp;page=grade&amp;add">
			{index.ADD_GRADE}
		</a><br /><br />
		<table style="width: 100%;text-align:center;">
			<tr>
				<td>
					{index.GRADE}<br /><br />
				</td>
				<td>
					{index.GRADE_NAME}<br /><br />
				</td>
				<td>
					{index.EDIT}<br /><br />
				</td>
				<td>
					{index.DELETE}<br /><br />
				</td>
			</tr>
			<!-- BEGIN index.grade -->
				<tr>
					<td>
						{index.grade.NBR}
					</td>
					<td>
						{index.grade.NAME}
					</td>
					<td>
						<!-- BEGIN index.grade.edit -->
							<a href="./index.php?mods=admin&amp;page=grade&amp;edit={index.grade.edit.ID}">
								{index.grade.edit.EDIT}
							</a>
						<!-- END index.grade.edit -->
						<!-- BEGIN index.grade.no_ed -->
							X
						<!-- END index.grade.no_ed -->
					</td>
					<td>
						<!-- BEGIN index.grade.del -->
							<a href="./index.php?mods=admin&amp;page=grade&amp;delete={index.grade.del.ID}">
								{index.grade.del.DELETE}
							</a>
						<!-- END index.grade.del -->
						<!-- BEGIN index.grade.no_del -->
							X
						<!-- END index.grade.no_del -->
					</td>
				</tr>
			<!-- END index.grade -->
		</table>
		<br /><br />
		<a href="./index.php?mods=admin&amp;page=grade&amp;add">
			{index.ADD_GRADE}
		</a>
		<br /><br />
		<a href="./index.php?mods=admin">
			{index.BACK}
		</a>
<!-- END index -->

<!-- BEGIN text -->
	<br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN form -->
	<br />
	<form method="post" action="">
		<table style="width:100%;">
			<tr>
				<td>
					{form.GRADE_NAME}
				</td>
				<td>
					<input type="text" name="name" value="{form.NAME_VALUE}"/><br /><br />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<u>{form.PERMS} :</u><br /><br />
				</td>
				<!-- BEGIN form.perm -->

					<tr>
						<td>
							{form.perm.DESC}
						</td>
						<td>
							<input type="checkbox" name="{form.perm.NAME}" value="1" {form.perm.CHECKED} />
						</td>
					</tr>
					<!-- BEGIN form.perm.sep -->
						<tr>
							<td colspan="2">
								<br /><hr /><br />
							</td>
						</tr>
					<!-- END form.perm.sep -->
				<!-- END form.perm -->
			<tr>
				<td colspan="2" style="text-align:center;">
					<br /><br />
					<input type="submit" value="{form.VALID}" />
				</td>
			</tr>
		</table>
	</form>
<!-- END form -->

<!-- BEGIN confirm -->
	<br /><br />
	{confirm.TXT}<br /><br />
		<a href="index.php?mods=admin&amp;page=grade">
			&raquo; {confirm.BACK}
		</a>
		<br /><br />
		<a href="index.php?mods=admin&amp;page=grade&amp;delete={confirm.ID}&amp;valid">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &raquo; {confirm.DELETE}
		</a>
<!-- END confirm -->