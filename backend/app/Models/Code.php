<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Code extends Model
{
    use HasFactory, Sortable;

    /**
     * @var bool|\Illuminate\Database\Eloquent\Collection
     */
    public static $data = false;

    protected $guarded = ['id'];

    protected $visible = ['id','key', 'value', 'sub_value'];

    /**
     * @param $category
     * @param null $key
     * @return \Illuminate\Database\Eloquent\Collection|static[]|Code
     */
    public static function data($category, $key = null)
    {
        if(!static::$data) {
            static::$data = static::all()
                ->where('is_not_display',0)
                ->sortBy([
                    ['category','asc'],
                    ['display_order','asc'],
                ]);
        }
        $results = static::$data;
        $results = $results->where('category',$category);
        if(!empty($key)) {
            $results = $results->where('key', $key)->first();
        }

        return $results;
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
