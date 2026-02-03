<?php

namespace App\Services;

use App\Models\Log;

/**
 * Log Service
 * 
 * Logs to both database AND file for redundancy.
 * File logging always works, even if database is unavailable.
 */
class LogService
{
    private string $logFile;
    
    public function __construct()
    {
        // Store logs in the storage folder as backup
        $this->logFile = BASE_PATH . '/storage/logs/app.json';
        
        // Ensure directory exists
        $dir = dirname($this->logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    /**
     * Get all logs (from database, fallback to file)
     */
    public function all(): array
    {
        try {
            // Try database first
            return Log::all();
        } catch (\Exception $e) {
            // Fallback to file if database unavailable
            return $this->getFromFile();
        }
    }
    
    /**
     * Get a single log by ID
     */
    public function find(int $id): ?array
    {
        try {
            // Try database first
            return Log::find($id);
        } catch (\Exception $e) {
            // Fallback to file
            return $this->findInFile($id);
        }
    }
    
    /**
     * Add a new log entry (to BOTH database and file)
     */
    public function add(string $level, string $message, array $context = []): void
    {
        // Always log to file first (guaranteed to work)
        $this->logToFile($level, $message, $context);
        
        // Try to log to database (but don't fail if it doesn't work)
        try {
            Log::log($level, $message, $context);
        } catch (\Exception $e) {
            // Database logging failed, but file logging succeeded
            // Optionally log this failure to the file
            error_log("Failed to log to database: " . $e->getMessage());
        }
    }
    
    /**
     * Clear all logs (both database and file)
     */
    public function clear(): void
    {
        // Clear file
        file_put_contents($this->logFile, '[]');
        
        // Try to clear database
        try {
            $db = \Core\Database::getInstance();
            $db->execute("TRUNCATE TABLE logs");
        } catch (\Exception $e) {
            // Database clear failed, but file was cleared
            error_log("Failed to clear database logs: " . $e->getMessage());
        }
    }
    
    /**
     * Get logs from file
     */
    private function getFromFile(): array
    {
        if (!file_exists($this->logFile)) {
            return [];
        }
        
        $contents = file_get_contents($this->logFile);
        return json_decode($contents, true) ?? [];
    }
    
    /**
     * Find a log in file
     */
    private function findInFile(int $id): ?array
    {
        $logs = $this->getFromFile();
        
        foreach ($logs as $log) {
            if ($log['id'] === $id) {
                return $log;
            }
        }
        
        return null;
    }
    
    /**
     * Log to file
     */
    private function logToFile(string $level, string $message, array $context = []): void
    {
        $logs = $this->getFromFile();
        
        // Generate a simple incrementing ID
        $maxId = 0;
        foreach ($logs as $log) {
            if ($log['id'] > $maxId) {
                $maxId = $log['id'];
            }
        }
        
        $logs[] = [
            'id'        => $maxId + 1,
            'level'     => $level,
            'message'   => $message,
            'context'   => $context,
            'timestamp' => date('Y-m-d H:i:s'),
        ];
        
        file_put_contents($this->logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }
}