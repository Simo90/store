<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    return [

        'title' => $faker->sentence( 3 ),
        'description' => $faker->text( 600 ),
        
        // if you want to create new user
        // 'user_id' => function () {
        //     return factory(App\User::class)->create()->id;
        // }, 

        'user_id' => function () {
            return App\User::all()->random()->id;
        }, 


        // 'image' => function () {
        //     return Product::all()->random()->image;
        // },
        'image' => 'image/'.$faker->image('storage/app/public/image',480,640, null, false),
    ];
});


