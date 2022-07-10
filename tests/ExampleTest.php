<?php

use RyanChandler\Rql\Rql;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Model
{
    protected $guarded = [];

    public static function booted()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->timestamps();
        });

        foreach (range(1, 100) as $_) {
            Order::create([
                'price' => rand(0, 100) + (mt_rand() / mt_getrandmax()),
            ]);
        }
    }
}

it('can test', function () {
    $rql = new Rql;

    $results = $rql
        ->addBinding(Order::class)
        ->toArray(<<<'rql'
        using Order;

        select {
            id,
            price -> currency('£', 2),
        };
        rql);

    dd($results);
});
