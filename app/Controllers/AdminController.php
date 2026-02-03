<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Log;

/**
 * Admin Controller
 * 
 * Handles admin panel and admin-only functionality.
 * All routes protected by role:admin middleware.
 */
class AdminController extends Controller
{
    /**
     * Show admin dashboard
     * Route: GET /admin
     * Middleware: auth, role:admin
     */
    public function index(): void
    {
        // Get some stats for the dashboard
        $userCount = User::count();
        $adminCount = count(User::where(['role' => 'admin']));
        $regularUserCount = $userCount - $adminCount;
        
        // Get recent logs if available
        $recentLogs = [];
        try {
            $recentLogs = Log::recent(5);
        } catch (\Exception $e) {
            // Logs might not be available
        }
        
        $this->view('admin/index', [
            'title' => 'Admin Panel',
            'userCount' => $userCount,
            'adminCount' => $adminCount,
            'regularUserCount' => $regularUserCount,
            'recentLogs' => $recentLogs,
        ]);
    }
}
