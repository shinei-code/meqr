<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Repositories\InsuranceRepository;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    /** @var InsuranceRepository*/
    protected $repository;

    /**
     * InsuranceController constructor.
     * @param InsuranceRepository $repository
     */
    public function __construct(InsuranceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return $this->repository->findPublic($request);
    }
    public function show($id)
    {
        return Insurance::find($id);
    }

    public function type($type)
    {
        return $this->repository->findType($type);
    }
    public function code($code)
    {
        return $this->repository->findCode($code);
    }
}
