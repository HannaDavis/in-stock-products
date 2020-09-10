<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithoutProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_tracks_product_stock()
    {
        $this->seed(RetailerWithoutProductSeeder::class);
        $this->assertFalse(Product::first()->inStock());

        Http::fake(
            function () {
                return [
                    'available' => true,
                    'price' => 29900
                ];
            }
        );

        $this->artisan('track');
        $this->assertTrue(Product::first()->inStock());
    }
}
