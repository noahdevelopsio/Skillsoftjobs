<?php
// Function to get the visitor's real IP address
function getVisitorIP() {
    $ip = '';
    // Check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    // Check for IPs passing through proxies
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // HTTP_X_FORWARDED_FOR can contain multiple comma-separated IPs. The first one is typically the real IP.
        $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ip_list[0]);
    }
    // Fallback to the remote address
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // Basic validation
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : 'UNKNOWN';
}

function trackVisitor($conn) {
    if (!$conn) return;

    $ip = getVisitorIP();
    
    // Ignore localhost/local network IPs for API calls to avoid failures on dev
    if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0) {
        $country = 'Local Network';
        $city = 'Localhost';
        $region = 'Local';
        $zip = '00000';
        $timezone = 'Local';
        $isp = 'Local Network';
    } else {
        // Simple 24-hour cache mechanism to prevent spamming the geocoding API for the same IP
        // VERCEL FIX: Use /tmp instead of __DIR__
        $cache_dir = '/tmp/.ip_cache';
        $cache_file = $cache_dir . '/' . md5($ip) . '.json';
         if (!is_dir($cache_dir)) { @mkdir($cache_dir, 0755, true); } 

        $geoData = null;
        if (file_exists($cache_file) && (time() - filemtime($cache_file)) < 86400) {
            $geoData = json_decode(file_get_contents($cache_file), true);
        } else {
            // Fetch extended details from ip-api.com
            $api_url = "http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,zip,timezone,isp";
            
            // Use stream context to set a short timeout so we don't block page load
            $ctx = stream_context_create(['http' => ['timeout' => 2]]);
            $response = @file_get_contents($api_url, false, $ctx);
            
            if ($response) {
                $geoDataTemp = json_decode($response, true);
                if (isset($geoDataTemp['status']) && $geoDataTemp['status'] === 'success') {
                     $geoData = $geoDataTemp;
                      @file_put_contents($cache_file, json_encode($geoData), LOCK_EX);
                }
            }
        }

        $country = $geoData['country'] ?? 'Unknown';
        $city = $geoData['city'] ?? 'Unknown';
        $region = $geoData['regionName'] ?? 'Unknown';
        $zip = $geoData['zip'] ?? 'Unknown';
        $timezone = $geoData['timezone'] ?? 'Unknown';
        $isp = $geoData['isp'] ?? 'Unknown';
    }

    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $page_visited = $_SERVER['REQUEST_URI'] ?? 'Unknown';

    try {
        $stmt = $conn->prepare("INSERT INTO visitors (ip_address, country, city, region, zip, time_zone, isp, user_agent, page_visited) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssssssss", $ip, $country, $city, $region, $zip, $timezone, $isp, $user_agent, $page_visited);
            $stmt->execute();
            $stmt->close();
        }
    } catch (Exception $e) {
         // Silently fail, tracking should never break the main app
         error_log("Failed to track visitor: " . $e->getMessage());
    }
}
?>
