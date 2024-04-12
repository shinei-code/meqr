<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Insurance extends Model
{
    use HasFactory,Sortable;
    protected $guarded = ['id'];

    public function hoken_kind()
    {
        return $this->belongsTo(Code::class, 'type', 'key')
            ->where('category','hoken_kind_kbn')
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
