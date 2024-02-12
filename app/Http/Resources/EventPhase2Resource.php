<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\Undefined;

class EventPhase2Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $sr = $this->start_registry == null ? '' : Controller::MiladyToShamsi3($this->start_registry);
        $er = $this->end_registry == null ? '' : Controller::MiladyToShamsi3($this->end_registry);

        
        if($this->start_registry != null) {
            $start_registry_date = date("Y/m/d H:i", $this->start_registry);
            $start_registry_date = Controller::MiladyToShamsi($start_registry_date, '/');
        }
        else {
            $start_registry_date = null;
        }

        if($this->end_registry != null) {
            $end_registry_date = date("Y/m/d H:i", $this->end_registry);
            $end_registry_date = Controller::MiladyToShamsi($end_registry_date, '/');
        }
        else {
            $end_registry_date = null;
        }


        $launcher = $this->launcher;

        $useFromLauncher = false;

        if($this->site == null && $this->email == null && $this->phone == null)
            $useFromLauncher = true;

        $site = $useFromLauncher ? $launcher->site : $this->site;
        $mail = $useFromLauncher ? $launcher->launcher_email : $this->email;
        $phone = $useFromLauncher ? $launcher->launcher_phone : $this->phone;

        if($useFromLauncher && $phone != null && !empty($phone) && $phone != '__')
            $phone = explode('__', $phone);
        else if(!$useFromLauncher)
            $phone = explode('_', $phone);

        return [
            'id' => $this->id,
            'start_registry' => $sr,
            'end_registry' => $er,
            'start_registry_date_formatted' => $sr == '' ? '' : explode('-', $sr)[0],
            'start_registry_time' => $sr == '' ? '' : explode('-', $sr)[1],
            'end_registry_date_formatted' => $er == '' ? '' : explode('-', $er)[0],
            'end_registry_time' => $er == '' ? '' : explode('-', $er)[1],
            
            'start_registry_date' => $start_registry_date == null ? '' : $start_registry_date,
            'end_registry_date' => $end_registry_date == null ? '' : $end_registry_date,

            'ticket_description' => $this->ticket_description,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'site' => $site,
            'email' => $mail,
            'phone' => $phone == null || empty($phone) ? null : $phone,
            'mode' => $this->status == 'init' ? 'create' : 'edit'
        ];
    }
}
