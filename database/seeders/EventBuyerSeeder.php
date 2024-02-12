<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventBuyer;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventBuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = Event::all();

        foreach($events as $event) {

            $price = random_int(4000000, 8000000);
            $rand = random_int(10, 50);

            for($i = 0; $i < $rand; $i++) {

                $rand2 = random_int(1, 100);
                $userId = User::inRandomOrder()->first()->id;

                if($rand2 < 30) {
                    
                    $off_amount = random_int(10000, 500000);

                    $t = Transaction::create([
                        'off_id' => 1,
                        'off_amount' => $off_amount,
                        'amount' => $price - $off_amount,
                        'transaction_code' => random_int(100000, 50000000),
                        'tracking_code' => random_int(11111, 55555),
                        'ref_id' => $event->id,
                        'user_id' => $userId,
                        'site' => 'event',
                        'status' => Transaction::$COMPLETED_STATUS
                    ]);
                }
                else {
                    $t = Transaction::create([
                        'amount' => $price,
                        'transaction_code' => random_int(100000, 50000000),
                        'tracking_code' => random_int(11111, 55555),
                        'ref_id' => $event->id,
                        'user_id' => $userId,
                        'site' => 'event',
                        'status' => Transaction::$COMPLETED_STATUS
                    ]);
                }

                $h = Carbon::now()->subDay(random_int(3, 10));

                EventBuyer::create(
                    EventBuyer::factory()->make([
                        'user_id' => $userId,
                        'event_id' => $event->id,
                        'transaction_id' => $t->id,
                        'created_at' => $h->toDateTimeString(),
                        'created_ts' => $h->timestamp,
                    ])->toArray()
                );
            }
        
        }

    }
}
