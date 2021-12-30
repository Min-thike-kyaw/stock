<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            ["name" => "S1"],
            ["name" => "S2"],
            ["name" => "S3"],
            ["name" => "S4"]
        ]);

    }
}
