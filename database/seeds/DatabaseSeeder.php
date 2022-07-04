<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namespace = getAppName();

        $seeders = [
            'CurrencyTableSeeder'               => true,
            'EntitiesTableSeeder'               => true,
            'StagesTableSeeder'                 => true,
            'PppDeliveryModelsTableSeeder'      => true,
            'LocationsTableSeeder'              => true,
            'PrefixesTableSeeder'               => false,
            'RolesTableSeeder'                  => false,
            'UsersTableSeeder'                  => false,
            'MilestonesTableSeeder'             => false,
            'LangTableSeeder'                   => false,
            'ThemeTableSeeder'                  => false,
            'NavMenuLinksTableSeeder'           => false,
            'ConfigTableSeeder'                 => true,
            'MediaTableSeeder'                  => true,
            'SectorTableSeeder'                 => false,
            'ProjectsTableSeeder'               => true,
            'ProjectInformationTableSeeder'     => true,
            'ProjectLocationsTableSeeder'       => true,
            'ProjectSectorsTableSeeder'         => true,
            'ProjectsEntitiesTableSeeder'       => true,
            'ProjectRisksAllocationsTableSeeder'=> true,
            'ProjectDetailsTableSeeder'         => true,
            'ContractMilestonesTableSeeder'     => true,
            'PerformanceInformationTableSeeder' => true,
            'SectionsTableSeeder'               => true,
            'SlidersTableSeeder'                => true,
            'BannersTableSeeder'                => true,
            'GraphTableSeeder'                  => false,
            'TasksTableSeeder'                  => false,
            'PermissionsTableSeeder'            => false,
            'AddAwardSection'            => false,
        ];

        foreach ($seeders as $seeder => $isCountrySpecific) {
            if ($isCountrySpecific) {
                $class = $namespace.'\\'.$seeder;
                $this->call($class);
            } else {
                $this->call($seeder);
            }
        }
    }
}
