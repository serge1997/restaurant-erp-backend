<?php
namespace App\Modules\Supplier\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\Supplier;

class SupplierRepostory extends BaseRepository
{
    public function __construct(
        private readonly Supplier $supplier
    )
    {
        return parent::__construct();
    }
    public function eloquent(): Supplier
    {
       return app(Supplier::class);
    }
}