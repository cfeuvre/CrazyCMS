<!-- BEGIN post -->
		<form method="post" action="">
			{post.FORMULAIRE}
			<!-- BEGIN post.post_attached -->
				<br /><input type="checkbox" name="attached" value="1"/>{post.post_attached.ATTACH_TOPIC}
			<!-- END post.post_attached -->
			<!-- BEGIN post.post_locked -->
				<br /><input type="checkbox" name="locked" value="1"/>{post.post_locked.LOCK_TOPIC}
			<!-- END post.post_locked -->
			<!-- BEGIN post.post_abo -->
				<br /><input type="checkbox" name="abon" value="1" {post.post_abo.STATE}/>{post.post_abo.ABON}
			<!-- END post.post_abo -->
			<!-- BEGIN post.post_reply -->
				<input type="hidden" name="last_date" value="{post.post_reply.LAST_DATE}" />
			<!-- END post.post_reply -->
		</form>
<!-- END post -->
<!-- BEGIN post_lastreply -->
	<br />
		<fieldset>
			<legend>{post_lastreply.LAST_REPLY}</legend>
				<u>{post_lastreply.BY} {post_lastreply.PSEUDO}, {post_lastreply.THE} {post_lastreply.DATE} :</u><br /><br />
				{post_lastreply.CONTENU}
			</fieldset>
<!-- END post_lastreply -->
<!-- BEGIN post_main -->
	<br />
		<fieldset>
			<legend>{post_main.TOP} : <b>{post_main.TOP_NAME}</b></legend>
				<u>{post_main.BY} {post_main.PSEUDO}, {post_main.THE} {post_main.DATE} :</u><br /><br />
				{post_main.CONTENU}
			</fieldset>
<!-- END post_main -->
<!-- BEGIN post_valid_flood -->
		<p>
			{post_valid_flood.MUST_WAIT} {post_valid_flood.FLOOD_TIME} {post_valid_flood.SECONDS_BETWEEN_TWO_POST}
		</p>
		<br />
			{post_valid_flood.WAIT_FOR} {post_valid_flood.TIME_LEFT} {post_valid_flood.SECONDS_TO_POST}.
		<br />{post_valid_flood.TO_NOT_REWRITE} {post_valid_flood.TIME_LEFT} {post_valid_flood.SECONDS_WITH_F5}.
<!-- END post_valid_flood -->
<!-- BEGIN post_valid_size -->
	<br />
		{post_valid_size.MINIMUM_5_CHAR}
	<br />
	<a href="">
		{post_valid_size.BACK}
	</a>
<!-- END post_valid_size -->
<!-- BEGIN post_valid_reply_during_writing -->
		{post_valid_reply_during_writing.REPLY_POSTED_DURING_WRITE}
		<br /><br />
			<fieldset>
				<legend>
					<b>
						{post_valid_reply_during_writing.LAST_REPLY}
					</b>
				</legend>
				{post_valid_reply_during_writing.BY} {post_valid_reply_during_writing.PSEUDO}, {post_valid_reply_during_writing.THE} {post_valid_reply_during_writing.DATE} :
				<br /><br />
				{post_valid_reply_during_writing.CONTENU}
			</fieldset>
			<br /><br />
			<form method="post" action="">
				{post_valid_reply_during_writing.FORM}
				<input type="hidden" name="last_date" value="{post_valid_reply_during_writing.LDATE}" />
			</form>
		<br /><br />
		<a href="">
			{post_valid_reply_during_writing.BACK}
		</a>
<!-- END post_valid_reply_during_writing -->
<!-- BEGIN post_valid_error -->
	<img src="./themes/tpl/img/error.png" align="left">{ERROR_POST_NOT_SENDED}
<!-- END post_valid_error -->
<!-- BEGIN post_valid -->
	<p>
		{post_valid.POSTED}
	</p>
	<br /><br />
	<a href="{post_valid.URL}">
		{post_valid.BACK}
	</a>
<!-- END post_valid -->