<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	'alpha'         => ':field must contain only letters',
	'alpha_dash'    => ':field must contain only numbers, letters and dashes',
	'alpha_numeric' => ':field must contain only letters and numbers',
	'color'         => ':field must be a color',
	'credit_card'   => ':field must be a credit card number',
	'date'          => ':field must be a date',
	'decimal'       => ':field must be a decimal with :param2 places',
	'digit'         => 'В поле ":field" может быть только числовое значение',
	'email'         => 'введите корректный email адрес',
	'email_domain'  => ':field must contain a valid email domain',
	'equals'        => ':field must equal :param2',
	'exact_length'  => ':field must be exactly :param2 characters long',
	'in_array'      => ':field must be one of the available options',
	'ip'            => ':field must be an ip address',
	'matches'       => ':field must be the same as :param3',
	'min_length'    => ':field must be at least :param2 characters long',
	'max_length'    => 'Значение поле ":field" не может быть больше, чем :param2 символа',
	'not_empty'     => 'это поле должно быть заполнено',
	'numeric'       => ':field must be numeric',
	'phone'         => ':field must be a phone number',
	'range'         => ':field must be within the range of :param2 to :param3',
	'domain.unique'         => __('Такой адрес уже есть в базе, если Вы не вносили его, то свяжитесь с нашей службой поддержки'),
	'url'           => 'Поле ":field" должно содержать URL'
);
