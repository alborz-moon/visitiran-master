<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\EventBuyer;
use App\Models\MoneyRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FinanceReportController extends Controller {

    public function generalStats(Request $request) {

        $user = $request->user();
        $launcher = $user->launcher;

        if($launcher == null)
            return Redirect::route('403');

        $events = $launcher->events()->confirmed()->get();

        $totalRegistry = 0;
        $totalPay = 0;
        $totalOffAmount = 0;

        $events_data = [];
        $stats = [];

        // for($i = 1; $i < 10; $i++) {
        //     array_push($stats, [
        //         'date' => (int)('1401010' . $i),
        //         'count' => 3
        //     ]);
        // }
        
        // for($i = 1; $i < 10; $i++) {
        //     array_push($stats, [
        //         'date' => (int)('1401020' . $i),
        //         'count' => 3
        //     ]);
        // }
        
        // for($i = 1; $i < 10; $i++) {
        //     array_push($stats, [
        //         'date' => (int)('1401030' . $i),
        //         'count' => 3
        //     ]);
        // }

        foreach($events as $event) {
            
            $buyers = EventBuyer::where('event_id', $event->id)->paid()->get();
            $tR = 0;
            $buyers_data = [];

            foreach($buyers as $buyer) {
                
                $tR += $buyer->count;
                $createdAt = Controller::MiladyToIntShamsi($buyer->created_at);

                array_push($buyers_data, [
                    'date' => Controller::MiladyToShamsi3($buyer->created_at->timestamp),
                    'title' => $event->title,
                    'buyer' => $buyer->first_name . ' ' . $buyer->last_name,
                    'amount' => number_format($buyer->unit_price, 0),
                    'count' => $buyer->count
                ]);

                $find = false;
                $j = 0;

                foreach($stats as $stat) {
                    if($stat['date'] == $createdAt) {
                        $stats[$j] = [
                            'date' => $createdAt,
                            'count' => $stat['count'] + $buyer->count
                        ];
                        $find = true;
                        break;
                    }
                    $j++;
                }

                if(!$find) {
                    array_push($stats, [
                        'date' => $createdAt,
                        'count' => $buyer->count
                    ]);
                }
            }

            $tP = Transaction::event()->complete()->where('ref_id', $event->id)->sum('amount');
            $tO = Transaction::event()->complete()->where('ref_id', $event->id)->sum('off_amount');

            array_push($events_data, [
                'title' => $event->title,
                'id' => $event->id,
                'total_registry' => $tR,
                'total_pay' => $tP,
                'total_off' => $tO,
                'buyers' => $buyers_data
            ]);

            $totalRegistry += $tR;
            $totalPay += $tP;
            $totalOffAmount += $tO;
        }

        $totalBack = MoneyRequest::where('user_id', $user->id)->paid()->sum('amount');

        usort($stats, function ($item1, $item2) {
            return $item1['date'] <=> $item2['date'];
        });

        if(count($stats) > 30) {
            $new_stats = [];
            $monthes = [];
            
            $all_monthes = array('فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند');

            foreach($stats as $stat) {

                $m = (int)(substr($stat['date'] . '', 4, 2));

                $idx = array_search($m,  $monthes);

                if($idx === false) {
                    array_push($monthes, $m);
                    array_push($new_stats, [
                        'date' => $all_monthes[$m],
                        'count' => $stat['count']
                    ]);
                }
                else {
                    // dd($new_stats[$idx]['date']);
                    $new_stats[$idx] = [
                        'date' => $new_stats[$idx]['date'],
                        'count' => $new_stats[$idx]['count'] + $stat['count']
                    ];
                }
            }

            $stats = $new_stats;
        }
    
        return response()->json([
            'status' => 'ok',
            'total_registry' => $totalRegistry,
            'total_pay'=> number_format($totalPay),
            'total_off' => number_format($totalOffAmount),
            'total_back' => number_format($totalBack),
            'can_back' => number_format(max(0, $totalPay - $totalBack)),
            'events' => $events_data,
            'stats' => $stats
        ]);
    }

    public function registry_report(Request $request) {

        $user = $request->user();
        $launcher = $user->launcher;

        if($launcher == null)
            return Redirect::route('403');

        $eventId = $request->query('eventId', null);
        $start = $request->query('start', null);
        $end = $request->query('end', null);

        if($eventId == null)
            $events = $launcher->events()->confirmed()->get();
        else
            $events = $launcher->events()->where('id', $eventId)->confirmed()->get();

        $events_data = [];
        $stats = [];

        if($start != null)
            $start = strtotime(Controller::ShamsiToMilady($start) . " 00:00");

        if($end != null)
            $end = strtotime(Controller::ShamsiToMilady($end) . " 23:59");

        foreach($events as $event) {
            
            if($start == null && $end == null)
                $buyers = EventBuyer::where('event_id', $event->id)->paid()->get();
            else {
                if($start != null && $end != null)
                    $buyers = EventBuyer::where('event_id', $event->id)->paid()
                        ->where('created_ts', '>=', $start)->where('created_ts', '<=', $end)->get();
                else if($start != null)
                    $buyers = EventBuyer::where('event_id', $event->id)->paid()->where('created_ts', '>=', $start)->get();
                else
                    $buyers = EventBuyer::where('event_id', $event->id)->paid()->where('created_ts', '<=', $end)->get();
            }

            $buyers_data = [];

            foreach($buyers as $buyer) {
                
                $createdAt = Controller::MiladyToIntShamsi($buyer->created_at);

                array_push($buyers_data, [
                    'date' => Controller::MiladyToShamsi3($buyer->created_at->timestamp),
                    'title' => $event->title,
                    'buyer' => $buyer->first_name . ' ' . $buyer->last_name,
                    'amount' => number_format($buyer->unit_price, 0),
                    'count' => $buyer->count
                ]);

                $find = false;
                $j = 0;

                foreach($stats as $stat) {
                    if($stat['date'] == $createdAt) {
                        $stats[$j] = [
                            'date' => $createdAt,
                            'count' => $stat['count'] + $buyer->count
                        ];
                        $find = true;
                        break;
                    }
                    $j++;
                }

                if(!$find) {
                    array_push($stats, [
                        'date' => $createdAt,
                        'count' => $buyer->count
                    ]);
                }
            }

            array_push($events_data, $buyers_data);
        }
        
        usort($stats, function ($item1, $item2) {
            return $item1['date'] <=> $item2['date'];
        });
    
        return response()->json([
            'status' => 'ok',
            'events' => $events_data,
            'stats' => $stats
        ]);

    }
    
}
