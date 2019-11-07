<!-- BEGIN index -->
	<form action="" method="post">
		<div style="overflow: auto;width:100%;">
			<center>
				<table style="width:95%;text-align:center;border-collapse: collapse;">
					<tr>
						<td>
							{index.MODULE} / {index.MIN_RANK}
							<br /><br />
						</td>
						<!-- BEGIN index.rank -->
							<td>
								{index.rank.TXT}
							</td>
						<!-- END index.rank -->
					</tr>
					<!-- BEGIN index.mod -->
						<tr>
							<td style="text-align:left;border: 1px solid black;">
								&nbsp;-&nbsp;{index.mod.NAME}
							</td>
							<!-- BEGIN index.mod.poss -->
								<td style="border: 1px solid black;">
									<input type="checkbox" name="{index.mod.poss.NAME}" {index.mod.poss.CHECKED} />
								</td>
							<!-- END index.mod.poss -->
						</tr>
					<!-- END index.mod -->
					<tr>
						<td colspan="5">
							<!-- BEGIN index.input -->
								<input type="hidden" name="mods_all" value="{index.input.VAR}" />
							<!-- END index.input -->
							<br /><center><input type="submit" value="{index.UPDATE}" /></center>
						</td>
					</tr>
				</table>
			</center>
		</div>
	</form>
	<br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN text -->
	{text.TXT}
	<br /><br />
	<a href="index.php?mods=admin&page=admin_mod">
		{text.BACK}
	</a>
<!-- END text -->