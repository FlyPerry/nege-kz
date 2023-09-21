<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	'alpha'         => ':field должно содержать только буквы',
	'alpha_dash'    => ':field должно содержать только цифры, буквы и символы',
	'alpha_numeric' => ':field must contain only letters and numbers',
	'color'         => ':field must be a color',
	'credit_card'   => ':field must be a credit card number',
	'date'          => ':field must be a date',
	'decimal'       => ':field must be a decimal with :param2 places',
	'digit'         => 'В поле ":field" может быть только числовое значение',
	'email'         => 'Введите корректный email адрес',
	'email_domain'  => ':field must contain a valid email domain',
	'equals'        => ':field must equal :param2',
	'exact_length'  => ':field must be exactly :param2 characters long',
	'in_array'      => ':field must be one of the available options',
	'ip'            => ':field must be an ip address',
	'matches'       => 'Поле ":field" должно совпадать с полем ":param3"',
	'min_length'    => 'Значение поля ":field" не может быть меньше, чем :param2 символа',
	'max_length'    => 'Значение поля ":field" не может быть больше, чем :param2 символа',
	'not_empty'     => 'Поле ":field" должно быть заполнено',
	'numeric'       => ':field must be numeric',
	'phone'         => ':field must be a phone number',
	'range'         => ':field must be within the range of :param2 to :param3',
	'regex'         => ':field does not match the required format',
	'url'           => 'Поле ":field" должно содержать URL',
    "user.email.unique" => "Пользователь с таким email уже есть в базе",
    "incorrect_password" => "Неверный пароль"
);
