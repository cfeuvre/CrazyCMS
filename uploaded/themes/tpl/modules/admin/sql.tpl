<!-- BEGIN index -->
	<br />
	&raquo; <a href="index.php?mods=admin&amp;page=sql&opti">
		{index.OPTIMIZE_ALL_TABLE}
	</a>
	<br /><br />
	&raquo; <a href="index.php?mods=admin&amp;page=sql&amp;admin_sql">
		{index.MANAGE_BDD}
	</a><br /><br />
	&raquo; <a href="index.php?mods=admin&amp;page=sql&amp;admin_sql&amp;export=all">
		{index.EXPORT_BDD}
	</a>
	<br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN opti -->
	<!-- BEGIN opti.tb -->
		&raquo; {opti.tb.THE_TABLE} {opti.tb.NAME} {opti.tb.HAS_BEEN_OPTIMIZED} <br />
	<!-- END opti.tb -->
	<br />
	&raquo;&raquo; {opti.BDD_OPTIMIZED_IN} 
		<!-- BEGIN opti.time -->
			{opti.time.VALUE} 
		<!-- END opti.time -->
	{opti.SECONDS}
	<br /><br />
	<a href="index.php?mods=admin&amp;page=sql">
		{opti.BACK}
	</a>
<!-- END opti -->

<!-- BEGIN manage -->
	<br /><table border="1" width="95%">
	<tr>
		<td>
			{manage.TABLE}<br />
		</td>
		<td>
			{manage.STRUCTURE}<br />
		</td>
		<td>
			{manage.PRINT}<br />
		</td>
		<td>
			{manage.EMPTY}<br />
		</td>
		<td>
			{manage.EXPORT}<br />
		</td>
		<td>
			{manage.DELETE}<br />
		</td>
	</tr>
	<!-- BEGIN manage.tb -->
		<tr>
			<td>
				<font color="{manage.tb.COLOR}">
					{manage.tb.NAME}
				</font>
			</td>
			<td>
				<a href="{manage.tb.HREF1}">
					{manage.tb.STRUCTURE}
				</a>
			</td>
			<td>
				<a href="{manage.tb.HREF2}">
					{manage.tb.PRINT}
				</a>
			</td>
			<td>
				<a href="{manage.tb.HREF3}">
					{manage.tb.EMPTY}
				</a>
			</td>
			<td>
				<a href="{manage.tb.HREF4}">
					{manage.tb.EXPORT}
				</a>
			</td>
			<td>
				<a href="{manage.tb.HREF5}">
					{manage.tb.DELETE}
				</a>
			</td>
		</tr>
	<!-- END manage.tb -->
	</table>
	<br /><br />{manage.ADD_TABLE} :<br />
	<form method="post" action="">
		{manage.TABLE_NAME} : <input type="text" name="table" />
		{manage.FIELD_NBR} : <input type="text" name="nb_fl" size="2" value="1" />
		<br /><input type="submit" value="{manage.VALID}" />
	</form>
	<br /><br />{manage.DO_QUERY} : <br />
	<form method="post" action="">
		<textarea name="sql_query" cols="15" rows="15"></textarea><br />
		<input type="submit" value="{manage.VALID}" />
	</form>
	<br /><br />
	<a href="index.php?mods=admin&amp;page=sql">
		 &raquo; &raquo; {manage.BACK}
	</a>
<!-- END manage -->

<!-- BEGIN add_form -->
	<br />{add_form.ADD_THE_TABLE} : {add_form.TABLE}<br />
	<form method="post" action="">
		<input type="hidden" name="table_add" value="{add_form.TABLE}" />
		<input type="hidden" name="table_nbr" value="{add_form.FIELD_NB}" />
		<table width="95%">
			<tr>
				<td>
					{add_form.NAME}
				</td>
				<td>
					{add_form.TYPE}
				</td>
				<td>
					{add_form.SIZE}
				</td>
				<td>
					{add_form.DEFAULT}
				</td>
				<td>
					{add_form.EXTRA}
				</td>
			</tr>
			<!-- BEGIN add_form.field -->
				<tr>
					<td>
						<input type="text" name="field_name_{add_form.field.NB}" />
					</td>
					<td>
						<select name="type_{add_form.field.NB}">
							<option value="VARCHAR">VARCHAR</option>
							<option value="TINYINT">TINYINT</option>
							<option value="TEXT">TEXT</option>
							<option value="DATE">DATE</option>
							<option value="SMALLINT">SMALLINT</option>
							<option value="MEDIUMINT">MEDIUMINT</option>
							<option value="INT">INT</option>
							<option value="BIGINT">BIGINT</option>
							<option value="FLOAT">FLOAT</option>
							<option value="DOUBLE">DOUBLE</option>
							<option value="DECIMAL">DECIMAL</option>
							<option value="DATETIME">DATETIME</option>
							<option value="TIMESTAMP">TIMESTAMP</option>
							<option value="TIME">TIME</option>
							<option value="YEAR">YEAR</option>
							<option value="CHAR">CHAR</option>
							<option value="TINYBLOB">TINYBLOB</option>
							<option value="TINYTEXT">TINYTEXT</option>
							<option value="BLOB">BLOB</option>
							<option value="MEDIUMBLOB">MEDIUMBLOB</option>
							<option value="MEDIUMTEXT">MEDIUMTEXT</option>
							<option value="LONGBLOB">LONGBLOB</option>
							<option value="LONGTEXT">LONGTEXT</option>
							<option value="ENUM">ENUM</option>
							<option value="SET">SET</option>
							<option value="BINARY">BINARY</option>
							<option value="VARBINARY">VARBINARY</option>
						</select>
					</td>
					<td>
						<input type="text" name="size_{add_form.field.NB}" />
					</td>
					<td>
						<input type="text" name="default_{add_form.field.NB}" />
					</td>
					<td>
						<select name="extra_{add_form.field.NB}">
							<option value="" selected="selected"> </option>
							<option value="auto_increment">auto_increment</option>
						</select>
					</td>
				</tr>
			<!-- END add_form.field -->
			<tr>
				<td colspan="5">
					<center>
						<input type="submit" value="{add_form.VALID}" />
					</center>
				</td>
			</tr>
		</table>
	</form>
<!-- END add_form -->

<!-- BEGIN sql_query -->
	<br />
	<b>
		<i>
			<u>
				{sql_query.QUERY}
			</u>
		</i>
	<b>
	<div style="overflow: auto;width: 95%; height: 400px;">
		<table border="1">
			<tr>
				<!-- BEGIN sql_query.field -->
					<td>
						{sql_query.field.NAME}
					</td>
				<!-- END sql_query.field -->
			</tr>
			<!-- BEGIN sql_query.row -->
				<tr>
					<!-- BEGIN sql_query.row.col -->
						<td>
							{sql_query.row.col.NAME}
						</td>
					<!-- END sql_query.row.col -->
				</tr>
			<!-- END sql_query.row -->
		</table>
	</div><br />
<!-- END sql_query -->

<!-- BEGIN line_form -->
	<form method="post" action="">
		<input type="hidden" name="added" value="added" />
		<table border="1" width="95%">
			<!-- BEGIN line_form.col -->
				<tr>
					<td>
						{line_form.col.NAME}
					</td>
					<td>
						<!-- BEGIN line_form.col.input -->
							<input type="text" name="{line_form.col.input.NAME}" value="{line_form.col.input.VALUE}" />
						<!-- END line_form.col.input -->
						
						<!-- BEGIN line_form.col.textarea -->
							<textarea cols="30" rows="10" name="{line_form.col.textarea.NAME}">{line_form.col.textarea.VALUE}</textarea>
						<!-- END line_form.col.textarea -->
					</td>
				</tr>
			<!-- END line_form.col -->
			<tr>
				<td colspan="2">
					<center>
						<input type="submit" value="{line_form.VALID}" />
					</center>
				</td>
			</tr>
		</table>
	</form>
	<a href="{line_form.BACK_URL}">
		&raquo; {line_form.BACK}
	</a>
<!-- END line_form -->

<!-- BEGIN view -->
			<br />
			<table border="1" width="95%">
				<tr>
					<td>
						{view.NAME}
					</td>
					<td>
						{view.TYPE}
					</td>
					<td>
						{view.DEFAULT}
					</td>
					<td>
						{view.EXTRA}
					</td>
					<td>
						{view.DELETE}
					</td>
				</tr>
				<!-- BEGIN view.field -->
					<tr>
						<td>
							{view.field.NAME}
						</td>
						<td>
							{view.field.TYPE}
						</td>
						<td>
							{view.field.DEFAULT}
						</td>
						<td>
							{view.field.EXTRA}
						</td>
						<td>
							<a href="{view.field.URL}">
								{view.field.DELETE}
							</a>
						</td>
					</tr>
				<!-- END view.field -->
			</table><br /><br />
			{view.ADD_FIELD} :
			<form method="post" action="">
			<table>
				<tr>
					<td>
						{view.NAME}
					</td>
					<td>
						{view.TYPE}
					</td>
					<td>
						{view.SIZE}
					</td>
					<td>
						{view.DEFAULT}
					</td>
					<td>
						{view.PLACED_AFTER}
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="field_name" />
					</td>
					<td>
						<select name="type">
							<option value="VARCHAR">VARCHAR</option>
							<option value="TINYINT">TINYINT</option>
							<option value="TEXT">TEXT</option>
							<option value="DATE">DATE</option>
							<option value="SMALLINT">SMALLINT</option>
							<option value="MEDIUMINT">MEDIUMINT</option>
							<option value="INT">INT</option>
							<option value="BIGINT">BIGINT</option>
							<option value="FLOAT">FLOAT</option>
							<option value="DOUBLE">DOUBLE</option>
							<option value="DECIMAL">DECIMAL</option>
							<option value="DATETIME">DATETIME</option>
							<option value="TIMESTAMP">TIMESTAMP</option>
							<option value="TIME">TIME</option>
							<option value="YEAR">YEAR</option>
			                <option value="CHAR">CHAR</option>
							<option value="TINYBLOB">TINYBLOB</option>
							<option value="TINYTEXT">TINYTEXT</option>
							<option value="BLOB">BLOB</option>
							<option value="MEDIUMBLOB">MEDIUMBLOB</option>
							<option value="MEDIUMTEXT">MEDIUMTEXT</option>
							<option value="LONGBLOB">LONGBLOB</option>
							<option value="LONGTEXT">LONGTEXT</option>
							<option value="ENUM">ENUM</option>
							<option value="SET">SET</option>
							<option value="BINARY">BINARY</option>
							<option value="VARBINARY">VARBINARY</option>
						</select>
					</td>
					<td>
						<input type="text" name="size" />
					</td>
					<td>
						<input type="text" name="default" />
					</td>
					<td>
						<select name="locate">
							<!-- BEGIN view.select -->
								<option value="{view.select.FIELD}">
									{view.select.NAME}
								</option>
							<!-- END view.select -->
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<center>
							<input type="submit" value="{view.VALID}"/>
						</center>
					</td>
				</tr>
			</table>
			</form>
			<br /><br />
				<a href="index.php?mods=admin&amp;page=sql&amp;admin_sql">
					{view.BACK}
				</a>
<!-- END view -->

<!-- BEGIN print_bdd -->
	<a href="{print_bdd.INSERT_URL}">
		{print_bdd.INSERT_NEW_LINE}
	</a>
	<br /><br />
	<div style="width: 95%;border-style :double;overflow : auto;">
		<br />
		<table border="1" width="95%">
			<tr>
				<td>
					{print_bdd.DELETE}
				</td>
				<td>
					{print_bdd.MODIFY}
				</td>
				<!-- BEGIN print_bdd.field -->
					<td style="text-align:center;">
						<b>
							{print_bdd.field.FIELD}
						</b>
						<br />
						<i>
							{print_bdd.field.TYPE}
						</i>
					</td>
				<!-- END print_bdd.field -->
			</tr>
			<!-- BEGIN print_bdd.line -->
				<tr>
					<td>
						<a href="{print_bdd.line.DEL_URL}">{print_bdd.line.DELETE}</a>
					</td>
					<td>
						<a href="{print_bdd.line.MOD_URL}">{print_bdd.line.MODIFY}</a>
					</td>
					<!-- BEGIN print_bdd.line.col -->
						<td>
							{print_bdd.line.col.VALUE}
						</td>
					<!-- END print_bdd.line.col -->
				</tr>
			<!-- END print_bdd.line -->
		</table>
		<br />
	</div>
	<br />
	<a href="{print_bdd.INSERT_URL}">
		{print_bdd.INSERT_NEW_LINE}
	</a>
	<br /><br />
	<a href="index.php?mods=admin&amp;page=sql&amp;admin_sql">
		&raquo; {print_bdd.BACK}
	</a>
<!-- END print_bdd -->

<!-- BEGIN export -->
	<div style="background-color:white;overflow:auto;width:95%;height:400px;">
		{export.EXP}
	</div>
	<br /><br />
	<a href="index.php?mods=admin&page=sql&admin_sql">
		{export.BACK}
	</a>
<!-- END export -->

<!-- BEGIN export_form -->
	{export_form.JS}
	<br />
	&raquo;&raquo; 
	<u>
		{export_form.CHOOSE_TABLE}
	</u>
	<br /><br />
	<form method="post" action="">
		<!-- BEGIN export_form.table -->
			&nbsp;&nbsp;
			<input type="checkbox" id="{export_form.table.TABLE}" name="table_{export_form.table.TABLE}" value="1" /> 
			&raquo; 
			<a onclick="change('{export_form.table.TABLE}');">
				{export_form.table.TABLE}
			</a>
			<br />
		<!-- END export_form.table -->
		<center>
			<input type="submit" value="{export_form.VALID}" />
			<input type="hidden" name="export" value="" />
		</center>
	</form>
	<br /><br />
	<a href="index.php?mods=admin&page=sql&admin_sql">
		{export_form.BACK}
	</a>
<!-- END export_form -->

<!-- BEGIN confirm -->
	{confirm.TXT} {confirm.TABLE},<br /> 
			<font color="{confirm.COLOR}">
				{confirm.WARNING}
			</font>
			<br /><br />
			<a href="{confirm.CONF_URL}">
				{confirm.CONF_TXT}
			</a>
			<br /><br />
			<a href="{confirm.BACK_URL}">
				{confirm.BACK}
			</a>
<!-- END confirm -->

<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->