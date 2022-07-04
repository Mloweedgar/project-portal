<?php

namespace NigeriaICRC;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ProjectDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = Carbon::create(2017, 1, 31, 0);

        /*
         |--------------------------------------------------------------------------
         |  Project Details
         |--------------------------------------------------------------------------
         */

        DB::table('project_details')->insert([
            'id' => 1,
           'project_id' => 1
        ]);
        DB::table('project_details')->insert([
            'id' => 2,
            'project_id' => 2
        ]);
        DB::table('project_details')->insert([
            'id' => 3,
            'project_id' => 3
        ]);
        DB::table('project_details')->insert([
            'id' => 4,
            'project_id' => 4
        ]);
        DB::table('project_details')->insert([
            'id' => 5,
            'project_id' => 5
        ]);
        DB::table('project_details')->insert([
            'id' => 6,
            'project_id' => 6
        ]);
        DB::table('project_details')->insert([
            'id' => 7,
            'project_id' => 7
        ]);
        DB::table('project_details')->insert([
            'id' => 8,
            'project_id' => 8
        ]);
        DB::table('project_details')->insert([
            'id' => 9,
            'project_id' => 9
        ]);
        DB::table('project_details')->insert([
            'id' => 10,
            'project_id' => 10
        ]);
        DB::table('project_details')->insert([
            'id' => 11,
            'project_id' => 11
        ]);

        /**
         * Documents
         */
        DB::table('pd_document')->insert([
            'name' => 'Document 1',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 1
        ]);
        DB::table('pd_document')->insert([
            'name' => 'Document 2',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 2
        ]);
        DB::table('pd_document')->insert([
            'name' => 'Document 3',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 3
        ]);

        /**
         * Announcements
         */
        DB::table('pd_announcements')->insert([
            'name' => 'Announcement 1',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'published' => 1
        ]);
        DB::table('pd_announcements')->insert([
            'name' => 'Announcement 2',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'published' => 1
        ]);
        DB::table('pd_announcements')->insert([
            'name' => 'Announcement 3',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'published' => 1
        ]);
        DB::table('pd_announcements')->insert([
            'name' => 'Announcement 4',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'published' => 1
        ]);
        DB::table('pd_announcements')->insert([
            'name' => 'Announcement 5',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'published' => 0
        ]);
        DB::table('pd_announcements')->insert([
            'name' => 'Announcement 6',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'published' => 1
        ]);
        DB::table('pd_announcements')->insert([
            'name' => 'Announcement 7',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'published' => 1
        ]);

        /**
         * Procurement
         */

         for ($i=1; $i < 12; $i++) {

              DB::table('pd_procurement')->insert([
                  'name' => trans('procurement_documents.feasibility_study_report'),
                  'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                  'project_id' => $i,
                  'position' => 1,
              ]);

              DB::table('pd_procurement')->insert([
                  'name' => trans('procurement_documents.environment_and_social_impact_scoping'),
                  'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                  'project_id' => $i,
                  'position' => 2,
              ]);

             DB::table('pd_procurement')->insert([
                 'name' => trans('procurement_documents.OBC'),
                 'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                 'project_id' => $i,
                 'position' => 3,
             ]);

             DB::table('pd_procurement')->insert([
                 'name' => trans('procurement_documents.EOI'),
                 'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                 'project_id' => $i,
                 'position' => 4,
             ]);

             DB::table('pd_procurement')->insert([
                 'name' => trans('procurement_documents.request_qualification'),
                 'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                 'project_id' => $i,
                 'position' => 5,
             ]);

             DB::table('pd_procurement')->insert([
                 'name' => trans('procurement_documents.short_listed_bidders_evaluation'),
                 'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                 'project_id' => $i,
                 'position' => 6,
             ]);

             DB::table('pd_procurement')->insert([
                 'name' => trans('procurement_documents.request_proposal'),
                 'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                 'project_id' => $i,
                 'position' => 7,
             ]);

             DB::table('pd_procurement')->insert([
                 'name' => trans('procurement_documents.award_evaluation_summary'),
                 'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                 'project_id' => $i,
                 'position' => 8,
             ]);

             DB::table('pd_procurement')->insert([
                 'name' => trans('procurement_documents.value_money'),
                 'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
                 'project_id' => $i,
                 'position' => 9,
             ]);


         }

        /**
         * Risks
         */

        DB::table('pd_risks')->insert([
            'project_details_id' => 1,
            'risk_allocation_id' => 1,
            'name' => 'Pre-construction risk',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'mitigation' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'position' => 1,
        ]);
        DB::table('pd_risks')->insert([
            'project_details_id' => 1,
            'risk_allocation_id' => 2,
            'name' => 'Construction / Completion',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'mitigation' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'position' => 2,
        ]);
        DB::table('pd_risks')->insert([
            'project_details_id' => 1,
            'risk_allocation_id' => 2,
            'name' => 'Cost risk',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'mitigation' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'position' => 3,
        ]);
        DB::table('pd_risks')->insert([
            'project_details_id' => 1,
            'risk_allocation_id' => 2,
            'name' => 'Refinancing risk',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'mitigation' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'position' => 4,
        ]);
        DB::table('pd_risks')->insert([
            'project_details_id' => 1,
            'risk_allocation_id' => 2,
            'name' => 'Risk related to change in law, taxes, scope, technical standards, regulatory framework',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'mitigation' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'position' => 5,
        ]);
        DB::table('pd_risks')->insert([
            'project_details_id' => 1,
            'risk_allocation_id' => 1,
            'name' => 'Exchange rate risk',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'mitigation' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'position' => 6,
        ]);
        DB::table('pd_risks')->insert([
            'project_details_id' => 1,
            'risk_allocation_id' => 2,
            'name' => 'Operating risk',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'mitigation' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'position' => 7,
        ]);

        /**
         * Evaluation of PPP
         */


        DB::table('pd_evaluation')->insert([
            'name' => 'Evaluation report',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
        ]);
        DB::table('pd_evaluation')->insert([
            'name' => 'Reasons for doing the project as PPP',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
        ]);
        DB::table('pd_evaluation')->insert([
            'name' => 'Discount rates',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
        ]);
        DB::table('pd_evaluation')->insert([
            'name' => 'Risk comparison of other financian mechanisms',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
        ]);

        /**
         * Financial
         */

        DB::table('pd_financial')->insert([
            'name' => 'Equity-debt ratio',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
            'position' => 1,
        ]);
        DB::table('pd_financial')->insert([
            'name' => 'Share capital',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
            'position' => 2,
        ]);
        DB::table('pd_financial')->insert([
            'name' => 'Shareholders',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
            'position' => 3,
        ]);
        DB::table('pd_financial')->insert([
            'name' => 'Other information',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.',
            'project_details_id' => 1,
            'position' => 4,
        ]);

        /**
         * Government support
         */

        DB::table('pd_government_support')->insert([
            'name' => 'Guarantees',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 1,
        ]);
        DB::table('pd_government_support')->insert([
            'name' => 'Grants',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 2,
        ]);
        DB::table('pd_government_support')->insert([
            'name' => 'Service payments',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 3,
        ]);
        DB::table('pd_government_support')->insert([
            'name' => 'Land Leases, Asset Transfers',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 4,
        ]);
        DB::table('pd_government_support')->insert([
            'name' => 'Other support',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 5,
        ]);
        DB::table('pd_government_support')->insert([
            'name' => 'Revenue share',
            'description' => 'Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.',
            'project_details_id' => 1,
            'position' => 6,
        ]);
        /**
         * Tariffs
         */

        DB::table('pd_tariffs')->insert([
            'name' => 'Tariff 1',
            'description' => 'Tariff description',
            'project_details_id' => 1,
            'position' => 1,
        ]);
        DB::table('pd_tariffs')->insert([
            'name' => 'Tariff 2',
            'description' => 'Tariff description',
            'project_details_id' => 1,
            'position' => 2,
        ]);
        DB::table('pd_tariffs')->insert([
            'name' => 'Tariff 3',
            'description' => 'Tariff description',
            'project_details_id' => 1,
            'position' => 3,
        ]);
        DB::table('pd_tariffs')->insert([
            'name' => 'Tariff 4',
            'description' => 'Tariff description',
            'project_details_id' => 1,
            'position' => 4,
        ]);
        DB::table('pd_tariffs')->insert([
            'name' => 'Tariff 5',
            'description' => 'Tariff description',
            'project_details_id' => 1,
            'position' => 5,
        ]);

        /**
         * Terminal Provisions
         */

        DB::table('pd_contract_termination')->insert([
            'project_details_id' => 1,
            'party_type' => 'concessionaire',
            'name' => 'Event',
            'description' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'termination_payment' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'position' => 1,
        ]);
        DB::table('pd_contract_termination')->insert([
            'project_details_id' => 1,
            'party_type' => 'concessionaire',
            'name' => 'Event',
            'description' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'termination_payment' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'position' => 2,
        ]);

        DB::table('pd_contract_termination')->insert([
            'project_details_id' => 1,
            'party_type' => 'authority',
            'name' => 'Event',
            'description' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'termination_payment' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'position' => 3,
        ]);

        DB::table('pd_contract_termination')->insert([
            'project_details_id' => 1,
            'party_type' => 'authority',
            'name' => 'Event',
            'description' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'termination_payment' => 'Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.',
            'position' => 4,
        ]);

        /**
         * Renegotiations
         */

        DB::table('pd_renegotiations')->insert([
            'name' => 'Rationale for variation',
            'description' => 'Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.',
            'project_details_id' => 1,
            'position' => 1,
        ]);
        DB::table('pd_renegotiations')->insert([
            'name' => 'Change in roles and responsibilities of the parties',
            'description' => 'Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.',
            'project_details_id' => 1,
            'position' => 2,
        ]);
        DB::table('pd_renegotiations')->insert([
            'name' => 'Change in original risk allocation',
            'description' => 'Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.',
            'project_details_id' => 1,
            'position' => 3,
        ]);
        DB::table('pd_renegotiations')->insert([
            'name' => 'Change in original fiscal commitments or contingent liabilities of government',
            'description' => 'Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.',
            'project_details_id' => 1,
            'position' => 4,
        ]);
        DB::table('pd_renegotiations')->insert([
            'name' => 'Change in tariffs of service levels',
            'description' => 'Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.',
            'project_details_id' => 1,
            'position' => 5,
        ]);
        DB::table('pd_renegotiations')->insert([
            'name' => 'Date of variation',
            'description' => 'Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.',
            'project_details_id' => 1,
            'position' => 6,
        ]);

        /*
         |--------------------------------------------------------------------------
         |  End Project Details
         |--------------------------------------------------------------------------
         */
    }
}
