<?php
namespace App\Foundation\Base;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

use function Illuminate\Support\now;

class BaseModel extends Model
{
    use ModelTrait;
    
    public const GENERATE_CODE_TENTATIVE = 3;
    public const DB_DATE_FORMAT = 'Y-m-d';

    protected $casts = [
        "cost"  => "float",
        "price" => "float",
        "is_active" => "boolean"
    ];  

    public function nameInicial(): string
    {
        $name = explode(" ", $this->name);
        if (count($name) == 1) {
            $inicial = $name[0][0]. $name[0][1];
            return strtoupper($inicial);
        }
        $inicial = $name[0][0] . $name[1][0];
        return strtoupper($inicial);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function(BaseModel $model){
            /** @var User $auth */
            $auth = $model->auth();
            if ($model->hasRestaurantFilter()) {
                //set auth user restaurant id
                $model->restaurant_id = $auth->restaurant_id;
            }
            if ($model->hasCreatedBy()) {
                //set auth user id
                $model->created_by = $auth->id;
            }
        });
    }

    public function isActiveLabel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? "Ativo" : "Inativo"
        );
    }

    public function getCost(): string
    {
        return Number::currency($this->cost ?? 0, 'BRL', 'pt-BR');
    }

    public function getPrice(): string
    {
        return Number::currency($this->price ?? 0, 'BRL', 'pt-BR');
    }

    public function since($custom_column_date = 'created_at')
    {
        $date = Carbon::createFromFormat("Y-m-d H:i:s",$this->{$custom_column_date} ?? now());
        $periode_year = Carbon::now()->diffInYears($date);
        $periode = (int)abs(Carbon::now()->diffInDays($date));
        if ($periode == 0){
            $diff = (int)Carbon::now()->diffInHours($date);
            if ($diff == 0){
                return (int)abs(Carbon::now()->diffInMinutes($date)) . " min";
            }else{
                return "+{$diff} horas";
            }
        }else if($periode < 7 && $periode >= 1){
            $dayForHuman = dayForHuman($periode);
            $hour = $date->format("H:i");
            return "{$dayForHuman} às {$hour}";
       }else if($periode >= 7 && $periode < 31){
            return "+". (int)Carbon::now()->diffInWeeks($date) . " sem.";
       }else if($periode >= 31 && $periode_year == 0){
            return "+". (int)Carbon::now()->diffInMonths($date) . " mês";
       }else{
            if ($periode_year >= 1){
                return "+{$periode_year} ano";
            }
       }
    }
}