<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Repositories\InsuranceRepository;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    protected $type = 'insurance';

    /** @var InsuranceRepository */
    protected $repository;

    protected $title = 'コード';

    /**
     * GenkyoController constructor.
     * @param InsuranceRepository $repository
     */
    public function __construct(InsuranceRepository $repository)
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

        $insurances = $this->repository->find($request);

        return view('insurance.index', compact('insurances','title'));
    }

    /**
     * 新規登録画面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = $this->title . '登録';
        $insurance = new Insurance();
        $view  = view('insurance.edit', compact('title', 'insurance'));
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
        $insurance = new Insurance();
        $insurance->fill($saveData);
        try {
            \DB::beginTransaction();

            $insurance->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('insurance.create'));
        }
        $request->session()->flash('success', '登録しました。');

        return redirect(route('insurance.index'));
    }

    /**
     * 編集画面
     * @param Insurance $insurance
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Insurance $insurance)
    {
        $title = $this->title . '編集';

        $view  = view('insurance.edit', compact('title', 'insurance'));
        $this->partsEditForm($view);

        return $view;
    }

    /**
     * 更新
     * @param Insurance $insurance
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Insurance $insurance, Request $request)
    {
        $saveData = $request->except(['_method', '_token']);
        $insurance->fill($saveData);
        try {
            \DB::beginTransaction();

            $insurance->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('insurance.edit', $insurance));
        }
        $request->session()->flash('success', '更新しました。');

        return redirect(route('insurance.index'));
    }

    /**
     * 削除
     * @param Request $request
     * @param Insurance $insurance
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Insurance $insurance)
    {
        \DB::beginTransaction();
        try {
            if (false === $insurance->delete()) {
                $request->session()->flash('error', 'エラーが発生しました。');
                return redirect(route('insurance.index'));
            }
            \DB::commit();
        } catch (\Exception $e) {
            info($e->getMessage());
            \DB::rollBack();
            $request->session()->flash('error', 'エラーが発生しました。');

            return redirect(route('insurance.index'));
        }
        $request->session()->flash('success', $this->title . 'を削除しました。');

        return redirect(route('insurance.index'));
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
