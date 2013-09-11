<div id="user-login-header">
	<a href="/">
	<img src="<?php print drupal_get_path("theme","young_connect")."/img/login-header-logo.png"; ?>" />
	</a>
	<p><strong>Young Connect</strong> er for dig, der har været anbragt uden for hjemmet, og som ikke er tilknyttet et kommunalt efterværnstilbud.</p>
</div>
<div class="form-container">
<?php print drupal_render_children($form); ?>
<div id="user-login-footer">Har du glemt dit password? - <a href="user/password">klik her</a></div>
</div>