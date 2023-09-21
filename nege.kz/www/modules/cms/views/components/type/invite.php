<div class="control-group <?=$error ? 'error' : ''?>">
    <?=Form::label($field, __($label),array('class'=>'control-label'))?>

    <div class="controls">
        <?=Form::input(null,null,array(
        'id'=>"firstname",
        'class'=>"ui-autocomplete-input i_placeholder",
        'type'=>'text',
        'placeholder'=> __('Ф.И.О.'),
    ))?>
        <?=Form::input("model[$field]", $value,array(
        'id'=>'oponent',
        'class'=>'span3',
        'type'=>'hidden'
    ))?>
        <?=Form::input("email",$value,array(

        'class'=>'i_placeholder',
        'type'=>'text',
        'placeholder'=>'Email'
    ))?>
        <span class="help-inline"><?=$error?></span>
    </div>
</div>
<div id="log"></div>
<script>
    $().ready(function(){


        $("#firstname").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "<?=URL::site('debate/autocomplete')?>",
                    dataType: "json",
                    data: {
                        model: "user",
                        firstname: $("#firstname").val(),
                        lastname: $("#lastname").val(),
                        midlename: $("#midlename").val()
                    },
                    success: function( data ) {
                        if(!data.error){
                            response( $.map( data, function( item ) {
                                return {
                                    label: item.firstname+' '+item.midlename+' '+item.lastname,
                                    value: item.firstname+' '+item.midlename+' '+item.lastname,
                                    id: item.id
                                }
                            }));
                        }

                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                $('#oponent').val(ui.item.id);

            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>