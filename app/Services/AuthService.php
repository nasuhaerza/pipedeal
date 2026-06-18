<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(protected ActivityLogService $activityLogService)
    {
    }

    public function registerCompany(array $companyData, array $userData): User
    {
        return DB::transaction(function () use ($companyData, $userData) {
            $company = Company::create($companyData);

            $user = User::create([
                'company_id' => $company->id,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'role' => UserRole::COMPANY_ADMIN,
            ]);

            $this->activityLogService->record($user, 'company_registered', "Company {$company->company_name} registered", $user);

            return $user;
        });
    }

    public function createBusinessDevelopment(User $companyAdmin, array $userData): User
    {
        if ($companyAdmin->role !== UserRole::COMPANY_ADMIN) {
            throw new \InvalidArgumentException('Only company admins can create business development users.');
        }

        $user = User::create([
            'company_id' => $companyAdmin->company_id,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'role' => UserRole::BUSINESS_DEVELOPMENT,
        ]);

        $this->activityLogService->record($user, 'user_created', "Business development {$user->name} created", $companyAdmin);

        return $user;
    }
}
