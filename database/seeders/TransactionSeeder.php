<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $categories = Category::all()->toArray();
        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->category_id = $categories[array_rand($categories)]['id'];
                $transaction->transaction_type = 'income';
                $transaction->transaction_date = date('Y-m-d');
                $transaction->note = '';
                $transaction->quote = rand(100, 1000);
                $transaction->save();
            }
            for ($i = 0; $i < 10; $i++) {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->category_id = $categories[array_rand($categories)]['id'];
                $transaction->transaction_type = 'expenditure';
                $transaction->transaction_date = date('Y-m-d');
                $transaction->note = '';

                $transaction->quote = rand(100, 1000);
                $transaction->save();
            }
        }
    }
}
