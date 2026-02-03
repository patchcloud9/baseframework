<?php

namespace App\Services;

class LogService
{
    private string $logFile;
    
    public function __construct()
    {
        // Store logs in the storage folder
        $this->logFile = BASE_PATH . '/storage/logs/app.json';
    }
    
    // Get all logs
    public function all(): array
    {
        if (!file_exists($this->logFile)) {
            return [];
        }
        
        $contents = file_get_contents($this->logFile);
        return json_decode($contents, true) ?? [];
    }
    
    // Get a single log by ID
    public function find(int $id): ?array
    {
        $logs = $this->all();
        
        foreach ($logs as $log) {
            if ($log['id'] === $id) {
                return $log;
            }
        }
        
        return null;
    }
    
    // Add a new log entry
    public function add(string $level, string $message, array $context = []): void
    {
        $logs = $this->all();
        
        // Generate a simple incrementing ID
        $maxId = 0;
        foreach ($logs as $log) {
            if ($log['id'] > $maxId) {
                $maxId = $log['id'];
            }
        }
        
        $logs[] = [
            'id'        => $maxId + 1,
            'level'     => $level,      // 'info', 'warning', 'error', etc.
            'message'   => $message,
            'context'   => $context,    // Any extra data
            'timestamp' => date('Y-m-d H:i:s'),
        ];
        
        file_put_contents($this->logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }
    
    // Clear all logs
    public function clear(): void
    {
        file_put_contents($this->logFile, '[]');
    }
}