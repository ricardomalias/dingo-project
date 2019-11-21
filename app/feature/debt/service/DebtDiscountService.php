<?php


namespace App\feature\debt\service;


use App\feature\debt\repository\DebtDiscountRepository;

class DebtDiscountService
{
    private $debtDiscountRepository;

    public $debt_id;

    public function __construct() {
        $this->debtDiscountRepository = new DebtDiscountRepository();
    }

    public function getDebtDiscount() {
        $debt_discount_repository = $this->debtDiscountRepository;

        return $debt_discount_repository->first([
            "debt_id" => $this->debt_id
        ]);
    }
    public function saveDebtDiscount(array $discount) {
        $debt_discount_repository = $this->debtDiscountRepository;

        $discount['debt_id'] = $this->debt_id;

        return $debt_discount_repository->save($discount);
    }

//    public function editDebtDiscount(array $discount)
//    {
//        $debt_discount_repository = $this->debtDiscountRepository;
//
//        return $debt_discount_repository->update($discount, [
//            'debt_discount_id' => $discount['debt_discount_id']
//        ]);
//    }

    public function deleteDebtDiscount() {
        $debt_discount_repository = $this->debtDiscountRepository;

        return $debt_discount_repository->delete([
            'debt_id' => $this->debt_id
        ]);
    }
}