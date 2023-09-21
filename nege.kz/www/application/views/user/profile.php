<section class="main-content-section">
    <div class="main-content-left">
        <div class="cabinet-page">
            <h1><?=__('Личный кабинет')?></h1>
            <div class="page-content">
                <div class="zag"><?=__('Основные данные')?></div>
                <img src="<?=$user->ava_url(110)?>" class="avatar">
                <a href="#" id="select-photo-link"><?=__('Сменить фото')?></a>
                <?=Arr::get($errors, 'file')?>

                <form action="<?=URL::site(Request::$current->uri().'?update=user_info')?>" method="post" enctype="multipart/form-data">
                    <input type="file" id="photo-file-input" style="display:none;">
                    <label><?=__('Ваше имя')?></label> <input type="text" name="firstname" value="<?=$user->firstname?>"> <?=Arr::get($errors, 'firstname')?><br>
                    <label><?=__('e-mail')?></label> <input type="text" name="email" value="<?=$user->email?>"> <?=Arr::get($errors, 'email')?><br>
                    <label><?=__('Текущий пароль')?></label> <input type="password" name="current_password"> <?=Arr::get($errors, 'current_password')?><br>
                    <label><?=__('Новый пароль')?></label> <input type="password" name="password"> <?=Arr::get($errors, 'password')?> <?=Arr::path($errors, '_external.password')?><br>
                    <input type="submit" value="<?=__('Сохранить')?>">
                    <input type="submit" value="<?=__('Выйти')?>" id="exit_button">
                </form>
                <div class="zag" style="display:none;"><?=__('Подписки')?></div>
                <div class="subscribe" style="display:none;">
                    <form method="post" action="<?=URL::site(Request::$current->uri().'?update=subscriptions')?>">
                        <?php foreach ($categories as $key => $category) : ?>
                            <div class="item"><input type="checkbox" name="categories[<?=$category->id?>]" <?= array_key_exists($category->id, $subscribed_categories) ? 'checked' : ''?> class="checkbox" id="c<?=$key?>"><label for="c<?=$key?>"><?=$category->title?></label></div>
                        <?php endforeach ?>
                        <br>
                        <button type="submit"><?=__('Подписаться')?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?=View::factory('blocks/main_news')?>
    <div class="clear"></div>
</section>

<script>
    $('#select-photo-link').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#photo-file-input').click();
    });


    $('#photo-file-input').change(function (e) {
        var formData = new FormData();
        formData.append('file', $(this).get(0).files[0]);
        $.ajax({
            type: 'POST',
            url: '<?=URL::site(I18n::$lang.'/user/profile/ava_upload')?>',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (data) {
            $('.avatar').attr('src', data.image);
        });
    });

    $('#exit_button').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = "<?=URL::site(I18n::$lang)?>/user/logout";
    })
</script>