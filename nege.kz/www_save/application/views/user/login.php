<section class="auth-page">
	<div class="section">
		<div class="container">
			<div class="row main-low-margin center">
				<h3><?=__('Авторизация')?></h3>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row main-low-margin center">
			<div class="auth-form">
				<form method="post" accept-charset="utf-8" class="form-horizontal">
					<div class="control-group control-wstr">
						<label class="control-label" for="inputLogin"><?= __('E-mail') . ':' ?></label>

						<div class="controls">
							<input type="text" name="username" id="inputLogin" class="input-xlarge">
							<span class="error"></span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="inputPass"><?= __('Пароль') . ':' ?></label>

						<div class="controls">
							<input type="password" name="psswd" value="" id="inputPass" class="input-xlarge">
							<span class="error"><?= Arr::get($errors, 'psswd') ?></span>
						</div>
					</div>
					
					<div class="forget">
						<?= HTML::anchor('/user/passremind', __('Забыли пароль') . '?') ?>
					</div>

					<div class="control-group">
						<div class="controls">
							<?= Form::submit('submit', __('Войти'), array('class' => 'btn btn-warning btn-large')) ?>
						</div>
					</div>
				</form>
			</div>
			<a href="?login_form=regisration" class="btn btn-primary btn-large"><?= __("Зарегистрироваться") ?></a>
		</div>
	</div>
	<script>

	</script>
</section>