<?php
if(!function_exists('code')) {
    /**
     * codesの取得
     * @param $categoty
     * @param null $key
     * @return \App\Models\Code|\App\Models\Code[]|\Illuminate\Database\Eloquent\Collection
     */
    function code($categoty, $key= null)
    {
        return \App\Models\Code::data($categoty, $key);
    }
}

if( !function_exists('checkValue')) {

    /**
     * 値の比較
     * @param $target
     * @param $value
     * @return bool
     */
    function checkValue($target, $value)
    {
        if (is_null($target)) {
            return is_null($value);
        }

        return ($target == $value);
    }
}
