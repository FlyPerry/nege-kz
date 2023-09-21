<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 26.08.13
 * Time: 14:53
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class Cms_Interface_Partial
 * Используется для маркировки моделей что они поддерживают частичные модели
 * при этом для такой модели должен быть создан класс частичной модели <класс модели>_Partial
 * и таблица под нее
 * Таблица должна обязательно содеражиать поля
 * id - pk
 * object_id - fk
 * lang - index
 */
interface Cms_Interface_Partial {

}