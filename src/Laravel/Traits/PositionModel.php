<?php

namespace Hemend\Library\Laravel\Traits;

use Illuminate\Support\Facades\DB;

trait PositionModel
{
//    static protected string $position_field = 'position';

    static public function changePosition(int $old_position, int $new_position, callable $where = null)
    {
        $position_field = static::$position_field ?? 'position';

        return static::query()
            ->where(function($q) use ($where) {
                if($where !== null) {
                    $where($q);
                }
            })
            ->whereBetween($position_field, [
                DB::raw("LEAST( {$new_position}, {$old_position} )"),
                DB::raw("GREATEST( {$new_position}, {$old_position} )")
            ])
            ->update([
                $position_field => DB::raw( "CASE `{$position_field}`
                      WHEN {$old_position} THEN {$new_position}
                      ELSE `{$position_field}` + SIGN({$old_position} - {$new_position})
                     END")
            ]);
    }
}
