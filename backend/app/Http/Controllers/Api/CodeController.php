<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Repositories\CodeRepository;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    /** @var CodeRepository*/
    protected $repository;

    /**
     * CodeController constructor.
     * @param CodeRepository $repository
     */
    public function __construct(CodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return $this->repository->findPublic($request);
    }
    public function show($id)
    {
        return Code::find($id);
    }

    public function category($category)
    {
        return $this->repository->findCategory($category);
    }
    public function one($category, $key)
    {
        return $this->repository->findOne($category, $key);
    }
    public function uid(Request $request)
    {
        return $request->uid == $this->repository->findOne('config', 'uid')->value ? "true" : "false";
    }
}
