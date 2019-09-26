<?php


namespace App\feature\debt\service;


use App\feature\debt\repository\DebtRepository;

class DebtService
{
    private $debtRepository;

    public $debt_id;

    public function __construct() {

        $this->debtRepository = new DebtRepository();
    }

    public function getDebts() {
        $debt_repository = $this->debtRepository;

        return $debt_repository->get();
    }

    public function getDebt() {
        $debt_repository = $this->debtRepository;

        return $debt_repository->first([
            'debt_id' => $this->debt_id
        ]);
    }

    public function saveDebt($data) {
        $debt_repository = $this->debtRepository;

        return $debt_repository->save($data);
    }

    public function editDebt($data) {
        $debt_repository = $this->debtRepository;

        $debt_repository->update($data, [
            'debt_id' => $this->debt_id
        ]);

        return $this->getDebt();
    }

    public function deleteDebt(string $debt_id) {
        $debt_repository = $this->debtRepository;

        return $debt_repository->delete([
            'debt_id' => $debt_id
        ]);
    }
}