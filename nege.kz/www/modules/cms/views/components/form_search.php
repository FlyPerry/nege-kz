<div class="admin-search">
    <form class="form-horizontal" method="get" id="admin_search_form" action="<?=Request::current()->url() ?>">
    <div class="input-group custom-search-form">
        <?if($search):?>

        <input type="text" name="search" class="form-control" value="<?=Request::$current->query('search')?>" placeholder="Поиск...">
        <?endif?>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search fw"></i>
                            </button>
                        </span>
    </div>
        <?if(count($elements)):?>
    <div class="open-search well">
<!--        <div class="row">-->
            <fieldset>
            <?
                $count=round(count($elements)/2);
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php
                $i=0;
                foreach ($elements as $el) {
                    echo $el;
                    $i++;
                    if($i>=$count){
                $count=getrandmax();
                        ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?
                    }
                }

                ?>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">


                <?php

                foreach ($buttons as $el) {
                    echo $el;
                }

                ?>
                    </div>
                </div>
            </div>
            </fieldset>
<!--            </div>-->
        </div>
        <?endif?>
    </form>
</div>


