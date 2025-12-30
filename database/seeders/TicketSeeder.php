<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            Ticket::factory(3)->create([
                'customer_id' => $customer->id,
            ]);
        }
    }
}
