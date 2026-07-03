<?php
namespace App\Modules\Address\UseCases;

use Illuminate\Support\Facades\Http;

final class AddressOfCepUseCase
{
    private $viacep = "https://viacep.com.br/ws";
    public function execute(string $cep)
    {
        try{
            $cep = preg_replace("/\D/", "", $cep);
            $response = Http::timeout(10)->get("{$this->viacep}/{$cep}/json");
            return $response->json();
        }catch(\Exception $e) {}
    }
}