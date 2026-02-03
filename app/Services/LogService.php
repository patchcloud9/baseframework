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
     * Returns array with 'logs' and 'source' keys
     */
    public function all(): array
    {
        try {
            // Try database first
            $logs = Log::all();
            return [
                'logs' => $logs,
                'source' => 'database',
                'database_available' => true
            ];
        } catch (\Exception $e) {
            // Fallback to file if database unavailable
            return [
                'logs' => $this->getFromFile(),
                'source' => 'file',
                'database_available' => false
            ];
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
     * Check if database is available
     */
    public function isDatabaseAvailable(): bool
    {
        try {
            $db = \Core\Database::getInstance();
            $db->query("SELECT 1");
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Sync file logs to database
     * Copies all logs from file to database (avoiding duplicates)
     */
    public function syncToDatabase(): array
    {
        $result = [
            'success' => false,
            'synced' => 0,
            'skipped' => 0,
            'errors' => []
        ];
        
        // Check if database is available
        if (!$this->isDatabaseAvailable()) {
            $result['errors'][] = 'Database is not available';
            return $result;
        }
        
        // Get logs from file
        $fileLogs = $this->getFromFile();
        
        if (empty($fileLogs)) {
            $result['success'] = true;
            return $result;
        }
        
        // Get existing log messages from database to avoid duplicates
        try {
            $existingLogs = Log::all();
            $existingMessages = array_column($existingLogs, 'message');
            
            foreach ($fileLogs as $log) {
                // Skip if this log already exists in database (by message and level)
                $exists = false;
                foreach ($existingLogs as $existing) {
                    if ($existing['message'] === $log['message'] && 
                        $existing['level'] === $log['level']) {
                        $exists = true;
                        break;
                    }
                }
                
                if ($exists) {
                    $result['skipped']++;
                    continue;
                }
                
                // Add to database
                try {
                    Log::log(
                        $log['level'],
                        $log['message'],
                        $log['context'] ?? []
                    );
                    $result['synced']++;
                } catch (\Exception $e) {
                    $result['errors'][] = "Failed to sync log #{$log['id']}: " . $e->getMessage();
                }
            }
            
            $result['success'] = true;
            
        } catch (\Exception $e) {
            $result['errors'][] = 'Failed to sync: ' . $e->getMessage();
        }
        
        return $result;
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