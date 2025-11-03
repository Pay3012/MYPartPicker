<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScrapeShopeeJob implements ShouldQueue
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
        $url = "https://shopee.com.my/api/v4/search/search_items?by=relevancy&keyword={$query}&limit=10&newest=0&order=desc&page_type=search";

        Log::info("Scraping Shopee API for {$this->componentName}...");

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Accept' => 'application/json',
            'Referer' => "https://shopee.com.my/search?keyword={$query}",
            'X-Requested-With' => 'XMLHttpRequest',
            'If-None-Match-' => '*',
            'Accept-Language' => 'en-MY,en;q=0.9',
        ])->withoutVerifying()->get($url);

        if (!$response->ok()) {
            Log::error("Failed to fetch Shopee API for {$this->componentName}. HTTP " . $response->status());
            return;
        }

        $data = $response->json();
        $items = $data['items'] ?? [];

        if (empty($items)) {
            Log::warning("⚠️ No items found for {$this->componentName}");
            return;
        }

        $prices = [];
        foreach ($items as $item) {
            $rawPrice = $item['item_basic']['price'] ?? null;
            if ($rawPrice) {
                // Shopee prices are in cents * 100000
                $prices[] = $rawPrice / 100000;
            }
        }

        if (count($prices) > 0) {
            $lowest = min($prices);
            Log::info("✅ Lowest Shopee price for {$this->componentName}: RM" . number_format($lowest, 2));
        } else {
            Log::warning("⚠️ No valid prices found for {$this->componentName}");
        }
    }
}
