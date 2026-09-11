<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DailyVisitor extends Model
{
    protected $guarded = ['id'];

    public static function record(Request $request): void
    {
        if (! $request->isMethod('GET') || $request->user()?->is_admin || preg_match('/bot|crawler|spider|headless|preview/i', $request->userAgent() ?? '')) {
            return;
        }
        $day = now('Asia/Jakarta')->toDateString();
        $hash = hash_hmac('sha256', $day.'|'.$request->ip().'|'.$request->userAgent(), config('app.key'));
        $ua = $request->userAgent() ?? '';
        $device = preg_match('/ipad|tablet/i', $ua) ? 'Tablet' : (preg_match('/mobile|android|iphone/i', $ua) ? 'HP' : 'Desktop');
        $referrer = parse_url($request->header('referer', ''), PHP_URL_HOST);
        $source = $request->query('utm_source');
        $source = is_string($source) && $source !== '' ? $source : ($referrer && $referrer !== $request->getHost() ? $referrer : 'Langsung');
        $source = mb_substr($source, 0, 120);
        static::insertOrIgnore(['day' => $day, 'visitor_hash' => $hash, 'views' => 0, 'device' => $device, 'source' => $source, 'created_at' => now(), 'updated_at' => now()]);
        static::where('day', $day)->where('visitor_hash', $hash)->increment('views');
    }
}
