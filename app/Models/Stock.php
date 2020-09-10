<?php

namespace App\Models;

use App\Clients\ClientFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 */
class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'in_stock' => 'boolean'
    ];


    public function track()
    {
        //hit an API end point
        $status = $this->retailer->client()->checkAvailability($this);
        $this->update(
            [
                'in_stock' => $status->available,
                'price' => $status->price
            ]
        );
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
