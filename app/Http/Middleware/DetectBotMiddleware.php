<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;

class DetectBotMiddleware
{
    private const BOT_USER_AGENTS = [
        'curl', 'wget', 'python', 'java', 'scrapy', 'httpclient', 'bot', 'spider', 'crawler', 'slurp', 'headless',
        'phantomjs', 'bingpreview', 'dataprovider', 'mediapartners', 'googlebot', 'yahooseeker', 'bingbot',
        'facebookexternalhit', 'ia_archiver', 'yandexbot', 'facebot', 'slackbot', 'twitterbot', 'whatsapp',
        'telegrambot', 'guruji', 'happyfunbot', 'hl_ftien_spider', 'holmes', 'htdig', 'iaskspider', 'iccrawler',
        'swiftbot', 'ahrefsbot', 'semrushbot', 'rogerbot', 'gtmetrix', 'baiduspider', 'duckduckbot', 'exabot',
        'dotbot', 'mj12bot', 'seznambot', 'adsbot-google', 'googlefavicon', 'googleimageproxy', 'googlereadaloud',
        'googlebot-mobile', 'googlebot-image', 'googlebot-news', 'googlebot-video', 'paypal', 'paypalbot',
        // Add more known bot user agents here
    ];

    private $knnClassifier;
    private $svcClassifier;

    public function __construct()
    {
        $this->initializeClassifiers();
    }

    public function handle($request, Closure $next)
    {
        $isBot = $this->detectBot($request);

        if ($isBot) {
            Log::info('Bot detected', ['ip' => $request->ip(), 'user_agent' => $request->header('User-Agent')]);
            // Redirect to the admin-created home page with a specific slug
            return redirect()->route('custom.home', ['slug' => 'bot']);
        }

        return $next($request);
    }

    private function initializeClassifiers()
    {
        // Advanced initialization with more samples and features
        $samples = [
            // Features: [request_rate, fingerprint_hash, session_length, navigation_pattern_score]
            [0.1, 0.5, 300, 0.2],
            [5, 0.9, 10, 0.8],
            [0.05, 0.4, 600, 0.1],
            [10, 0.95, 5, 0.9],
            // Add more training data as needed
        ];
        $labels = ['human', 'bot', 'human', 'bot'];

        $this->knnClassifier = new KNearestNeighbors();
        $this->knnClassifier->train($samples, $labels);

        $this->svcClassifier = new SVC(Kernel::LINEAR, $cost = 1000);
        $this->svcClassifier->train($samples, $labels);
    }

    private function detectBot($request)
    {
        $userAgent = $request->header('User-Agent');
        $ipAddress = $request->ip();
        $requestRate = $this->calculateRequestRate($ipAddress);
        $fingerprint = $this->generateAdvancedDeviceFingerprint($request);
        $fingerprintHash = $this->fingerprintHash($fingerprint);
        $isNavigationSuspicious = $this->analyzeNavigationPattern($ipAddress);
        $isBrowserInconsistent = $this->checkBrowserIdentity($request);
        $sessionLength = $this->getSessionLength($request);
        $navigationPatternScore = $this->getNavigationPatternScore($ipAddress);

        // Check IP reputation
        $isBadIp = $this->checkIpReputation($ipAddress);

        // Honeypot detection
        $isHoneypotTriggered = $this->checkHoneypot($request);

        if ($this->isSuspiciousUserAgent($userAgent)
            || $this->isSuspiciousHeaders($request->headers->all())
            || $isNavigationSuspicious
            || $isBrowserInconsistent
            || $isBadIp
            || $isHoneypotTriggered
        ) {
            return true;
        }

        // Use classifiers for final decision
        $features = [
            $requestRate,
            $fingerprintHash,
            $sessionLength,
            $navigationPatternScore,
        ];

        return $this->predictUsingClassifiers($features);
    }

    private function isSuspiciousUserAgent($userAgent)
    {
        $pattern = '/(' . implode('|', self::BOT_USER_AGENTS) . ')/i';
        return preg_match($pattern, $userAgent) === 1;
    }

    private function isSuspiciousHeaders($headers)
    {
        $refererPattern = '/evil-site\.com|(null)/i';
        $ipPattern = '/^127\.|^10\.|^192\.168\./';

        if (empty($headers['User-Agent']) || empty($headers['Accept-Language'])) {
            return true;
        }

        if (isset($headers['Referer']) && preg_match($refererPattern, $headers['Referer'][0])) {
            return true;
        }

        if (isset($headers['X-Forwarded-For']) && preg_match($ipPattern, $headers['X-Forwarded-For'][0])) {
            return true;
        }

        return false;
    }

    private function calculateRequestRate($ip)
    {
        $cacheKey = 'request_rate_' . $ip;
        $requests = Cache::get($cacheKey, 0);
        Cache::put($cacheKey, $requests + 1, now()->addSeconds(60));
        return ($requests + 1) / 60;
    }

    private function generateAdvancedDeviceFingerprint($request)
    {
        $data = $request->header('User-Agent') .
            $request->ip() .
            json_encode($request->headers->all()) .
            $request->server('HTTP_ACCEPT_LANGUAGE') .
            $request->server('HTTP_ACCEPT_ENCODING');

        // Include cookies and session data
        $data .= json_encode($request->cookie()) .
                 json_encode($request->session()->all());

        return hash('sha256', $data);
    }

    private function fingerprintHash($fingerprint)
    {
        // Convert hash string to a numeric value between 0 and 1
        $hashNum = hexdec(substr($fingerprint, 0, 15));
        return $hashNum / hexdec('fffffffffffffff'); // Normalize to [0,1]
    }

    private function analyzeNavigationPattern($ip)
    {
        $cacheKey = 'navigation_pattern_' . $ip;
        $history = Cache::get($cacheKey, []);
        $currentTime = now()->timestamp;
        $history[] = $currentTime;

        Cache::put($cacheKey, $history, now()->addMinutes(10));

        $intervals = [];
        for ($i = 1; $i < count($history); $i++) {
            $intervals[] = $history[$i] - $history[$i - 1];
        }

        if (count($intervals) > 0 && min($intervals) < 2) {
            return true;
        }

        return false;
    }

    private function getNavigationPatternScore($ip)
    {
        $cacheKey = 'navigation_pattern_' . $ip;
        $history = Cache::get($cacheKey, []);
        if (count($history) < 2) {
            return 0;
        }

        $intervals = [];
        for ($i = 1; $i < count($history); $i++) {
            $intervals[] = $history[$i] - $history[$i - 1];
        }

        $averageInterval = array_sum($intervals) / count($intervals);
        // Normalize to [0,1], where lower intervals are more suspicious
        return 1 / ($averageInterval + 1);
    }

    private function checkBrowserIdentity($request)
    {
        $userAgent = $request->header('User-Agent');
        $expectedProperties = $this->getExpectedBrowserProperties($userAgent);

        if ($expectedProperties) {
            return $request->server('HTTP_ACCEPT_LANGUAGE') !== $expectedProperties['accept_language'] ||
                $request->server('HTTP_ACCEPT_ENCODING') !== $expectedProperties['accept_encoding'];
        }

        return false;
    }

    private function getExpectedBrowserProperties($userAgent)
    {
        if (stripos($userAgent, 'Chrome') !== false && stripos($userAgent, 'Edge') === false) {
            return [
                'accept_language' => 'en-US,en;q=0.9',
                'accept_encoding' => 'gzip, deflate, br',
            ];
        } elseif (stripos($userAgent, 'Firefox') !== false) {
            return [
                'accept_language' => 'en-US,en;q=0.5',
                'accept_encoding' => 'gzip, deflate, br',
            ];
        } elseif (stripos($userAgent, 'Safari') !== false && stripos($userAgent, 'Chrome') === false) {
            return [
                'accept_language' => 'en-us',
                'accept_encoding' => 'gzip, deflate',
            ];
        } elseif (stripos($userAgent, 'Edge') !== false) {
            return [
                'accept_language' => 'en-US',
                'accept_encoding' => 'gzip, deflate, br',
            ];
        } elseif (stripos($userAgent, 'Opera') !== false) {
            return [
                'accept_language' => 'en-US,en;q=0.9',
                'accept_encoding' => 'gzip, deflate',
            ];
        } elseif (stripos($userAgent, 'MSIE') !== false || stripos($userAgent, 'Trident') !== false) {
            return [
                'accept_language' => 'en-US',
                'accept_encoding' => 'gzip, deflate',
            ];
        }

        return null;
    }

    private function getSessionLength($request)
    {
        // Get the session creation time
        $sessionStart = $request->session()->get('session_start', now()->timestamp);
        $request->session()->put('session_start', $sessionStart);

        $sessionLength = now()->timestamp - $sessionStart;
        return $sessionLength;
    }

    private function checkIpReputation($ip)
    {
        // Use an external IP reputation service
        // For example, using ip-api.com (Note: make sure to comply with their terms of service)
        $cacheKey = 'ip_reputation_' . $ip;
        $reputation = Cache::get($cacheKey);

        if ($reputation === null) {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                $reputation = ($data['status'] === 'fail') ? 'bad' : 'good';
                Cache::put($cacheKey, $reputation, now()->addHours(1));
            } else {
                // If unable to get reputation, assume good
                $reputation = 'good';
            }
        }

        return $reputation === 'bad';
    }

    private function checkHoneypot($request)
    {
        // Check for honeypot fields
        $honeypotField = $request->input('hp_field');
        if (!empty($honeypotField)) {
            return true;
        }
        return false;
    }

    private function predictUsingClassifiers($features)
    {
        $knnPrediction = $this->knnClassifier->predict($features);
        $svcPrediction = $this->svcClassifier->predict($features);
        return $knnPrediction === 'bot' || $svcPrediction === 'bot';
    }
}
