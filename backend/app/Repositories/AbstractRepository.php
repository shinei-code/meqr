<?php
/**
 * Created by PhpStorm.
 * User: kei
 * Date: 2018/09/10
 * Time: 9:36
 */

namespace App\Repositories;


use App\Repositories\Traits\RepositoryQueryTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractRepository
{
    use RepositoryQueryTrait;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;
    /** @var null | \Illuminate\Database\Eloquent\Collection | self[] */
    protected $collection = null;
    /** @var null | \Illuminate\Database\Eloquent\Builder | \Illuminate\Pagination\LengthAwarePaginator */
    protected $query = null;
    /** @var null | Request */
    protected $request = null;

    /**
     * 初期化（Builder,Collection）
     * @return $this
     */
    public function refresh()
    {
        $this->query = $this->model->newQuery();
        $this->collection = null;

        return $this;
    }

    /**
     * 取得件数
     *
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->query->limit($limit);

        return $this;
    }

    /**
     * ソート(order)指定
     * @param array $sort
     * @return $this
     */
    public function sort($sort = ['created_at' => 'desc'])
    {
        $this->query->sortable($sort);

        return $this;
    }

    /**
     * ページネーション
     * @param int $perPage 1ページ取得件数
     * @return $this
     */
    public function paginate($perPage = 30)
    {
        // URLパラメータにlimtが存在する場合はそれを優先させる。
        if ($this->request->query('limit')) {
            $perPage = $this->request->query('limit');
        }

        $this->query = $this->query->paginate($perPage)->appends($this->request->except('page'));
        $this->collection = $this->query->getCollection();

        return $this;
    }

    /**
     * クエリを実行し結果をcollectionへ
     *
     * @return $this
     */
    public function collection()
    {
        $this->collection = $this->query->get();

        return $this;
    }

    /**
     * ページネーションを使用している場合はページネーター、それ以外はCollectionを取得
     *
     * @return \Illuminate\Database\Eloquent\Collection|LengthAwarePaginator
     */
    public function get()
    {
        if ($this->query instanceof LengthAwarePaginator) {
            return $this->query;
        }
        return $this->collection;
    }

    /**
     * １件取得
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|null|object
     */
    public function first()
    {
        return $this->query->first();
    }

    /**
     * リレーション指定
     *
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->query->with($relations);

        return $this;
    }

    public function select($columns = ['*'])
    {
        $this->query->select($columns);

        return $this;

    }

    /**
     * distinct
     * @return $this
     */
    public function distinct()
    {
        $this->query->distinct();

        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->query->orderBy($column, $direction);

        return $this;
    }

    public function chunk($count, callable $callback)
    {
        return $this->query->chunk($count, $callback);
    }

//    /**
//     * 論理削除済みを含める
//     */
//    public function withTrashed()
//    {
//        return $this->query->withTrashed();
//    }

    /**
     * カウント
     */
    public function count()
    {
        return $this->query->count();
    }
}
