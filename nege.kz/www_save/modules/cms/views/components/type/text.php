<div class="form-group <?=$error ? 'has-error' : ''?>">
    <label class="control-label" for="<?=$field?>"><?=__($label)?></label>
    <div class="panel" style="margin-top: 10px; padding:5px" >
        <textarea contenteditable="true" value-init text-editor ng-model="model.<?=$field?>" id="<?=$field?>" name="<?="model[$field]"?>" rows="4" class="editor form-control"><?=$value?></textarea>
    </div>
    <?php if ($error) : ?>
        <span class="help-block" style="display: block"><?=$error?></span>
    <?php endif ?>
</div>