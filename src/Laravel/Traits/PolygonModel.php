<?php

namespace Hemend\Library\Laravel\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

trait PolygonModel
{
    use HasFactory;

    // protected $geometry = ['geo'];
    // protected $polygon = ['polygon'];

    public function newQuery($excludeDeleted = true)
    {
        if (!empty($this->polygon) || !empty($this->geometry))
        {
            $raws = [];
            if(!empty($this->geometry)) {
                foreach ($this->geometry as $column)
                {
                    $raws[] = 'CONCAT_WS(",", X(`' . $this->table . '`.`' . $column . '`), Y(`' . $this->table . '`.`' . $column . '`)) as `' . $column . '`';
                }
            }

            if(!empty($this->polygon)) {
                foreach ($this->polygon as $column)
                {
    //                $raws[] = 'ST_AsGeoJSON(`' . $this->table . '`.`' . $column . '`) as `' . $column . '`';
                    $raws[] = 'ST_AsText(`' . $this->table . '`.`' . $column . '`) as `' . $column . '`';
                }
            }

            return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw(implode(', ', $raws)));
        }

        return parent::newQuery($excludeDeleted);
    }
}
