<?php


namespace App\feature\debt\service;


use App\feature\debt\repository\DebtRepository;

class DebtService
{
    private $debtRepository;
    private $debtSituationService;
    private $debtDiscountService;

    public $customer_id;
    public $debt_id;

    public function __construct() {
        $this->debtRepository = new DebtRepository();

        $this->debtSituationService = new DebtSituationService();
        $this->debtDiscountService = new DebtDiscountService();
    }

    public function getDebts() {
        $debt_repository = $this->debtRepository;

        return $debt_repository->getDebts([
            'customer_id' => $this->customer_id
        ]);
    }

    public function getDebt() {
        $debt_repository = $this->debtRepository;

        return $debt_repository->getDebt([
            'debt_id' => $this->debt_id
        ]);
    }

    public function saveDebt($data) {
        $debt_repository = $this->debtRepository;
        $debt_situation_service = $this->debtSituationService;
        $debt_discount_service = $this->debtDiscountService;

        $debt_id = $debt_repository->save($data);

        $debt_situation_service->debt_id = $debt_id;
        $debt_situation_service->saveDebtSituation();

        $debt_discount_service->debt_id = $debt_id;

        collect($data['discounts'])
            ->map(function ($discount) use ($debt_discount_service) {
                $debt_discount_service->saveDebtDiscount($discount);
            });

        return $debt_id;
    }

    public function editDebt($data) {
        $debt_repository = $this->debtRepository;
        $debt_situation_service = $this->debtSituationService;
        $debt_discount_service = $this->debtDiscountService;

        $debt_repository->update($data, [
            'debt_id' => $this->debt_id
        ]);

        $debt_situation_service->debt_id = $this->debt_id;
        $debt_situation_service->editDebtSituation($data['situation']);

        $debt_discount_service->debt_id = $this->debt_id;
        $debt_discount_service->deleteDebtDiscount();

        collect($data['discounts'])
            ->map(function ($discount) use ($debt_discount_service) {
                $debt_discount_service->saveDebtDiscount($discount);
            });

        return $this->getDebt();
    }

    public function deleteDebt() {
        $debt_repository = $this->debtRepository;
        $debt_situation_service = $this->debtSituationService;
        $debt_discount_service = $this->debtDiscountService;

        $debt_situation_service->debt_id = $this->debt_id;
        $debt_situation_service->deleteDebtSituation();

        $debt_discount_service->debt_id = $this->debt_id;
        $debt_discount_service->deleteDebtDiscount();

        return $debt_repository->delete([
            'debt_id' => $this->debt_id
        ]);
    }
}