<?php
$attr = $attr + array('class' => 'btn btn-default btn-raised', 'type' => 'reset');
?>
<?= Form::input($name, __($value), $attr) ?>