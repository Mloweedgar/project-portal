<?php

namespace ZanzibarPPP;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_information')->insert([
            'id' => 1,
            'project_id' => 1,
            'ocid' => 'ocds-12btn8-1',
            'stage_id' => 1,
            'project_need' => "The project involves the development of a six-lane, 77km limited access toll road between Kampala, the capital of Uganda, and Jinja. It aims to improve road infrastructure in Uganda, improve road safety and facilitate trade and tourism. The project will be developed on a design, build, finance, operate, maintain and transfer basis, with a concession period of 30 years.",
            'description_services' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'reasons_ppp' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'stakeholder_consultation' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'description_asset' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 156.7,
            'project_value_second' => 674.861,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
            ]);
        DB::table('project_information')->insert([
            'id' => 2,
            'project_id' => 2,
            'ocid' => 'ocds-12btn8-2',
            'stage_id' => 3,
            'project_need' => "Project 2 need",
            'description_services' => "Project 2 description services",
            'reasons_ppp' => "Project 2 reasons for PPP",
            'stakeholder_consultation' => "Project 2 stakeholder consulation",
            'description_asset' => "Project asset 2",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
        DB::table('project_information')->insert([
            'id' => 3,
            'project_id' => 3,
            'ocid' => 'ocds-12btn8-3',
            'stage_id' => 2,
            'project_need' => "Project 3 need",
            'description_services' => "Project 3 description services",
            'reasons_ppp' => "Project 3 reasons for PPP",
            'stakeholder_consultation' => "Project 3 stakeholder consulation",
            'description_asset' => "Project asset 3",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
        DB::table('project_information')->insert([
            'id' => 4,
            'project_id' => 4,
            'ocid' => 'ocds-12btn8-4',
            'stage_id' => 2,
            'project_need' => "Project 4 need",
            'description_services' => "Project 4 description services",
            'reasons_ppp' => "Project 4 reasons for PPP",
            'stakeholder_consultation' => "Project 4 stakeholder consulation",
            'description_asset' => "Project asset 4",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
        DB::table('project_information')->insert([
            'id' => 5,
            'project_id' => 5,
            'ocid' => 'ocds-12btn8-5',
            'stage_id' => 3,
            'project_need' => "Project 5 need",
            'description_services' => "Project 5 description services",
            'reasons_ppp' => "Project 5 reasons for PPP",
            'stakeholder_consultation' => "Project 5 stakeholder consulation",
            'description_asset' => "Project asset 5",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
        DB::table('project_information')->insert([
            'id' => 6,
            'project_id' => 6,
            'ocid' => 'ocds-12btn8-6',
            'stage_id' => 3,
            'project_need' => "Project 6 need",
            'description_services' => "Project 6 description services",
            'reasons_ppp' => "Project 6 reasons for PPP",
            'stakeholder_consultation' => "Project 6 stakeholder consulation",
            'description_asset' => "Project asset 6",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
        DB::table('project_information')->insert([
            'id' => 7,
            'project_id' => 7,
            'ocid' => 'ocds-12btn8-7',
            'stage_id' => 2,
            'project_need' => "Project 7 need",
            'description_services' => "Project 7 description services",
            'reasons_ppp' => "Project 7 reasons for PPP",
            'stakeholder_consultation' => "Project 7 stakeholder consulation",
            'description_asset' => "Project asset 7",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
        DB::table('project_information')->insert([
            'id' => 8,
            'project_id' => 8,
            'ocid' => 'ocds-12btn8-8',
            'stage_id' => 2,
            'project_need' => "Project 8 need",
            'description_services' => "Project 8 description services",
            'reasons_ppp' => "Project 8 reasons for PPP",
            'stakeholder_consultation' => "Project 8 stakeholder consulation",
            'description_asset' => "Project asset 8",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
        DB::table('project_information')->insert([
            'id' => 9,
            'project_id' => 9,
            'ocid' => 'ocds-12btn8-9',
            'stage_id' => 1,
            'project_need' => "Project 9 need",
            'description_services' => "Project 9 description services",
            'reasons_ppp' => "Project 9 reasons for PPP",
            'stakeholder_consultation' => "Project 9 stakeholder consulation",
            'description_asset' => "Project asset 9",
            'project_summary_document' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
            'project_value_usd' => 82.1,
            'project_value_second' => 353.634,
            'draft' => 0,
            'sponsor_id' => 1,
            'request_modification' => 0,
            'published' => 1,
            'ppp_delivery_model_id' => 1
        ]);
    }
}
