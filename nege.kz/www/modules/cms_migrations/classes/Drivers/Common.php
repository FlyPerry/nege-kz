<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 05.07.13
 * Time: 15:04
 * To change this template use File | Settings | File Templates.
 */

class Drivers_Common {
    /**
     * Valid types
     * @var array
     */
    protected $types = array
    (
        'decimal',
        'float',
        'integer',
        'datetime',
        'date',
        'timestamp',
        'time',
        'text',
        'mediumtext',
        'longtext',
        'string',
        'binary',
        'boolean',
        'enum',
    );

    protected function native_type($type, $limit)
    {
        if (!$this->is_type($type))
        {
            throw new Kohana_Exception('migrations.unknown_type :type', array(':type' => $type));
        }

        if (empty($limit))
        {
            $limit = $this->default_limit($type);
        }

        switch ($type)
        {
            case 'integer':
                switch ($limit)
                {
                    case 'big':    return 'bigint';
                    case 'normal': return 'int';
                    case 'small':  return 'smallint';
                    default: break;
                }
                throw new Kohana_Exception('migrations.unknown_type :type', array(':type' => $type));

            case 'string': return "varchar ($limit)";
            case 'boolean': return 'tinyint (1)';
            default: $limit and $limit = "($limit)"; return "$type $limit";
        }
    }

    protected function migration_type($native)
    {
        $limit='';
        if (preg_match('/^([^\(]++)\((.+)\)( unsigned)?$/', $native, $matches))
        {
            $native = $matches[1];
            $limit  = $matches[2];
        }

        switch ($native)
        {
            case 'bigint':   return 'integer[big]';
            case 'smallint': return 'integer[small]';
            case 'int':      return 'integer';
            case 'varchar':  return "string[$limit]";
            case 'tinyint':  return 'boolean';
            case 'enum':     return "enum[$limit]";
            default: break;
        }

        if (!$this->is_type($native))
        {
            throw new Kohana_Exception('migrations.unknown_type :type', array(':type' => $native));
        }

        return $native .(!empty($limit)?"[$limit]":'');
    }

    protected function is_type($type)
    {
        return in_array($type,$this->types);
    }
}