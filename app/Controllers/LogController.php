<?php

namespace App\Controllers;

use App\Services\LogService;

class LogController extends Controller
{
    private LogService $logService;
    
    public function __construct()
    {
        // Create an instance of LogService
        $this->logService = new LogService();
    }
    
    // GET /logs - List all logs
    public function index(): void
    {
        $logs = $this->logService->all();
        
        // Reverse so newest are first
        $logs = array_reverse($logs);
        
        $this->view('logs/index', [
            'title' => 'Application Logs',
            'logs'  => $logs,
        ]);
    }
    
    // GET /logs/(\d+) - View single log
    public function show(string $id): void
    {
        $log = $this->logService->find((int) $id);
        
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
    
    // Let's also add a way to create test logs
    // GET /logs/test - Add a test log entry
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
        
        $this->flash('success', 'Test log entry created');
        $this->redirect('/logs');
    }
    
    // POST /logs/clear - Clear all logs
    public function clear(): void
    {
        $this->logService->clear();
        $this->flash('success', 'All logs cleared');
        $this->redirect('/logs');
    }
}