<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ситиком
 * Date: 23.04.12
 * Time: 14:56
 * To change this template use File | Settings | File Templates.
 */
class Pagination extends Kohana_Pagination
{
    /**
     * Применяет смещение в соответвии с вычеслиными параметрами
     * @param \IFiltered|\ORM $target
     * @return
     */
    public function apply(ORM $target)
    {
        return $target->offset($this->offset)->limit($this->items_per_page);
    }
}
