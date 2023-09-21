<div class="section">
    <div class="container">
        <div class="row main-low-margin center">
            </center><h3><?=__('Регистрация')?></h3>
        </div>
    </div>
</div>


<div class="container">
    <div class="row main-low-margin center">
        <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
            <div class="control-group">
                <label class="control-label"><?=__('Ваше имя').':'?></label>
                <div class="controls">
                    <?=Form::input('firstname', arr::get($_POST, 'firstname'),array('class'=>'input-xxlarge'))?>
                    <span class="error help-inline"><?=__(arr::get($errors, 'firstname'))?></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"><?=__('E-mail').':'?></label>
                <div class="controls">
                    <?=Form::input('email', arr::get($_POST, 'email'),array('class'=>'input-xxlarge'))?>
                    <span class="error help-inline"><?=__(arr::get($errors, 'email'))?></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"><?=__('Пароль').':'?></label>
                <div class="controls">
                    <?=Form::input('password', '',array('class'=>'input-xxlarge','type'=>'password'))?>
                    <span class="error help-inline"><?=arr::path($errors, '_external.password')?></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"><?=__('Еще раз пароль').':'?></label>
                <div class="controls">
                    <?=Form::input('password_confirm', '',array('class'=>'input-xxlarge','type'=>'password'))?>
                    <span class="error help-inline"><?=arr::path($errors, '_external.password_confirm')?></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"><?=__('Код').':'?></label>
                <div class="controls">
                    <div id="regcptch">
                        <?=$recaptcha->widget()?>
                    </div>
                    <span class="error help-inline"><?=$recaptcha->error($errors,TRUE)?></span>
                    <span class="error help-inline"><?=arr::path($errors, '_external.recaptcha_response_field')?></span>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <?=Form::submit('submit', __('Зарегистрироваться'),array('class'=>'btn btn-warning btn-xlarge'))?>
                </div>
            </div>

        </form>
    </div>
</div>
