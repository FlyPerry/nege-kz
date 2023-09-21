<div class="form-group">
    <label for="<?=$field?>" class="control-label"><?=$label?></label>

    <div class="controls">
        <textarea id="<?=$field?>" name="<?="model[$field]"?>" rows="4" class="col-sm-4 col-md-4"><?=$value?></textarea>

        <div class="err"><?=$error?></div>
    </div>
</div>