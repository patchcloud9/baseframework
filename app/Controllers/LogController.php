<?php

namespace App\Controllers;

use App\Services\LogService;

/**
 * Log Controller
 * 
 * Manages application logs using the LogService (dual database + file logging).
 */
class LogController extends Controller
{
    private LogService $logService;
    
    public function __construct()
    {
        $this->logService = new LogService();
    }
    
    /**
     * List all logs
     * Route: GET /logs
     */
    public function index(): void
    {
        // Get all logs (from database with file fallback)
        $logs = $this->logService->all();
        
        // Reverse so newest are first (for file-based logs)
        // Database logs are already ordered by created_at DESC
        if (!empty($logs) && isset($logs[0]['timestamp'])) {
            // File-based logs - reverse them
            $logs = array_reverse($logs);
        }
        
        $this->view('logs/index', [
            'title' => 'Application Logs',
            'logs'  => $logs,
        ]);
    }
    
    /**
     * Show a single log entry
     * Route: GET /logs/(\d+)
     */
    public function show(string $id): void
    {
        $logId = (int) $id;
        $log = $this->logService->find($logId);
        
        if (!$log) {
            $this->flash('error', "Log entry #{$id} not found");
            $this->redirect('/logs');
            return;
        }
        
        $this->view('logs/show', [
            'title' => "Log #{$id}",
            'log'   => $log,
        ]);
    }
    
    /**
     * Create a test log entry
     * Route: GET /logs/test
     */
    public function test(): void
    {
        $levels = ['info', 'warning', 'error', 'debug'];
        $messages = [
            'User logged in successfully',
            'Failed login attempt',
            'Database connection timeout',
            'Cache cleared',
            'File uploaded',
            'Payment processed',
        ];
        
        $this->logService->add(
            $levels[array_rand($levels)],
            $messages[array_rand($messages)],
            ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']
        );
        
        $this->flash('success', 'Test log entry created (logged to both database and file)');
        $this->redirect('/logs');
    }
    
    /**
     * Clear all logs
     * Route: POST /logs/clear
     */
    public function clear(): void
    {
        $this->logService->clear();
        
        $this->flash('success', 'All logs cleared (both database and file)');
        $this->redirect('/logs');
    }
}