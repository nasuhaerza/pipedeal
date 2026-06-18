<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends Controller
{
    public function index(): JsonResponse
    {
        $logs = ActivityLog::with(['user', 'loggable'])->get();

        return response()->json($logs);
    }
}
