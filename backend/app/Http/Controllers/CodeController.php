<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Repositories\CodeRepository;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    protected $type = 'code';

    /** @var CodeRepository */
    protected $repository;

    protected $title = 'コード';

    /**
     * GenkyoController constructor.
     * @param CodeRepository $repository
     */
    public function __construct(CodeRepository $repository)
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

        $codes = $this->repository->find($request);

        return view('code.index', compact('codes','title'));
    }

    /**
     * 新規登録画面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = $this->title . '登録';
        $code = new Code();
        $view  = view('code.edit', compact('title', 'code'));
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
        $code = new Code();
        $code->fill($saveData);
        try {
            \DB::beginTransaction();

            $code->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('code.create'));
        }
        $request->session()->flash('success', '登録しました。');

        return redirect(route('code.index'));
    }

    /**
     * 編集画面
     * @param Code $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Code $code)
    {
        $title = $this->title . '編集';

        $view  = view('code.edit', compact('title', 'code'));
        $this->partsEditForm($view);

        return $view;
    }

    /**
     * 更新
     * @param Code $code
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Code $code, Request $request)
    {
        $saveData = $request->except(['_method', '_token']);
        $code->fill($saveData);
        try {
            \DB::beginTransaction();

            $code->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('code.edit', $code));
        }
        $request->session()->flash('success', '更新しました。');

        return redirect(route('code.index'));
    }

    /**
     * 削除
     * @param Request $request
     * @param Code $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Code $code)
    {
        \DB::beginTransaction();
        try {
            if (false === $code->delete()) {
                $request->session()->flash('error', 'エラーが発生しました。');
                return redirect(route('code.index'));
            }
            \DB::commit();
        } catch (\Exception $e) {
            info($e->getMessage());
            \DB::rollBack();
            $request->session()->flash('error', 'エラーが発生しました。');

            return redirect(route('code.index'));
        }
        $request->session()->flash('success', $this->title . 'を削除しました。');

        return redirect(route('code.index'));
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
