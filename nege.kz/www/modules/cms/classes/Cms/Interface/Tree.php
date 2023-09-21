<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 28.08.13
 * Time: 13:46
 * To change this template use File | Settings | File Templates.
 */
/**
 * Class Cms_Interface_Tree
 * Используется в качестве маркировки модели что она поддерживает древовидную структуру данных
 * Для модели должна быть создана модель <класс модели>_Tree extends Cms_Model_Tree и таблица под нее
 * таблица должна содержать поля:
 * CREATE TABLE `page_trees` (
    `a` int(10) unsigned NOT NULL,
    `d` int(10) unsigned NOT NULL,
    `l` int(10) unsigned NOT NULL,
    PRIMARY KEY (`a`,`d`)
    )
 * где a - pk предка, d - pk потомка, l - расстояние от предка до потомка
 * Таблица реализует паттерн Closure Table
 */
interface Cms_Interface_Tree {

}