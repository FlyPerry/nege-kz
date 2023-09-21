<checkbox field="<?="model[$field]"?>"
          val="<?=$value?>"
          default-checked="<?=(int) Arr::get($params, 'default_checked', false)?>"
          model="model.<?=$field?>"
          label="<?=htmlentities($label)?>"
          error="<?=htmlentities($error)?>"
          checkbox-disabled="<?= Arr::get($params, 'disabled') ?>"
    >

</checkbox>