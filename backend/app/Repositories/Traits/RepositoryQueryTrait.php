<?php

namespace App\Repositories\Traits;

/**
 * Trait AuthQueryTrait
 * @package App\Repositories\Traits
 *
 * @property \Illuminate\Database\Eloquent\Builder $query
 */
trait RepositoryQueryTrait
{
    /**
     * カンマ区切りのデータをInで検索する。
     *
     * @param string $key フィールド名
     * @param mixed $value カンマ区切りのデータ
     * @return $this
     */
    protected function addArrayQuery($key, $value)
    {
        if (null === $value) {
            return $this;
        }

        $values = explode(',', $value);
        $this->query->whereIn($key, $values);

        return $this;
    }

    /**
     * int型クエリ追加
     * @param string $key フィールド名
     * @param mixed $value
     * @param string $operator
     * @return $this
     */
    protected function addQuery($key, $value, $operator = '=', $or = false)
    {
        if (null === $value) {
            return $this;
        }
        if ($or) {
            $this->query->orWhere($key, $operator, $value);
        } else {
            $this->query->where($key, $operator, $value);
        }

        return $this;
    }

    /**
     * Booleanクエリ追加
     *
     * @param string $key
     * @param int|boolean|string $value
     * @return $this
     */
    protected function addQueryBoolean($key, $value)
    {
        if (null === $value) {
            return $this;
        }

        if (false === $value || 0 === $value || '0' === $value) {
            $bool = false;
        } elseif (true === $value || 1 === $value || '1' === $value) {
            $bool = true;
        } else {
            return $this;
        }

        $this->query->where($key, $bool);

        return $this;
    }

    /**
     * LIKE（部分一致）クエリ追加
     * @param string $key
     * @param string $value
     * @return $this
     */
    protected function addQueryLike($key, $value)
    {
        if (empty($value)) {
            return $this;
        }
        $this->query->where($key, 'LIKE', '%' . $value . '%');

        return $this;
    }

    /**
     * IsNullクエリ追加
     *
     * @param $key
     * @return $this
     */
    protected function addQueryIsNull($key, $or = false)
    {
        if ($or) {
            $this->query->orWhereNull($key);
        } else {
            $this->query->whereNull($key);
        }

        return $this;
    }

    /**
     * IsNotNullクエリ追加
     *
     * @param $key
     * @return $this
     */
    protected function addQueryIsNotNull($key, $or = false)
    {
        if ($or) {
            $this->query->orWhereNull($key);
        } else {
            $this->query->whereNotNull($key);
        }

        return $this;
    }

    /**
     * 日付範囲(from - to)
     * @return $this
     */
    public function addQueryRangeDate($name, $values)
    {
        if (isset($values['from']) && ! empty($values['from'])) {
            $this->query->where($name, '>=', $values['from']);
        }
        if (isset($values['to']) && ! empty($values['to'])) {
            $this->query->where($name, '<=', $values['to']);
        }

        return $this;
    }

    /**
     * NULL,NotNull判定
     * @param string $name
     * @param bool $value
     * @return $this
     */
    public function addQueryNullOrNotNull($name, $value)
    {
        if (true == $value) {
            $this->addQueryIsNull($name);
        } else {
            $this->addQueryIsNotNull($name);
        }

        return $this;
    }

    /**
     * Inクエリ
     * @param $name
     * @param $values
     * @return $this
     */
    public function addQueryIn($name, $values)
    {
        if (empty($values)) {
            return $this;
        }
        $this->query->whereIn($name, $values);

        return $this;
    }

    /**
     * 文字列をBooleranに変更（検索フォーム用）
     *
     * @param $strBool
     * @return boolean|null
     */
    protected function convBoolean($strBool)
    {
        $val = ['false' => false, 'true' => true];
        if (! empty($strBool) && in_array($strBool, $val)) {
            return $val[$strBool];
        }

        return null;
    }
}
