<?php
namespace App\Modules\PurchaseRequisition\UseCases;

use App\Models\PurchaseRequisition;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionRepository;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

final class PurchaseRequisitionDocumentPdfUseCase
{
    public function __construct(
        private readonly PurchaseRequisitionRepository $purchaseRequisitionRepository
    ){}

    public function execute(PurchaseRequisition $purchaseRequisition)
    {
        $purchaseRequisition->authorizeRestaurantOwnership();
        $purchaseRequisition->load(['items.product', 'createdBy', 'approvedBy']);
        return Pdf::view("pdf.purchaseRequisition.purchase-requisition", [
            'requisition'   => $purchaseRequisition,
            'restaurant'    => $purchaseRequisition->restaurant
        ])->withBrowsershot(function (Browsershot $browsershot){
            $browsershot->setChromePath("/usr/bin/chromium")
                ->noSandbox()
                ->addChromiumArguments([
                    'disable-dev-shm-usage',
                    'disable-gpu',
                    'no-zygote',
                ]);

        })
            ->name("requisicao-{$purchaseRequisition->code}.pdf")
                ->download();
    }
}