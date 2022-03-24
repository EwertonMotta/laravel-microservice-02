<?php

namespace App\Http\Controllers\Api;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluation;
use App\Http\Resources\EvaluationResource;

class EvaluationContoller extends Controller
{
    protected $repository;
    protected $companyService;

    public function __construct(Evaluation $evaluation, CompanyService $companyService)
    {
        $this->repository = $evaluation;
        $this->companyService = $companyService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company)
    {
        $evaluations = $this->repository->whereCompany($company)->get();

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvaluation $request, $company)
    {
        $response = $this->companyService->getCompany($company);
        if (($status = $response->status()) != 200) {
            return response()->json([
                'message' => 'Invalid Company'
            ], $status);
        }

        $evaluation = $this->repository->create($request->validated());

        return new EvaluationResource($evaluation);
    }
}
