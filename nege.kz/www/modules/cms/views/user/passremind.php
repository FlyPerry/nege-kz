 <?=Form::open()?>
        <table style="margin: 0 auto;">
            <tr>
                <td> <?=Form::label('email',__('E-mail').'*:')?> </td>
                <td> <?=Form::input('email', arr::get($_POST, 'email'),array('size'=>'30'))?> </td>
                <td style="color: red"> <?=arr::get($errors, 'email')?> </td>
            </tr>            
            <tr>
                <td> <?=Form::label('captcha',__('Код').'*:')?></td>
                <td> <?=$recaptcha->widget()?></td>
                <td style="color: red"> <?=$recaptcha->error($errors,false)?> </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td> <?=Form::submit('submit', __('Отправить'),array('class'=>'i_btn'))?> </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    <?=form::close()?>