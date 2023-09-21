            <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
                        <?=__('Логин').':'?>
                        <?=Form::input('username', arr::get($_POST, 'username'),array('class'=>'input-xxlarge'))?>
                        <span class="error help-inline"><?=__(arr::get($errors, 'username'))?></span><br />
                        
                        <?=__('Email').':'?>
                        <?=Form::input('email', arr::get($_POST, 'email'),array('class'=>'input-xxlarge'))?>
                        <span class="error help-inline"><?=__(arr::get($errors, 'email'))?></span><br />


                        <?=__('Пароль').':'?>
                        <?=Form::input('password', '',array('class'=>'input-xxlarge','type'=>'password'))?>
                        <span class="error help-inline"><?=arr::path($errors, '_external.password')?></span><br />

                        <?=__('Еще раз пароль').':'?>
                        <?=Form::input('password_confirm', '',array('class'=>'input-xxlarge','type'=>'password'))?>
                        <span class="error help-inline"><?=arr::path($errors, '_external.password_confirm')?></span><br />

               
                <?=__('Код').':'?>
                    <div class="controls">
                        <div id="regcptch">
                            <?=$recaptcha->widget()?>
                        </div>

                        <span class="error help-inline"><?=$recaptcha->error($errors,TRUE)?></span>
                    </div>

            
                        <?=Form::submit('submit', __('Зарегистрироваться'),array('class'=>'i_btn'))?>

            </form>
