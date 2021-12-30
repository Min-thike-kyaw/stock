<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stock_unit')->insert([
            [
                "stock_id" => 1,
                "unit_id" => 1
            ],
            [
                "stock_id" => 1,
                "unit_id" => 2
            ],
            [
                "stock_id" => 1,
                "unit_id" => 3
            ],
            [
                "stock_id" => 2,
                "unit_id" => 3
            ],
            [
                "stock_id" => 3,
                "unit_id" => 4
            ],

        ]);
    }
}
