<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Integration;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('transactions')->delete();
    }
}
