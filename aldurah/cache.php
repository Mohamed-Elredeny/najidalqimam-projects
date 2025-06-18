<?php
// Comprehensive Cache Clearing Script

// Clear PHP internal opcache
if (function_exists('opcache_reset')) {
    opcache_reset();
}

// Clear APCu cache if available
if (function_exists('apcu_clear_cache')) {
    apcu_clear_cache();
}

// Clear APC cache if available
if (function_exists('apc_clear_cache')) {
    apc_clear_cache('user');
    apc_clear_cache('system');
}

// Clear Memcached cache if configured
function clearMemcachedCache() {
    $memcache = new Memcache;
    $memcache->connect('localhost', 11211);
    $memcache->flush();
}

// Clear Redis cache if configured
function clearRedisCache() {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->flushAll();
}

// Extensive HTTP cache control headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
header("Expires: " . gmdate("D, d M Y H:i:s", time() - 3600) . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// Browser cache clearing
header("Clear-Site-Data: \"cache\"");

// Prevent caching of this specific page
header("X-Accel-Expires: 0");
header("X-Proxy-Cache-Control: no-cache");

// Additional browser-specific cache control
ini_set('session.cache_limiter', 'nocache');
session_cache_limiter(false);

// Clear session data
session_start();
session_unset();
session_destroy();

// Try to clear some server-side caches (uncomment as needed and ensure appropriate permissions)
try {
    // Attempt to clear temporary file caches
    $tempDir = sys_get_temp_dir();
    $files = glob($tempDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            @unlink($file);
        }
    }
} catch (Exception $e) {
    // Log error if needed
    error_log('Cache clearing error: ' . $e->getMessage());
}

// Optional: Redirect or continue with page load
// header("Location: https://ai.najidalqimam.sa/");
// exit();
?>