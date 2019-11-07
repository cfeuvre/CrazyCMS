<!-- BEGIN text -->
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN index -->
	<form action="index.php?mods=espace_membre&amp;page=param&amp;valid" method="post" >
		<table>
			<tr>
				<td>
					{index.TIME_SONE}
				</td>
				<td>
					<select name="fuso" id="fuso" onchange="change();">
						<!-- BEGIN index.fuseau -->
							<option value="{index.fuseau.I}" {index.fuseau.SELECTED}>
								GMT {index.fuseau.I}
							</option>
						<!-- END index.fuseau -->
					</select>
				</td>
			</tr>
			<tr>
				<td>
					{index.PB_HOURS}
				</td>
				<td>
					<input type="checkbox" name="correction" id="winter" onclick="change();" {index.CHECKED}/>
				</td>
			</tr>
			<tr>
				<td>
					<input type=submit value="{index.VALID}" />
				</td>
			</tr>
		</table>
	</form>
	{index.JS}
	<br />
	<br />
	{index.CURRENT_HOUR} : 
	<br /><br />
	<div id="actual">
		{index.WE_ARE_ON} : {index.TIME}
	</div>
	<div id="general" style="visibility:hidden;overflow:auto;height:0px;">
		{index.GM_TIME}
	</div>

	<br /><br />
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
	<br />
	<b>
		<u>
			{index.PARAMS} :
		</u>
	</b><br />
	<br />
	<form method="post" action="">
		<table border="0" style="text-align: center;width:95%;">
			<tr>
				<td>
					{index.APPEAR_OFFLINE}
				</td>
				<td>
					<input type="radio" name="appear_offline" value="0" {index.AO_CHECKED} />{index.NO}
				</td>
				<td>
					<input type="radio" name="appear_offline" value="1" {index.AO_CHECKED1} />{index.YES}
				</td>
			</tr>
			<tr>
				<td colspan="3">
					{index.HIDE_INFOS}
				</td>
			</tr>
			<tr>
				<td>
					{index.EMAIL}
				</td>
				<td>
					<input type="radio" name="email" value="0" {index.E_CHECKED} />{index.PRINT}
				</td>
				<td>
					<input type="radio" name="email" value="1" {index.E_CHECKED1}/>{index.HIDE}
				</td>
			</tr>
			<tr>
				<td>
					{index.MSN}
				</td>
				<td>
					<input type="radio" name="msn" value="0" {index.MSN_CHECKED} />{index.PRINT}
				</td>
				<td>
					<input type="radio" name="msn" value="1" {index.MSN_CHECKED1} />{index.HIDE}
				</td>
			</tr>
			<tr>
				<td>
					{index.ICQ}
				</td>
				<td>
					<input type="radio" name="icq" value="0" {index.ICQ_CHECKED} />{index.PRINT}
				</td>
				<td>
					<input type="radio" name="icq" value="1" {index.ICQ_CHECKED1} />{index.HIDE}
				</td>
			</tr>
			<tr>
				<td>
					{index.YAHOOM}
				</td>
				<td>
					<input type="radio" name="yahoom" value="0" {index.YAHOOM_CHECKED} />{index.PRINT}
				</td>
				<td>
					<input type="radio" name="yahoom" value="1" {index.YAHOOM_CHECKED1} />{index.HIDE}
				</td>
			</tr>
			<tr>
				<td>
					{index.AIM}
				</td>
				<td>
					<input type="radio" name="aim" value="0" {index.AIM_CHECKED} />{index.PRINT}
				</td>
				<td>
					<input type="radio" name="aim" value="1" {index.AIM_CHECKED1} />{index.HIDE}
				</td>
			</tr>
			<tr>
				<td>
					{index.BIRTHDAY}
				</td>
				<td>
					<input type="radio" name="birth" value="0" {index.BIRTHDAY_CHECKED} />{index.PRINT}
				</td>
				<td>
					<input type="radio" name="birth" value="1" {index.BIRTHDAY_CHECKED1} />{index.HIDE}
				</td>
			</tr>
			<tr>
				<td>
					{index.LOCALISATION}
				</td>
				<td>
					<input type="radio" name="localisation" value="0" {index.LOCA_CHECKED} />{index.PRINT}
				</td>
				<td>
					<input type="radio" name="localisation" value="1" {index.LOCA_CHECKED1} />{index.HIDE}
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center;">
					<input type="submit" value="{index.VALID}" />
				</td>
			</tr>
		</table>
	</form>
<!-- END index -->