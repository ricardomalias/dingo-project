<?php

namespace App\feature\company\service;


use App\feature\company\repository\CompanyConfigurationRepository;

class CompanyConfigurationService
{

    public $company_id;

    private $companyConfigurationRepository;

    private $companyConfigurationTranslate;

    public function __construct() {
        $this->companyConfigurationRepository = new CompanyConfigurationRepository();
        $this->companyConfigurationTranslate = include 'CompanyConfigurationTranslation.php';
    }

    private function createDefault() {
        $company_configuration_repository = $this->companyConfigurationRepository;
        $translate = $this->companyConfigurationTranslate;

        $configurations = $company_configuration_repository->get();

        collect($translate)
            ->flatMap(function ($section) use ($configurations) {
                return collect($section)
                    ->filter(function ($item, $key) use ($configurations) {
                        return collect($configurations)
                                ->filter(function ($configuration) use ($key) {
                                    return $configuration['key'] == $key;
                                })
                                ->count() == 0;
                    });

            })
            ->map(function ($item, $key) use ($company_configuration_repository) {
                $configuration = [
                    'company_id' => $this->company_id,
                    'key' => $key,
                    'value' => $item['default']
                ];

                $company_configuration_repository->save($configuration);

                return $configuration;
            })
            ->toArray();
    }

    public function getCompanyConfigurations() {
        $company_configuration_repository = $this->companyConfigurationRepository;

        /**
         * create the default configurations so ever exist some configuration
         */
        $this->createDefault();

        return $company_configuration_repository->get();
    }

    public function editCompanyConfiguration($configurations) {
        $company_configuration_repository = $this->companyConfigurationRepository;

        collect($configurations)
            ->filter(function ($configuration) use ($company_configuration_repository) {
               $where = [
                   'company_id' => $this->company_id,
                   'key' => $configuration['key']
               ];

               return $company_configuration_repository->update([
                       'value' => $configuration['value']
                   ], $where);
            });

        return $this->getCompanyConfigurations();
    }
}