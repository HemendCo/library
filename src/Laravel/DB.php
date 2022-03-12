<?php

namespace Hemend\Library\Laravel;

use Illuminate\Database\Eloquent\Builder;

class DB {
    public static function getSql(Builder $query)
	{
	    $sql = $query->toSql();
	    foreach ($query->getBindings() as $binding) {
	        $value = is_numeric($binding) ? $binding : app('db')->getPdo()->quote($binding);
	        $sql = preg_replace('/\?/', $value, $sql, 1);
	    }
	    
	    return $sql;
	}
}
