<?php

/**
 * Created by PhpStorm.
 * User: AxCx
 * Date: 01.10.2015
 * Time: 14:19
 */
class Task_Index extends Minion_Task
{
    protected $_options = array(
        'env'=>'PRODUCTION'
    );
    protected function _execute(array $params)
    {
        Kohana::$environment = constant('Kohana::' . strtoupper(Arr::get($params,'env')));
        $this->batch(ORM::factory('News'), 100, function ($item) {
            /**
             * @var $item ORM
             */
            $item->reindex();
        });

    }


    public function batch($query, $size, $callback)
    {

        $count = $query->reset(true)->count_all();

        $chunks_count = ceil($count / $size);

        for ($i = 0; $i < $chunks_count; $i++) {
            $collection = $query
                ->limit($size)
                ->offset($i * $size)
                ->find_all();

            foreach ($collection as $item) {
                $callback($item);
            }
            unset ($collection);
            Minion_Cli::write_replace(($i + 1) . '/' . $chunks_count, $i == $chunks_count);
        }
    }
}