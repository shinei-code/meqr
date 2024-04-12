<?php
/**
 * Created by PhpStorm.
 * User: kei
 * Date: 2018/09/12
 * Time: 12:50
 */

namespace App\Repositories\Extentions;


use Illuminate\Database\Eloquent\Builder;

class BuilderExtension
{

    /**
     * カンマ区切りのデータをInで検索する。
     *
     * @param Builder $query
     * @param string $key フィールド名
     * @param mixed $value カンマ区切りのデータ
     * @return void
     */
    public function addArrayQuery(Builder $query, $key, $value)
    {
        if (null === $value) {
            return;
        }

        $values = explode(',', $value);
        $query->whereIn($key, $values);
    }

    /**
     * int型クエリ追加
     * @param Builder $query
     * @param string $key フィールド名
     * @param mixed $value
     * @param string $operator
     * @param bool $or
     * @return void
     */
    public function addQuery(Builder $query,$key, $value, $operator = '=', $or = false)
    {
        if (null === $value) {
            return;
        }
        if ($or) {
            $query->orWhere($key, $operator, $value);
        } else {
            $query->where($key, $operator, $value);
        }
    }

    /**
     * Booleanクエリ追加
     *
     * @param Builder $query
     * @param string $key
     * @param int|boolean|string $value
     * @return void
     */
    public function addQueryBoolean(Builder $query, $key, $value)
    {
        if (null === $value || 0 > $value) {
            return;
        }

        if (false === $value || 0 === $value || '0' === $value) {
            $bool = false;
        } elseif (true === $value || 1 === $value || '1' === $value) {
            $bool = true;
        } else {
            return;
        }

        $query->where($key, $bool);
    }

    /**
     * LIKE（部分一致）クエリ追加
     * @param Builder $query
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addQueryLike(Builder $query, $key, $value)
    {
        if (empty($value)) {
            return;
        }
        $query->where($key, 'LIKE', '%' . $value . '%');
    }

    /**
     * IsNullクエリ追加
     *
     * @param Builder $query
     * @param $key
     * @param bool $or
     * @return void
     */
    public function addQueryIsNull(Builder $query, $key, $or = false)
    {
        if ($or) {
            $query->orWhereNull($key);
        } else {
            $query->whereNull($key);
        }
    }

    /**
     * IsNotNullクエリ追加
     *
     * @param Builder $query
     * @param $key
     * @param bool $or
     * @return void
     */
    public function addQueryIsNotNull(Builder $query, $key, $or = false)
    {
        if ($or) {
            $query->orWhereNotNull($key);
        } else {
            $query->whereNotNull($key);
        }
    }

    /**
     * 日付範囲(from - to)
     * @param Builder $query
     * @param $name
     * @param $values
     * @return void
     */
    public function addQueryRangeDate(Builder $query, $name, $values)
    {
        // 開始日、終了日のセット
        $fromDate = null;
        $toDate = null;
        if (isset($values['from'])) {
            $fromDate = $this->isDate($values['from']) ? $values['from'] : null;
        }
        if (isset($values['to'])) {
            $toDate = $this->isDate($values['to']) ? $values['to'] : null;
        }

        if (!empty($fromDate)) {
            $query->whereDate($name, '>=', $fromDate);
        }
        if (!empty($toDate)) {
            $query->whereDate($name, '<=', $toDate);
        }
    }

    public function addQueryDateLike(Builder $query, $name, $values)
    {
        // 初期値セット
        $year = (isset($values['year']) && !empty($values['year']));
        $month = (isset($values['month']) && !empty($values['month']));
        $day = (isset($values['day']) && !empty($values['day']));

        $like = '';

        if ($year === false && $month === false && $day === false) {
            return;
        }

        if ($year) {
            $like = $values['year'];
        } else {
            $like = '%';
        }
        if ($month) {
            $like .= '-'.$values['month'];
        } elseif($day == false) {
            $like = '-%';
        }

        if ($day) {
            $like .= '-'.$values['day'];
        } elseif($month == false) {
            $like .= '-%';
        }

        $query->where($name, 'LIKE', $like);

    }

    /**
     * 日付の整合性チェック
     * 次の形式を想定：2018-09-17
     *
     * @param $date
     * @return null or $date
     */
    private function isDate($date)
    {
        if (empty($date)) {
            return false;
        }
        $date = str_replace('/','-', $date);
        // 書式チェック
        if (!preg_match('/(\d{4})-(\d{2})-(\d{2})/', $date, $m)) {
            return false;
        }

        // 日付整合性チェック
        if (checkdate($m[2], $m[3], $m[1]) === false) {
            return false;
        }

        return true;
    }

    public function addaddQueryRangeDateTime(Builder $query, $name, $values)
    {
        if (isset($values['from']) && ! empty($values['from'])) {
            $query->where($name, '>=', $values['from']);
        }
        if (isset($values['to']) && ! empty($values['to'])) {
            $query->where($name, '<=', $values['to']);
        }
    }

    /**
     * NULL,NotNull判定
     * @param Builder $query
     * @param string $name
     * @param bool $value
     * @return void
     */
    public function addQueryNullOrNotNull(Builder $query, $name, $value)
    {
        if (true == $value) {
            $this->addQueryIsNull($query, $name);
        } else {
            $this->addQueryIsNotNull($query, $name);
        }
    }

    /**
     * Inクエリ
     * @param Builder $query
     * @param $name
     * @param $values
     * @return void
     */
    public function addQueryIn(Builder $query, $name, $values)
    {
        if (empty($values)) {
            return;
        }
        $query->whereIn($name, $values);
    }

    /**
     * 文字列をBooleranに変更（検索フォーム用）
     *
     * @param $strBool
     * @return boolean|null$this->>
     */
    public function convBoolean($strBool)
    {
        $val = ['false' => false, 'true' => true];
        if (! empty($strBool) && in_array($strBool, $val)) {
            return $val[$strBool];
        }

        return null;
    }
}
