<?php


namespace App\feature\debt\service;


use App\feature\customer\service\CustomerService;
use App\feature\debt\repository\DebtRepository;
use App\Providers\Pagination;

class DebtService
{
    private $debtRepository;
    private $debtSituationService;
    private $debtDiscountService;

    private $customerService;

    public $customer_id;
    public $debt_id;

    public function __construct() {
        $this->debtRepository = new DebtRepository();

        $this->debtSituationService = new DebtSituationService();
        $this->debtDiscountService = new DebtDiscountService();
    }

    public function setCustomerService(CustomerService $customerService) {
        $this->customerService = $customerService;
    }

    private function getCustomerService() {
        return $this->customerService;
    }

    public function getCompanyDebts($company_id) {
        $debt_repository = $this->debtRepository;
        $customer_service = $this->getCustomerService();

        return $debt_repository->getCompanyDebts(['company_id' => $company_id]);

//        $customers = $customer_service->getCustomers();
//        $debts = collect($customers)
//            ->flatMap(function ($customer) use ($debt_repository) {
//                $debts = $debt_repository->getDebts([
//                    'customer_id' => $customer->customer_id
//                ]);
//
//                return collect($debts)
//                    ->map(function ($debt) use ($customer) {
//                        $debt['customer'] = $customer;
//                        return $debt;
//                    });
//            });
    }

    public function getCustomerDebts() {
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

        if(!empty($data['discounts'])) {
            collect($data['discounts'])
            ->map(function ($discount) use ($debt_discount_service) {
                $debt_discount_service->saveDebtDiscount($discount);
            });
        }

        return $debt_id;
    }

    public function editDebt($data) {
        $debt_repository = $this->debtRepository;
        $debt_situation_service = $this->debtSituationService;
        $debt_discount_service = $this->debtDiscountService;

        $debt_repository->update($data, [
            'debt_id' => $this->debt_id
        ]);

        if(!empty($data['situation'])) {
            $debt_situation_service->debt_id = $this->debt_id;
            $debt_situation_service->editDebtSituation($data['situation']);
        }

        if(!empty($data['discounts'])) {
            $debt_discount_service->debt_id = $this->debt_id;
            $debt_discount_service->deleteDebtDiscount();

            collect($data['discounts'])
                ->map(function ($discount) use ($debt_discount_service) {
                    $debt_discount_service->saveDebtDiscount($discount);
                });
        }

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