<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScrapeLazadaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $componentName;

    public function __construct($componentName)
    {
        $this->componentName = $componentName;
    }

    public function handle()
    {
        $query = urlencode($this->componentName);
        $url = "https://www.lazada.com.my/shop-cpu/?q={$query}";

        Log::info("🔍 Scraping Lazada JSON API for {$this->componentName}...");

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Accept' => 'application/json, text/plain, */*',
            'X-Requested-With' => 'XMLHttpRequest',
            'Referer' => "https://www.lazada.com.my/catalog/?q={$query}",
            'Accept-Language' => 'en-MY,en;q=0.9',
        ])->withoutVerifying()->get($url);

        if (!$response->ok()) {
            Log::error("❌ Failed to fetch Lazada API for {$this->componentName}. HTTP " . $response->status());
            return;
        }

        $data = $response->json();

        // Lazada sometimes returns nested JSON as a string
        if (isset($data['mods']['listItems']) && is_array($data['mods']['listItems'])) {
            $items = $data['mods']['listItems'];
        } elseif (isset($data['mainInfo']) && is_string($data['mainInfo'])) {
            $decoded = json_decode($data['mainInfo'], true);
            $items = $decoded['mods']['listItems'] ?? [];
        } else {
            Log::warning("⚠️ No items found in Lazada response for {$this->componentName}");
            return;
        }

        if (empty($items)) {
            Log::warning("⚠️ No products found for {$this->componentName}");
            return;
        }

        $prices = [];
        foreach ($items as $item) {
            if (!empty($item['priceShow'])) {
                $clean = preg_replace('/[^\d.]/', '', $item['priceShow']);
                if (is_numeric($clean)) {
                    $prices[] = (float) $clean;
                }
            }
        }

        if (count($prices) > 0) {
            $lowest = min($prices);
            Log::info("✅ Lowest Lazada price for {$this->componentName}: RM" . number_format($lowest, 2));
        } else {
            Log::warning("⚠️ No prices extracted for {$this->componentName}");
        }
    }
}
