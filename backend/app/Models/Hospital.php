<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Hospital extends Model
{
    use HasFactory,Sortable;

    protected $guarded = ['id'];

    public function hospital_type()
    {
        return $this->belongsTo(Code::class, 'type', 'key')
            ->where('category','hospital_type')
            ->withDefault()
            ;
    }

    /**
     * CSV出力用配列
     * @return array
     */
    public function toCSVArray()
    {
        $array = $this->attributes;

        return $array;
    }

}
