<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Repositories\HospitalRepository;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    protected $type = 'hospital';

    /** @var HospitalRepository */
    protected $repository;

    protected $title = 'コード';

    /**
     * GenkyoController constructor.
     * @param HospitalRepository $repository
     */
    public function __construct(HospitalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 一覧
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = $this->title . '一覧';

        $hospitals = $this->repository->find($request);

        return view('hospital.index', compact('hospitals','title'));
    }

    /**
     * 新規登録画面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = $this->title . '登録';
        $hospital = new Hospital();
        $view  = view('hospital.edit', compact('title', 'hospital'));
        $this->partsEditForm($view);

        return $view;
    }

    /**
     * 新規登録
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $saveData = $request->except(['_method', '_token']);
        $hospital = new Hospital();
        $hospital->fill($saveData);
        try {
            \DB::beginTransaction();

            $hospital->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('hospital.create'));
        }
        $request->session()->flash('success', '登録しました。');

        return redirect(route('hospital.index'));
    }

    /**
     * 編集画面
     * @param Hospital $hospital
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Hospital $hospital)
    {
        $title = $this->title . '編集';

        $view  = view('hospital.edit', compact('title', 'hospital'));
        $this->partsEditForm($view);

        return $view;
    }

    /**
     * 更新
     * @param Hospital $hospital
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Hospital $hospital, Request $request)
    {
        $saveData = $request->except(['_method', '_token']);
        $hospital->fill($saveData);
        try {
            \DB::beginTransaction();

            $hospital->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('hospital.edit', $hospital));
        }
        $request->session()->flash('success', '更新しました。');

        return redirect(route('hospital.index'));
    }

    /**
     * 削除
     * @param Request $request
     * @param Hospital $hospital
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Hospital $hospital)
    {
        \DB::beginTransaction();
        try {
            if (false === $hospital->delete()) {
                $request->session()->flash('error', 'エラーが発生しました。');
                return redirect(route('hospital.index'));
            }
            \DB::commit();
        } catch (\Exception $e) {
            info($e->getMessage());
            \DB::rollBack();
            $request->session()->flash('error', 'エラーが発生しました。');

            return redirect(route('hospital.index'));
        }
        $request->session()->flash('success', $this->title . 'を削除しました。');

        return redirect(route('hospital.index'));
    }

    /**
     * CSV
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View\
     */
    public function csv(Request $request)
    {
        return $this->export_csv($request);
    }

    /**
     * @param \Illuminate\View\View|\Illuminate\Contracts\View\Factory $view
     */
    private function partsEditForm($view)
    {
    }
}
