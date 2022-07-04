<?php

namespace NigeriaNSIA;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformanceInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Types inserts*/

        /**
         * Annual demand types
         */

        DB::table('pi_annual_demand_level_type')->insert([
            'id' => 1,
            'type' => 'Electricity',
            'unit' => 'kWh',
        ]);
        DB::table('pi_annual_demand_level_type')->insert([
            'id' => 2,
            'type' => 'Water',
            'unit' => 'm³',
        ]);

        /**
         * Income statement metric
         */

        DB::table('pi_income_statements_metrics_types')->insert([
            'id' => 1,
            'currency_id' => 2,
            'name' => 'Revenue',
        ]);
        DB::table('pi_income_statements_metrics_types')->insert([
            'id' => 2,
            'currency_id' => 2,
            'name' => 'EBITDA',
        ]);

        /**
         * Other financial metrics types
        */

       /**
        * Timeless
        */

        DB::table('pi_other_financial_metrics_timeless_types')->insert([
            'id' => 1,
            'name' => 'Equity IRR',
        ]);
        DB::table('pi_other_financial_metrics_timeless_types')->insert([
            'id' => 2,
            'name' => 'Project IRR',
        ]);
        DB::table('pi_other_financial_metrics_timeless_types')->insert([
            'id' => 3,
            'name' => 'Net present value-NPV',
        ]);
        DB::table('pi_other_financial_metrics_timeless_types')->insert([
            'id' => 4,
            'name' => 'Rate of return',
        ]);

        /**
         * Annual
         */

        DB::table('pi_other_financial_metrics_annual_types')->insert([
            'id' => 1,
            'type_annual' => 'Return on sales',
            'unit' => '%'
        ]);
        DB::table('pi_other_financial_metrics_annual_types')->insert([
            'id' => 2,
            'type_annual' => 'Return on equity',
            'unit' => '%'
        ]);
        DB::table('pi_other_financial_metrics_annual_types')->insert([
            'id' => 3,
            'type_annual' => 'Return on active',
            'unit' => '%'
        ]);

        /*
         * KPI
         */

        DB::table('pi_key_performance_indicators_kpi_types')->insert([
            'id' => 1,
            'name' => 'Water loses',
            'unit' => 'm³'
        ]);
        DB::table('pi_key_performance_indicators_kpi_types')->insert([
            'id' => 2,
            'name' => 'Energy loses',
            'unit' => 'm³'
        ]);

        /**
         *Performance failures
         */

        DB::table('pi_performance_failures_category')->insert([
            'id' => 1,
            'name' => 'Transparency in accounting and in operations',
        ]);
        DB::table('pi_performance_failures_category')->insert([
            'id' => 2,
            'name' => 'Financial objectives',
        ]);


         /**
          * End types
          */

        /* General performance information inserts */

        DB::table('performance_information')->insert([
            'id' => 1,
            'project_id' => 1
        ]);
        DB::table('performance_information')->insert([
            'id' => 2,
            'project_id' => 2
        ]);
        DB::table('performance_information')->insert([
            'id' => 3,
            'project_id' => 3
        ]);
        DB::table('performance_information')->insert([
            'id' => 4,
            'project_id' => 4
        ]);
        DB::table('performance_information')->insert([
            'id' => 5,
            'project_id' => 5
        ]);
        DB::table('performance_information')->insert([
            'id' => 6,
            'project_id' => 6
        ]);
        DB::table('performance_information')->insert([
            'id' => 7,
            'project_id' => 7
        ]);
        DB::table('performance_information')->insert([
            'id' => 8,
            'project_id' => 8
        ]);
        DB::table('performance_information')->insert([
            'id' => 9,
            'project_id' => 9
        ]);
        DB::table('performance_information')->insert([
            'id' => 10,
            'project_id' => 10
        ]);
        DB::table('performance_information')->insert([
            'id' => 11,
            'project_id' => 11
        ]);
        DB::table('performance_information')->insert([
            'id' => 12,
            'project_id' => 12
        ]);
        DB::table('performance_information')->insert([
            'id' => 13,
            'project_id' => 13
        ]);
        DB::table('performance_information')->insert([
            'id' => 14,
            'project_id' => 14
        ]);
        DB::table('performance_information')->insert([
            'id' => 15,
            'project_id' => 15
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 1,
            'performance_information_id' => 1
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 1,
            'performance_information_id' => 1
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 1,
            'performance_information_id' => 1
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 2,
            'performance_information_id' => 2
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 2,
            'performance_information_id' => 2
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 2,
            'performance_information_id' => 2
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 3,
            'performance_information_id' => 3
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 3,
            'performance_information_id' => 3
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 3,
            'performance_information_id' => 3
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 4,
            'performance_information_id' => 4
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 4,
            'performance_information_id' => 4
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 4,
            'performance_information_id' => 4
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 5,
            'performance_information_id' => 5
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 5,
            'performance_information_id' => 5
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 5,
            'performance_information_id' => 5
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' =>  6,
            'performance_information_id' => 6
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' =>  6,
            'performance_information_id' => 6
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' =>  6,
            'performance_information_id' => 6
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' =>  7,
            'performance_information_id' => 7
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' =>  7,
            'performance_information_id' => 7
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' =>  7,
            'performance_information_id' => 7
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' =>  8,
            'performance_information_id' => 8
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' =>  8,
            'performance_information_id' => 8
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' =>  8,
            'performance_information_id' => 8
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' =>  9,
            'performance_information_id' => 9
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' =>  9,
            'performance_information_id' => 9
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' =>  9,
            'performance_information_id' => 9
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 10,
            'performance_information_id' => 10
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 10,
            'performance_information_id' => 10
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 10,
            'performance_information_id' => 10
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 11,
            'performance_information_id' => 11
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 11,
            'performance_information_id' => 11
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 11,
            'performance_information_id' => 11
        ]);

        DB::table('pi_annual_demand_levels_main')->insert([
            'id' => 15,
            'performance_information_id' => 15
        ]);
        DB::table('pi_income_statements_main')->insert([
            'id' => 15,
            'performance_information_id' => 15
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 15,
            'performance_information_id' => 15
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 13,
            'performance_information_id' => 13
        ]);
        DB::table('pi_key_performance_main')->insert([
            'id' => 14,
            'performance_information_id' => 14
        ]);

        /*Annual demands*/

        DB::table('pi_annual_demand_levels')->insert([
            'pi_annual_demand_levels_main_id' => 1,
            'type_id' => 1,
            'year' => 2015,
            'value' => '1',
        ]);
        DB::table('pi_annual_demand_levels')->insert([
            'pi_annual_demand_levels_main_id' => 1,
            'type_id' => 2,
            'year' => 2015,
            'value' => '1',
        ]);
        DB::table('pi_annual_demand_levels')->insert([
            'pi_annual_demand_levels_main_id' => 1,
            'type_id' => 1,
            'year' => 2016,
            'value' => '2',
        ]);
        DB::table('pi_annual_demand_levels')->insert([
            'pi_annual_demand_levels_main_id' => 1,
            'type_id' => 1,
            'year' => 2018,
            'value' => '2',
        ]);
        DB::table('pi_annual_demand_levels')->insert([
            'pi_annual_demand_levels_main_id' => 1,
            'type_id' => 1,
            'year' => 2014,
            'value' => '1',
        ]);
        DB::table('pi_annual_demand_levels')->insert([
            'pi_annual_demand_levels_main_id' => 1,
            'type_id' => 2,
            'year' => 2020,
            'value' => '1',
        ]);
        DB::table('pi_annual_demand_levels')->insert([
            'pi_annual_demand_levels_main_id' => 1,
            'type_id' => 1,
            'year' => 2022,
            'value' => '1',
        ]);

        /**
         * Income statement metric
         */

        DB::table('pi_income_statements_metrics')->insert([
            'pi_income_statement_main_id' => 1,
            'type_id' => 1,
            'year' => 2015,
            'value' => '1',
        ]);
        DB::table('pi_income_statements_metrics')->insert([
            'pi_income_statement_main_id' => 1,
            'type_id' => 1,
            'year' => 2016,
            'value' => '1',
        ]);
        DB::table('pi_income_statements_metrics')->insert([
            'pi_income_statement_main_id' => 1,
            'type_id' => 1,
            'year' => 2017,
            'value' => '1',
        ]);
        DB::table('pi_income_statements_metrics')->insert([
            'pi_income_statement_main_id' => 1,
            'type_id' => 1,
            'year' => 2018,
            'value' => '1',
        ]);
        DB::table('pi_income_statements_metrics')->insert([
            'pi_income_statement_main_id' => 1,
            'type_id' => 2,
            'year' => 2015,
            'value' => '1',
        ]);
        DB::table('pi_income_statements_metrics')->insert([
            'pi_income_statement_main_id' => 1,
            'type_id' => 2,
            'year' => 2016,
            'value' => '1',
        ]);
        DB::table('pi_income_statements_metrics')->insert([
            'pi_income_statement_main_id' => 1,
            'type_id' => 2,
            'year' => 2017,
            'value' => '1',
        ]);

        /**
         * Other financial metric
         */

        /**
         * Timeless
         */

        DB::table('pi_other_financial_metrics_timeless_main')->insert([
            'perf_inf_id' => 1,
        ]);

        DB::table('pi_other_financial_metrics_timeless')->insert([
            'pi_other_main_id' => 1,
            'type_id' => 1,
            'value' => '1',
        ]);
        DB::table('pi_other_financial_metrics_timeless')->insert([
            'pi_other_main_id' => 1,
            'type_id' => 2,
            'value' => '1',
        ]);
        DB::table('pi_other_financial_metrics_timeless')->insert([
            'pi_other_main_id' => 1,
            'type_id' => 3,
            'value' => '1',
        ]);
        DB::table('pi_other_financial_metrics_timeless')->insert([
            'pi_other_main_id' => 1,
            'type_id' => 4,
            'value' => '1',
        ]);

        /**
         * Annual financial
         */

        DB::table('pi_other_financial_metrics_annual_main')->insert([
            'perf_inf_id' => 1,
        ]);
        DB::table('pi_other_financial_metrics_annual')->insert([
            'year' => 2016,
            'value' => '1',
            'type_id' => 1,
            'pi_other_main_id' => 1,
        ]);
        DB::table('pi_other_financial_metrics_annual')->insert([
            'year' => 2017,
            'value' => '1',
            'type_id' => 1,
            'pi_other_main_id' => 1,
        ]);
        DB::table('pi_other_financial_metrics_annual')->insert([
            'year' => 2018,
            'value' => '1',
            'type_id' => 1,
            'pi_other_main_id' => 1,
        ]);
        DB::table('pi_other_financial_metrics_annual')->insert([
            'year' => 2019,
            'value' => '1',
            'type_id' => 1,
            'pi_other_main_id' => 1,
        ]);


        DB::table('pi_other_financial_metrics_annual')->insert([
            'year' => 2016,
            'value' => '1',
            'type_id' => 2,
            'pi_other_main_id' => 1,
        ]);
        DB::table('pi_other_financial_metrics_annual')->insert([
            'year' => 2016,
            'value' => '1',
            'type_id' => 2,
            'pi_other_main_id' => 1,
        ]);
        DB::table('pi_other_financial_metrics_annual')->insert([
            'year' => 2016,
            'value' => '1',
            'type_id' => 2,
            'pi_other_main_id' => 1,
        ]);

        /**
         * Key performance indicators
         */
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2019,
            'target' => '1'
        ]);

        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 1,
            'year' => 2019,
            'target' => '1'
        ]);

        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2019,
            'target' => '1'
        ]);

        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 15,
            'year' => 2019,
            'target' => '1'
        ]);

        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2019,
            'target' => '1'
        ]);

        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 14,
            'year' => 2019,
            'target' => '1'
        ]);

        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 1,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2019,
            'target' => '1'
        ]);

        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2016,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2017,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2018,
            'target' => '1'
        ]);
        DB::table('pi_key_performance_indicators')->insert([
            'type_id' => 2,
            'achievement' => '1',
            'pi_key_performance_main_id' => 13,
            'year' => 2019,
            'target' => '1'
        ]);



        /*Performance failures*/
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 1,
            'title' => 'Performance failure 1',
            'category_failure_id' => 2,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 1,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 1,
            'title' => 'Performance failure 2',
            'category_failure_id' => 1,
            'number_events' => '2',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 2,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 1,
            'title' => 'Performance failure 3',
            'category_failure_id' => 1,
            'number_events' => '3',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 3,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 1,
            'title' => 'Performance failure 4',
            'category_failure_id' => 1,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 4,
        ]);

        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 15,
            'title' => 'Performance failure 1',
            'category_failure_id' => 2,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 5,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 15,
            'title' => 'Performance failure 2',
            'category_failure_id' => 1,
            'number_events' => '2',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 6,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 15,
            'title' => 'Performance failure 3',
            'category_failure_id' => 1,
            'number_events' => '3',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 7,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 15,
            'title' => 'Performance failure 4',
            'category_failure_id' => 1,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 8,
        ]);

        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 14,
            'title' => 'Performance failure 1',
            'category_failure_id' => 2,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 9,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 14,
            'title' => 'Performance failure 2',
            'category_failure_id' => 1,
            'number_events' => '2',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 10,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 14,
            'title' => 'Performance failure 3',
            'category_failure_id' => 1,
            'number_events' => '3',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 11,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 14,
            'title' => 'Performance failure 4',
            'category_failure_id' => 1,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 12,
        ]);

        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 13,
            'title' => 'Performance failure 1',
            'category_failure_id' => 2,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 13,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 13,
            'title' => 'Performance failure 2',
            'category_failure_id' => 1,
            'number_events' => '2',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 14,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 13,
            'title' => 'Performance failure 3',
            'category_failure_id' => 1,
            'number_events' => '3',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 1,
            'position' => 15,
        ]);
        DB::table('pi_performance_failures')->insert([
            'performance_information_id' => 13,
            'title' => 'Performance failure 4',
            'category_failure_id' => 1,
            'number_events' => '1',
            'penalty_contract' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_imposed' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'penalty_paid' => 0,
            'position' => 16,
        ]);

        /*Performance assessments*/

        for ($i=1; $i < 16; $i++) {

            DB::table('pi_performance_assessment')->insert([
                'name' => 'Audit reports',
                'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
                'performance_information_id' => $i,
                'position' => 1,
            ]);
            DB::table('pi_performance_assessment')->insert([
                'name' => 'Audited Financial Statements',
                'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
                'performance_information_id' => $i,
                'position' => 2,
            ]);
            DB::table('pi_performance_assessment')->insert([
                'name' => 'Private party reports',
                'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
                'performance_information_id' => $i,
                'position' => 3,
            ]);
            DB::table('pi_performance_assessment')->insert([
                'name' => 'Independent Expert reports',
                'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
                'performance_information_id' => $i,
                'position' => 4,
            ]);

        }








    }
}
