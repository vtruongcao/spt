<?php
/**
 * SPT software - Static Object
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a static singleton object
 * 
 */

namespace SPT;

use SPT\Support\FncArray as Arr;

class StaticObj 
{
    static function set($key, $value, $overwrite = true)
    {
        if( $overwrite || !isset( static::$_vars[$key] ) )
        {
            static::$_vars[$key] = $value;
        }
    }

    static function get($key, $default = null)
    {
        return isset(static::$_vars[$key]) ? static::$_vars[$key] : $default;
    }

    static function getAll()
    {
        return static::$_vars;
    }

    static function importArr(array $arr)
    {
        Arr::merge(static::$_vars, $arr);
    }
}
