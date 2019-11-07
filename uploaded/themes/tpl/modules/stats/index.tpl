<!-- BEGIN index -->
	<br />
	<a href="index.php?mods=stats&amp;navig">
		&raquo; {index.NAVIG}
	</a>
	<br />
	<a href="index.php?mods=stats&amp;date">
		&raquo; {index.PERIOD}
	</a>
	<br />
	<a href="index.php?mods=stats&amp;os">
		&raquo; {index.OS}
	</a>
	<br />
	<a href="index.php?mods=stats&amp;pays">
		&raquo; {index.PAYS}
	</a>
	<br />
	<a href="index.php?mods=stats&amp;theme">
		&raquo; {index.THEME}
	</a>
	<br />
	<a href="index.php?mods=stats&amp;pages">
		&raquo; {index.PAGE_DETAILS}
	</a>
<!-- END index -->

<!-- BEGIN page -->
	{page.NB_PAGES} : {page.NB_PAGES_VALUE}<br /><br />
	<table border="0" style="width:95%;">
	<!-- BEGIN page.pg -->
		<tr>
			<td>
				&raquo; {page.pg.NAME}
			</td>
			<td>
				{page.pg.VALUE}
			</td>
		</tr>
	<!-- END page.pg -->
	</table><br />
	<a href="./index.php?mods=stats">
		{page.BACK}
	</a>
<!-- END pages -->

<!-- BEGIN stats -->
	<br />
	<table width="95%" border="0">
		<!-- BEGIN stats.liste -->	
			<tr>
				<td width="40%">
					<!-- BEGIN stats.liste.pic -->
						<img src="{stats.liste.pic.PIC}" alt="" width="15" height=15"/>
					<!-- END stats.liste.pic -->
					{stats.liste.NAME} ( {stats.liste.VALUE}, {stats.liste.PERCENT}% )
				</td>
				<td width="60%">
					<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{stats.liste.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
				</td>
			</tr>
		<!-- END stats.liste -->
	</table>
	<br />
	<a href="index.php?mods=stats">
		{stats.BACK}
	</a>
<!-- END stats -->

<!-- BEGIN navig -->
	<br />
	<table width="95%" border="0">
		<!-- BEGIN navig.liste -->	
			<tr>
				<td width="40%">
					<img src="{navig.liste.PIC}" alt="" width="15" height=15"/>
					<a onclick="show_navig('details:{navig.liste.NAME}');">
						{navig.liste.NAME} ( {navig.liste.VALUE}, {navig.liste.PERCENT}% )
					</a>
				</td>
				<td width="60%">
					<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{navig.liste.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
				</td>
			</tr>
			<!-- BEGIN navig.liste.version -->
				<tr>
					<td colspan="2">
						<div id="details:{navig.liste.version.NAVIG}" style="visibility:hidden;height:0px;">
							<table border="0" width="95%">
								<!-- BEGIN navig.liste.version.vers -->
									<tr>
										<td width="40%">
											 &nbsp; &nbsp; &raquo; {navig.liste.version.vers.VERSION} ( {navig.liste.version.vers.VALUE}, {navig.liste.version.vers.PERCENT}% )
										</td>
										<td width="60%">
											<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{navig.liste.version.vers.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
										</td>
									</tr>
								<!-- END navig.liste.version.vers -->
							</table>	
						</div>
					</td>
				</tr>
			<!-- END navig.liste.version -->
		<!-- END navig.liste -->
	</table>
	<br />
	<a href="index.php?mods=stats">
		{navig.BACK}
	</a>
	{navig.JS}
<!-- END navig -->

<!-- BEGIN date -->
	<br />
	{date.SEE_IN}
	<!-- BEGIN date.years -->
		<a href="index.php?mods=stats&date&year={date.years.YEAR}">
		 : {date.years.YEAR}
		</a>
	<!-- END date.years -->
	<!-- BEGIN date.month -->
		<br />{date.month.SEE_IN}
		<!-- BEGIN date.month.m -->
			<a href="index.php?mods=stats&date&year={date.month.m.YEAR}&month={date.month.m.MONTH}">
				: {date.month.m.NAME}
			</a>
		<!-- END date.month.m -->
	<!-- END date.month -->
	<!-- BEGIN date.day -->
		<br />{date.day.SEE_IN}
		<!-- BEGIN date.day.d -->
			<a href="index.php?mods=stats&date&year={date.day.d.YEAR}&month={date.day.d.MONTH}&day={date.day.d.DAY}">
				: {date.day.d.DAY}
			</a>
		<!-- END date.day.d -->
	<!-- END date.day -->
	<br /><br />
	<a href="{date.URL}">
		{date.ALL_PERIOD}
	</a>
	<br /><br />
	{date.LAST_SEVEN_DAYS} :
	<br /><br />
	<u>
		{date.OS_STATS} :
	</u>
	<br /><br />
		<table width="95%" border="0">
		<!-- BEGIN date.os -->	
			<tr>
				<td width="40%">
					<!-- BEGIN date.os.pic -->
						<img src="{date.os.pic.PIC}" alt="" width="15" height=15"/>
					<!-- END date.os.pic -->
					{date.os.NAME} ( {date.os.VALUE}, {date.os.PERCENT}% )
				</td>
				<td width="60%">
					<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{date.os.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
				</td>
			</tr>
		<!-- END date.os -->
		</table>
	<br />
	<u>
		{date.PAYS} :
	</u><br /><br />
		<table width="95%" border="0">
		<!-- BEGIN date.pays -->	
			<tr>
				<td width="40%">
					{date.pays.NAME} ( {date.pays.VALUE}, {date.pays.PERCENT}% )
				</td>
				<td width="60%">
					<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{date.pays.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
				</td>
			</tr>
		<!-- END date.pays -->
		</table>
	<br /><br />
	<u>
		{date.THEME} :
	</u><br /><br />
		<table width="95%" border="0">
		<!-- BEGIN date.theme -->	
			<tr>
				<td width="40%">
					{date.theme.NAME} ( {date.theme.VALUE}, {date.theme.PERCENT}% )
				</td>
				<td width="60%">
					<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{date.theme.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
				</td>
			</tr>
		<!-- END date.theme -->
		</table>
	<br /><br />
	<u>
		{date.NAVIGS} :
	</u><br /><br />
	<table width="95%" border="0">
	<!-- BEGIN date.navig -->	
		<tr>
			<td width="40%">
				<img src="{date.navig.PIC}" alt="" width="15" height=15"/>
				<a onclick="show_navig('details:{date.navig.NAME}');">
					{date.navig.NAME} ( {date.navig.VALUE}, {date.navig.PERCENT}% )
				</a>
			</td>
			<td width="60%">
				<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{date.navig.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
			</td>
		</tr>
		<!-- BEGIN date.navig.version -->
			<tr>
				<td colspan="2">
					<div id="details:{date.navig.version.NAVIG}" style="visibility:hidden;height:0px;">
						<table border="0" width="95%">
							<!-- BEGIN date.navig.version.vers -->
								<tr>
									<td width="40%">
										 &nbsp; &nbsp; &raquo; {date.navig.version.vers.VERSION} ( {date.navig.version.vers.VALUE}, {date.navig.version.vers.PERCENT}% )
									</td>
									<td width="60%">
										<img src="./mods/stats/images/barre/left.png" height="10px" alt="" /><img src="./mods/stats/images/barre/central.png" height="10px" width="{date.navig.version.vers.SIZE}" alt="" /><img src="./mods/stats/images/barre/right.png" height="10px" alt="" /><br />
									</td>
								</tr>
							<!-- END date.navig.version.vers -->
						</table>	
					</div>
				</td>
			</tr>
		<!-- END date.navig.version -->
	<!-- END date.navig -->
	</table>
	{date.JS}
	<br />
	<a href="index.php?mods=stats">
		{date.BACK}
	</a>
<!-- END date -->