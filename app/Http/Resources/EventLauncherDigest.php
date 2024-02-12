<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;

class EventLauncherDigest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $start_registry = Controller::MiladyToShamsi3($this->start_registry);
        $end_registry = Controller::MiladyToShamsi3($this->end_registry);
        $start = null;
        $end = null;

        $stepsStatus = null;
        $runStatus = null;
        $buyersCount = 0;
        $totalPaid = 0;

        if($this->status === Event::$INIT_STATUS) {

            $stepsStatus = [
                "first" => "done",
                "second" => "done",
                "third" => "done",
                "forth" => "done"
            ];

            if($this->sessions()->count() == 0)
                $stepsStatus['second'] = 'undone';

            if($this->price == null)
                $stepsStatus['third'] = 'undone';

            if($this->img == null || $this->description == null)
                $stepsStatus['forth'] = 'undone';

        }
        
        if($this->status === Event::$CONFIRMED_STATUS) {
            
            $now = time();

            if($this->start_registry <= $now && $this->end_registry >= $now)
                $runStatus = 'registry';
            else {
                
                $endSession = $this->sessions()->orderBy('end', 'desc')->first();
                $startSession = $this->sessions()->orderBy('end', 'asc')->first();

                $buyers = $this->buyers()->get();
                $buyersCount = count($buyers);

                foreach($buyers as $buyer)
                    $totalPaid += $buyer->paid;
                
                if($endSession != null && $endSession->end <= $now)
                    $runStatus = 'finish';
                else
                    $runStatus = 'run';

                if($endSession == null)
                    $end = '';
                else
                    $end = Controller::MiladyToShamsi2($endSession->end);
                    

                if($startSession == null)
                    $start = '';
                else
                    $start = Controller::MiladyToShamsi2($startSession->start);
            }
        }

        return [
            'id' => $this->id,
            'created_at' => Controller::MiladyToShamsi3($this->created_at->timestamp),
            'updated_at' => Controller::MiladyToShamsi3($this->updated_at->timestamp),
            'seen' => $this->seen,
            'buyers' => $this->buyers()->count(),
            'comment_count' => $this->comment_count,
            'new_comment_count' => $this->new_comment_count,
            'rate' => $this->rate,
            'rate_count' => $this->rate_count,
            'status' => $this->status,
            'start_registry' => $start_registry,
            'end_registry' => $end_registry,
            'start' => $start,
            'end' => $end,
            'slug' => $this->slug,
            'visibility' => $this->visibility,
            'title' => $this->title,
            'stepsStatus' => $stepsStatus,
            'runStatus' => $runStatus,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'totalPaid' => $totalPaid,
            'buyersCount' => $buyersCount
        ];
    }
}
