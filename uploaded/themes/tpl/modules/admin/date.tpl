<!-- BEGIN text -->
	<br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN index -->
	<br />
	<b>
		<u>
			{index.DATE_SYNTAX} :
		</u>
	</b><br /><br />
	<form method="post" action="">
		<table style="width:95%;text-align:center;border-collapse: collapse;">
			<tr>
				<td colspan="5" style="border: 1px solid black;">
					{index.DATE_SYNTAX}
				</td>
				<td style="border: 1px solid black;">
					{index.SEPARATOR}<br />
					{index.DATE_HOUR}
				</td>
				<td style="border: 1px solid black;">
					{index.DATE_TYPE}
				</td>
				<td style="border: 1px solid black;">
					{index.HOUR_SEPARATOR}
				</td>
			</tr>
			<tr>
				<td style="border: 1px solid black;">
					<select name="first">
						<option value="d" {index.F1}>{index.DAY}</option>
						<option value="m" {index.F2}>{index.MONTH}</option>
						<option value="y" {index.F3}>{index.YEAR}</option>
					</select>
				</td>
				<td style="border: 1px solid black;">
					<select name="sep_first">
						<option value="/" {index.S1}>/</option>
						<option value="-" {index.S2}>-</option>
						<option value="|" {index.S3}>|</option>
						<option value="\" {index.S4}>\</option>
						<option value=":" {index.S5}>:</option>
						<option value=";" {index.S6}>;</option>
					</select>
				</td>
				<td style="border: 1px solid black;">
					<select name="second">
						<option value="d" {index.SE1}>{index.DAY}</option>
						<option value="m" {index.SE2}>{index.MONTH}</option>
						<option value="y" {index.SE3}>{index.YEAR}</option>
					</select>
				</td>
				<td style="border: 1px solid black;">
					<select name="sep_second">
						<option value="/" {index.SS1}>/</option>
						<option value="-" {index.SS2}>-</option>
						<option value="|" {index.SS3}>|</option>
						<option value="\" {index.SS4}>\</option>
						<option value=":" {index.SS5}>:</option>
						<option value=";" {index.SS6}>;</option>
					</select>
				</td>
				<td style="border: 1px solid black;">
					<select name="third">
						<option value="d" {index.T1}>{index.DAY}</option>
						<option value="m" {index.T2}>{index.MONTH}</option>
						<option value="y" {index.T3}>{index.YEAR}</option>
					</select>
				</td>
				<td style="border: 1px solid black;">
					<input type="text" size="7" name="center_text" value="{index.CENTER_SEP}"/>
				</td>
				<td style="border: 1px solid black;">
					<select name="type">
						<option value="24" {index.TT1}>24h</option>
						<option value="12" {index.TT2}>12h ( am / pm )</option>
					</select>
				</td>
				<td style="border: 1px solid black;">
					<select name="sep_last">
						<option value="/" {index.L1}>/</option>
						<option value="-" {index.L2}>-</option>
						<option value="|" {index.L3}>|</option>
						<option value="\" {index.L4}>\</option>
						<option value=":" {index.L5}>:</option>
						<option value=";" {index.L6}>;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="8">
					<center>
						<input type="submit" value="{index.VALID}" />
					</center>
				</td>
			</tr>
		</table>
	</form>
	{index.JS}
	<br />
	<form method="post" action="">
		<b>
			<u>
				{index.DEFAULT_FUSEAU} :
			</u>
		</b><br /><br />
		<table>
			<tr>
				<td>
					{index.TIME_ZONE}
				</td>
				<td>
					<select id="fuso" name="fuseau_def" onchange="change();">
						<!-- BEGIN index.option -->
							<option value="{index.option.ID}" {index.option.SELECTED}>
								GMT {index.option.ID}
							</option>
						<!-- END index.option -->
					</select>
				</td>
			</tr>
			<tr>
				<td>
					{index.PB_HOURS}
				</td>
				<td>
					<input type="checkbox" name="correction" value="1" id="winter" onclick="change();" {index.SUMMER_CHECK}/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<center>
						<input type=submit value="{index.VALID}" />
					</center>
				</td>
			</tr>
		</table>
	<br />
	<div id="actual">
		{index.WE_ARE} : {index.DATE}
	</div>
	<div id="general" style="visibility:hidden;overflow:auto;height:0px;">
		{index.DATE2}
	</div>
	<br /><br />
	</form>
	<br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->