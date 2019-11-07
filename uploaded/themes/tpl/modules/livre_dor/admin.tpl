<!-- BEGIN index -->
	<br />
	<fieldset>
		<legend>
			<strong>
				<u>
					{index.MESS_TO_VALID}
				</u>
			</strong>
		</legend>
	<!-- BEGIN index.nonev -->
		<center>
			{index.nonev.TXT}
		</center>
	<!-- END index.nonev -->	
	
	<!-- BEGIN index.valid -->
		<br/>
		<strong>
			{index.valid.MESS} :
		</strong> 
		<i>
			{index.valid.COUPE}...
		</i> 
		<br />
		<strong>
			{index.valid.AUTHOR} : {index.valid.PSEUDO} 
		</strong>
		<br />
		<strong>
			{index.valid.NOTE} : 
		</strong>
			{index.valid.NT} {index.valid.ON_TEN} <br />
			{index.valid.ACTION} : 	
		<a href="index.php?mods=livre_dor&amp;page=look&amp;id={index.valid.ID}">
			| {index.valid.SEE_COMPLETE_COMMENT} |
		</a> 
		<a href="./index.php?mods=livre_dor&amp;page=admin&amp;action=valider&amp;id={index.valid.ID}">
			| {index.valid.VALID} |
		</a> 
		<a href="./index.php?mods=livre_dor&amp;page=admin&amp;action=supprimer&amp;id={index.valid.ID}">
			| {index.valid.DEL} |
		</a>
		<br /><br />
	<!-- END index.valid -->	
	<br /><br />
		<!-- BEGIN index.enable -->
			<a href="index.php?mods=livre_dor&amp;page=admin&amp;activation=1">
				{index.enable.TXT}
			</a>
		<!-- END index.enable -->
		
		<!-- BEGIN index.disable -->
			<a href="index.php?mods=livre_dor&amp;page=admin&amp;activation=0">
				{index.disable.TXT}
			</a>
		<!-- END index.disable -->
	</fieldset><br />
	<fieldset>
		<legend>
			<strong>
				{index.MESSAGES}
			</strong>
		</legend>
	
		<!-- BEGIN index.none -->
			<center>
				{index.none.NO_COMMENTS}
			</center>
		<!-- END index.none -->
		
		<!-- BEGIN index.messages -->
			
			<br />
			<center>
				<a href="./index.php?mods=livre_dor&amp;page=admin&amp;action=supp">
					| {index.messages.DELETE_ALL_LVOR} |
				</a>
			</center>
			<br />
			
			<!-- BEGIN index.messages.mess -->
				<br />
				<strong>
					{index.messages.mess.MESS} :
				</strong> 
				<i>
					{index.messages.mess.COUPE}...
				</i> 
				<br />
				<strong>
					{index.messages.mess.AUTHOR} : {index.messages.mess.PSEUDO} 
				</strong>
				<br />
				<strong>
					{index.messages.mess.NOTE} : 
				</strong>
					{index.messages.mess.NT} {index.messages.mess.ON_TEN} 
				<br />
				<u>
					{index.messages.mess.ACTION} : 
				</u>
				<a href="index.php?mods=livre_dor&amp;page=look&amp;id={index.messages.mess.ID}">
					| {index.messages.mess.SEE_COMPLETE_COMMENT} |
				</a> 
				<a href="./index.php?mods=livre_dor&amp;page=admin&amp;action=supprimer&amp;id={index.messages.mess.ID}">
					| {index.messages.mess.DEL} |
				</a>
				<br />
			<!-- END index.messages.mess -->
		<!-- END index.messages -->
	
	</fieldset>
<!-- END index -->

<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->