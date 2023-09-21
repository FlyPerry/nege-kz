<div class="col-md-4">
    <h4><?=__('Нужна помощь? Напишите нам.')?> </h4>
    <hr>
    <form>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control" required="required" placeholder="<?=__('Имя')?>">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control" required="required" placeholder="Email">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <textarea name="message" id="message" required="required" class="form-control" rows="3" placeholder="<?=__('Сообщение')?>"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><?=__('Отправить')?></button>
                </div>
            </div>
        </div>
    </form>
</div>