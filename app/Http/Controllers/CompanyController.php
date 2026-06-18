<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\ActivityLogService;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = Company::where('id', auth()->user()->company_id)->get();

        return response()->json($companies);
    }

    public function store(CompanyRequest $request, ActivityLogService $activityLogService): JsonResponse
    {
        $company = Company::create($request->validated());
        $activityLogService->record($company, 'created', "Company {$company->company_name} created", auth()->user());

        return response()->json($company, 201);
    }

    public function show(Company $company): JsonResponse
    {
        $this->authorize('view', $company);

        return response()->json($company);
    }

    public function update(CompanyRequest $request, Company $company, ActivityLogService $activityLogService): JsonResponse
    {
        $this->authorize('update', $company);

        $company->update($request->validated());
        $activityLogService->record($company, 'updated', "Company {$company->company_name} updated", auth()->user());

        return response()->json($company);
    }

    public function destroy(Company $company): JsonResponse
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response()->json(['message' => 'Company removed.']);
    }
}
