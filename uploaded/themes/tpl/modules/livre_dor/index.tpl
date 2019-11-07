<!-- BEGIN index -->

	<center>
		<h2>
			<u>
				{index.LVOR_FROM} {index.NOM_SITE}
			</u>
		</h2>
	</center>
	<br /><br />

	<p style="text-align: center;" >
		<a href="index.php?mods=livre_dor&amp;page=poster">
		 | {index.POST_COMMENT} |
		</a>
	</p>
	
	<br />
	
	<div align="right">
		&raquo; {index.MIDDLE_MARK} : 
		<strong>
			{index.NOTE} / 10
		</strong>
	</div>
	
	<script type="text/javascript" src="./mods/ajax/real_time_edit.js"></script>

	<!-- BEGIN index.page -->
		<br /><br />
		<center>
			{index.page.PAGE} :
			<!-- BEGIN index.page.pg -->
				<a href="{index.page.pg.URL}">
					<font size="{index.page.pg.SIZE}px">
						{index.page.pg.NM}
					</font>
				</a> 
				<!-- BEGIN index.page.pg.etc -->
					...
				<!-- END index.page.pg.etc -->
			<!-- END index.page.pg -->
		</center>
	<!-- END index.page -->
	
	<br /><br />

	<!-- BEGIN index.none -->
		<center>
			<strong>
				{index.none.TXT}
			</strong>
		</center>
	<!-- END index.none -->

	<!-- BEGIN index.com -->
		<br />
		<fieldset>
			<legend>
				{index.com.MESS_FROM} 
				<strong>
					{index.com.PSEUDO}
				</strong> 
				{index.com.THE} {index.com.DATE} 
				<!-- BEGIN index.com.edit -->
					<a onclick="real_edit('lvor_{index.com.edit.IDLIV}','{index.com.edit.UID}','{index.com.edit.PASS}','{index.com.edit.IDLIV}','livredor', '{index.com.edit.NAVIG}','{index.com.edit.LANGUE}','{index.com.edit.THEME}' );return false;">
						[ {index.com.edit.EDIT} ]
					</a>
				<!-- END index.com.edit -->
			</legend>
				
			<div align="right">
				<strong>
					{index.com.NOTE} {index.com.ON_TEN}
				</strong>
			</div>
			<br />

			<div id="lvor_{index.com.IDLIV}">
				{index.com.COM}
			</div>
		</fieldset>
	<!-- END index.com -->
	
	<!-- BEGIN index.page -->
		<br /><br />
		<center>
			{index.page.PAGE} :
			<!-- BEGIN index.page.pg -->
				<a href="{index.page.pg.URL}">
					<font size="{index.page.pg.SIZE}px">
						{index.page.pg.NM}
					</font>
				</a> 
				<!-- BEGIN index.page.pg.etc -->
					...
				<!-- END index.page.pg.etc -->
			<!-- END index.page.pg -->
		</center>
	<!-- END index.page -->
	
	<br /><br />

	<p style="text-align: center;" >
		<a href="index.php?mods=livre_dor&amp;page=poster">
		 | {index.POST_COMMENT} |
		</a>
	</p>
<!-- END index -->