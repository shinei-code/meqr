<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /** @var UserRepository */
    protected $repository;

    protected $title = '職員';

    /**
     * GenkyoController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
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

        $users = $this->repository->find($request);

        return view('user.index', compact('users','title'));
    }

    /**
     * 新規登録画面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = $this->title . '登録';
        $user = new User();
        $view  = view('user.edit', compact('title', 'user'));
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
        $user = new User();
        $user->fill($saveData);
        try {
            \DB::beginTransaction();

            $user->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('user.create'));
        }
        $request->session()->flash('success', '登録しました。');

        return redirect(route('user.index'));
    }

    /**
     * 編集画面
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $title = $this->title . '編集';

        $view  = view('user.edit', compact('title', 'user'));
        $this->partsEditForm($view);

        return $view;
    }

    /**
     * 更新
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, Request $request)
    {
        try {
            $saveData = $request->except(['_method', '_token']);
            if($saveData['password'] == '') {
                unset($saveData['password']);
            }
            $user->fill($saveData);
            \DB::beginTransaction();

            $user->save();
            \DB::commit();

        } catch (\PDOException $e) {

            \DB::rollBack();

            return redirect(route('user.edit', $user));
        }
        $request->session()->flash('success', '更新しました。');

        return redirect(route('user.index'));
    }

    /**
     * 削除
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, User $user)
    {
        \DB::beginTransaction();
        try {
            if (false === $user->delete()) {
                $request->session()->flash('error', 'エラーが発生しました。');
                return redirect(route('user.index'));
            }
            \DB::commit();
        } catch (\Exception $e) {
            info($e->getMessage());
            \DB::rollBack();
            $request->session()->flash('error', 'エラーが発生しました。');

            return redirect(route('user.index'));
        }
        $request->session()->flash('success', $this->title . 'を削除しました。');

        return redirect(route('user.index'));
    }

    /**
     * @param \Illuminate\View\View|\Illuminate\Contracts\View\Factory $view
     */
    private function partsEditForm($view)
    {
//        $roles = config('code.role');
//
//        $view->with(compact('roles'));
    }
}
