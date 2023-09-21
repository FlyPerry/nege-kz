
<div class="page_section">
    <div class="content_right">
        <div class="head_section">
            <h3><?=__('Вход')?></h3>
        </div>

        <div class="user_reg_section user_entry_section">

            <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
                <div class="control-group control-wstr">
                    <label class="control-label" for="inputLogin"><?=__('Логин или e-mail').':'?></label>
                    <div class="controls">
                        <input type="text" name="username" id="inputLogin" class="input-xlarge">
                        <span class="error help-inline"></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputPass"><?=__('Пароль').':'?></label>
                    <div class="controls">
                        <input type="password" name="psswd" value="" id="inputPass" class="input-xlarge">
                        <span class="error help-inline"><?=arr::get($errors, 'psswd')?></span>
                    </div>
                </div>


                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox fr">
                            <input type='checkbox' name='remember' id="remember"> <?=__('Запомнить').'?'?>
                        </label>
                        <?=HTML::anchor('/user/passremind',__('Забыли пароль').'?', array("class"=>"link"))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=Form::submit('submit', __('Войти'),array('class'=>'fr i_btn'))?>
                        <div class="fl"><?=$ulogin?></div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>