<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Интерфейс для редактируемого компонента
 */
interface IC_Editable
{
    /**
     * Получить значения поля по его имени
     * @abstract
     * @param string $field
     */
    public function get_field($field);

    /**
     * @abstract
     * Урл для просмотра
     */
    public function view_url();
    /**
     * @abstract
     * Урл для редактирования
     */
    public function edit_url();
    /**
     * @abstract
     * Урл для удаления
     */
    public function delete_url();

    public function list_url();

    /**
     * Проверка прав
     * @abstract
     * @param $action Действие для которого проверяются права (edit|delete|view)
     * @param $user Пользователь для которого идет проверка (тип зависит от реализации)
     * @return boolean
     */
    public function permission($action,$user);

    public function fields_description();

    public function search_form();

    public function list_title();

    public function edit_title();

}
