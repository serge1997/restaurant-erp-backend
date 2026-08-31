<?php
namespace App\Modules\Reservation\Infra\Filters;

use App\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

final class ReservationFilter
{
    public function __construct(
        private readonly ?PaginateRequest $request
    ){}

    public function apply(Builder $query)
    {
        $query->when($this->request->has('yesterday'), fn($q) => $q->whereDate('date', today()->subDay()->format('Y-m-d')))
            ->when($this->request->has('today'), fn($q) => $q->whereDate('date', today()->format('Y-m-d')))
                ->when($this->request->has('tomorrow'), fn($q) => $q->whereDate('date', today()->addDay()->format('Y-m-d')))
                    ->when($this->request->has('date_from') || $this->request->has('date_to'), function($q){
                        if($this->request->date_from && $this->request->date_to){
                            return $q->whereBetween('date', [$this->request->date_from, $this->request->date_to]);
                        }
                        if($this->request->date_from){
                            return $q->whereDate('date', '>=', $this->request->date_from);
                        }
                        if($this->request->date_to){
                            return $q->whereDate('date', '<=', $this->request->date_to);
                        }
                    });
    }
}
