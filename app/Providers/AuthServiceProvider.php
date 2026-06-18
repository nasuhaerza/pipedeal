<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\CommissionShare;
use App\Models\Company;
use App\Models\Deal;
use App\Models\Document;
use App\Models\FollowUp;
use App\Models\PipelineStage;
use App\Models\User;
use App\Policies\ActivityLogPolicy;
use App\Policies\ClientPolicy;
use App\Policies\CommissionSharePolicy;
use App\Policies\CompanyPolicy;
use App\Policies\DealPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\FollowUpPolicy;
use App\Policies\PipelineStagePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        Company::class => CompanyPolicy::class,
        Deal::class => DealPolicy::class,
        CommissionShare::class => CommissionSharePolicy::class,
        Document::class => DocumentPolicy::class,
        FollowUp::class => FollowUpPolicy::class,
        PipelineStage::class => PipelineStagePolicy::class,
        User::class => UserPolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        \Illuminate\Support\Facades\Gate::define('role', function (\App\Models\User $user, string $role) {
            $method = 'is' . str_replace(' ', '', ucwords(str_replace('_', ' ', $role)));
            if (method_exists($user, $method)) {
                return $user->{$method}();
            }

            return false;
        });
    }
}
