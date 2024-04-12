<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Repositories\HospitalRepository;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /** @var HospitalRepository */
    protected $repository;

    /**
     * HospitalController constructor.
     * @param HospitalRepository $repository
     */
    public function __construct(HospitalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return $this->repository->findPublic($request);
    }

    public function show($id)
    {
        return Hospital::find($id);
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
