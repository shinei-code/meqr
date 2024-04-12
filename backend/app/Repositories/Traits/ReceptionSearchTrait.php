<?php


namespace App\Repositories\Traits;


use App\Repositories\AbstractRepository;
use Illuminate\Http\Request;

/**
 * 受付用
 * Trait ReceptionSearchTrait
 * @package App\Repositories\Traits
 */
trait ReceptionSearchTrait
{
    protected function search(Request $request)
    {
        if($request->has('search')) {
            $search = $request->get('search');

            if (isset($search['naiyou']) && !empty($search['naiyou'])) {
                $this->searchNaiyou($search);
            }
            if (isset($search['residents_id']) && !empty($search['residents_id'])) {
                $this->extension->addQuery($this->query, 'residents_id', $search['residents_id']);
            }
            if (isset($search['uketuke']) && !empty($search['uketuke'])) {
                $this->extension->addQueryRangeDate($this->query, 'uketuke_dt', $search['uketuke']);
            }
            if (isset($search['is_douzishinsei']) && !empty($search['is_douzishinsei'])) {
                $this->extension->addQueryBoolean($this->query, 'is_douzishinsei', ($search['is_douzishinsei'] - 1));
            }
            if (isset($search['rpa']) && !empty($search['rpa'])) {
                $this->extension->addQuery($this->query, 'csv_output_kbn_key', $search['rpa']);
            }
            if (isset($search['is_warning']) && !empty($search['is_warning'])) {
                $this->extension->addQueryBoolean($this->query, 'is_warning', ($search['is_warning'] - 1));
            }

        }

        return $this;
    }

    /**
     * 一覧検索の申請内容
     *  各クラスでオーバーライド
     * @param $search
     * @return $this
     */
    protected function searchNaiyou($search)
    {
        $this->extension->addQuery($this->query, 'sttc_sinseinaiyou_kbn_key', $search['naiyou']);

        return $this;
    }

    /**
     * 住基ID条件
     * @param $residents_id
     * @return $this
     */
    protected function residentsId($residents_id)
    {
        $this->extension->addQuery($this->query, 'residents_id', $residents_id);

        return $this;
    }


    /**
     * 一覧検索
     * @param Request $request
     * @return mixed
     */
    public function find(Request $request)
    {
        return $this->refresh()
            ->search($request)
            ->collection()
            ->get()
            ;
    }


    /**
     * 履歴
     * @param $residents_id
     * @return AbstractRepository[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function history($residents_id)
    {
        return $this->refresh()
            ->residentsId($residents_id)
            ->sort()
            ->collection()->get();

    }
}
