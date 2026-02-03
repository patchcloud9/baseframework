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
        $result = $this->logService->all();
        
        // Extract logs and metadata
        $logs = $result['logs'];
        $source = $result['source'];
        $databaseAvailable = $result['database_available'];
        
        // Reverse so newest are first (for file-based logs)
        // Database logs are already ordered by created_at DESC
        if ($source === 'file' && !empty($logs)) {
            $logs = array_reverse($logs);
        }
        
        $this->view('logs/index', [
            'title' => 'Application Logs',
            'logs'  => $logs,
            'source' => $source,
            'databaseAvailable' => $databaseAvailable,
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
     * Create a test log entry in FILE ONLY (for testing sync)
     * Route: GET /logs/test-file
     */
    public function testFile(): void
    {
        $levels = ['info', 'warning', 'error', 'debug'];
        $messages = [
            'File-only test log entry',
            'Testing sync functionality',
            'This log should sync to database',
            'File backup test message',
        ];
        
        $this->logService->addToFileOnly(
            $levels[array_rand($levels)],
            $messages[array_rand($messages)],
            ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown', 'test' => true]
        );
        
        $this->flash('info', 'Test log created in FILE ONLY - use Sync button to add to database');
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
    
    /**
     * Sync file logs to database
     * Route: POST /logs/sync
     */
    public function sync(): void
    {
        $result = $this->logService->syncToDatabase();
        
        if ($result['success']) {
            if ($result['synced'] > 0) {
                $this->flash('success', "Synced {$result['synced']} logs to database. Skipped {$result['skipped']} duplicates.");
            } else {
                $this->flash('info', 'No new logs to sync.');
            }
        } else {
            $errorMsg = 'Sync failed: ' . implode(', ', $result['errors']);
            $this->flash('error', $errorMsg);
        }
        
        $this->redirect('/logs');
    }
}