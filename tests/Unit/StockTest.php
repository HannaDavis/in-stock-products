<?php

namespace Tests\Unit;

use App\Clients\Client;
use App\Clients\ClientException;
use App\Clients\ClientFactory;
use App\Clients\StockStatus;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithoutProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_throws_an_exception_if_a_client_is_not_found_when_tracking()
    {
        $this->seed(RetailerWithoutProductSeeder::class);
        Retailer::first()->update(['name' => 'Foo Retailer']);
        $this->expectException(ClientException::class);
        Stock::first()->track();
    }
    
}
