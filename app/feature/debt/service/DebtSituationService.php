<?php


namespace App\feature\debt\service;


use App\feature\debt\repository\DebtSituationRepository;

class DebtSituationService
{
    private $debtSituationRepository;
    
    public $debt_id;

    public function __construct() {

        $this->debtSituationRepository = new DebtSituationRepository();
    }

    public function getDebtSituation() {
        $debt_situation_repository = $this->debtSituationRepository;

        return $debt_situation_repository->first([
            "debt_id" => $this->debt_id
        ]);
    }
    public function saveDebtSituation() {
        $debt_situation_repository = $this->debtSituationRepository;

        $data = [
            'debt_id' => $this->debt_id,
            'situation' => 'PENDING'
        ];

        return $debt_situation_repository->save($data);
    }

    public function editDebtSituation(string $situation)
    {
        $debt_situation_repository = $this->debtSituationRepository;
        $this->deleteDebtSituation();

        $data = [
            'debt_id' => $this->debt_id,
            'situation' => $situation
        ];

        return $debt_situation_repository->save($data);
    }

    public function deleteDebtSituation() {
        $debt_situation_repository = $this->debtSituationRepository;

        return $debt_situation_repository->delete([
            'debt_id' => $this->debt_id
        ]);
    }
}