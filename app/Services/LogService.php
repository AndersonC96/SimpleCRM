<?php
    namespace Tisim\SimpleCrm\Services;
    class LogService {
        public static function write(string $filename, string $message): void {
            $logDir = __DIR__ . '/../../storage/logs';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }
            $filepath = "{$logDir}/{$filename}.log";
            $timestamp = date('Y-m-d H:i:s');
            file_put_contents($filepath, "[{$timestamp}] {$message}\n", FILE_APPEND);
        }
    }