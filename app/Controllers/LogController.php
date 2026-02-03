<?php

namespace App\Controllers;

use App\Models\Log;

/**
 * Log Controller
 * 
 * Manages application logs using the Log model.
 */
class LogController extends Controller
{
    /**
     * List all logs
     * Route: GET /logs
     */
    public function index(): void
    {
        // Get recent logs (newest first)
        $logs = Log::recent(50);
        
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
        $log = Log::find($logId);
        
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
        
        Log::log(
            $levels[array_rand($levels)],
            $messages[array_rand($messages)],
            ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']
        );
        
        $this->flash('success', 'Test log entry created');
        $this->redirect('/logs');
    }
    
    /**
     * Clear all logs
     * Route: POST /logs/clear
     */
    public function clear(): void
    {
        // Delete all log entries
        $db = \Core\Database::getInstance();
        $db->execute("TRUNCATE TABLE logs");
        
        $this->flash('success', 'All logs cleared');
        $this->redirect('/logs');
    }
}