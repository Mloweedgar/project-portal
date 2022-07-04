<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        VIEW ONLY 1
        =========================================================
         */
      DB::table('permission_user_project')->insert([
          'user_id' => 2, // User of validaton
          'project_id' => 2 // Accra Plains Irrigation Project
      ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 1 // Basic info.
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 2 // Contract milestones
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 3 // Parties
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 12 // Project details
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 13 // Contract documents
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 14 // Announcements
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 15 // Procurement information
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 2, // View only 1
           'section_id' => 16 // Risks
       ]);

       /*
       VIEW ONLY 2
       =========================================================
        */

       DB::table('permission_user_project')->insert([
           'user_id' => 3, // View only 2
           'project_id' => 9 // Transport
       ]);

       DB::table('permission_user_project')->insert([
           'user_id' => 3, // View only 2
           'project_id' => 5 // Energy
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 1 // Basic info.
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 2 // Contract milestones
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 3 // Parties
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 12 // Project details
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 13 // Contract documents
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 14 // Announcements
       ]);


       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 4 // Performance Information
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 5 // Annual demand levels
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 6 // Income statements metrics
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 7 // Other financial metrics
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 8 // Key performance indicators
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 9 // Performance failures
       ]);

       DB::table('permission_user_section')->insert([
           'user_id' => 3, // View only 2
           'section_id' => 10 // Performance assessments
       ]);

       /*
        User of validaton
       =========================================================
        */

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 1 // Basic info.
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 2 // Contract milestones
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 3 // Parties
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 12 // Project details
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 13 // Contract documents
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 14 // Announcements
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 15 // Procurement information
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 16 // Risks
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 17 // Evaluation of PPP
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 18 // Financial support
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 19 // Government support
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 20 // Tariffs
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 21 // Terminal Provisions
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 22 // Renegotiations
        ]);


        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 4 // Performance Information
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 5 // Annual demand levels
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 6 // Income statements metrics
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 7 // Other financial metrics
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 8 // Key performance indicators
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 9 // Performance failures
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 4, // User of validaton
            'section_id' => 10 // Performance assessments
        ]);


       /*
        Data Entry - Generic
       =========================================================
        */

        /*DB::table('coordinator_assigned_data_entries')->insert([
            'de_generic_id' => 5,
            'project_coordinator' => 6,
        ]);*/

        DB::table('permission_user_project')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'project_id' => 2 // Establishment of a New National Airline
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 1 // Basic info.
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 2 // Contract milestones
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 3 // Parties
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 11 // Gallery
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 12 // Project details
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 13 // Contract documents
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 14 // Announcements
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 15 // Procurement information
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 16 // Risks
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 17 // Evaluation of PPP
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 18 // Financial support
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 19 // Government support
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 20 // Tariffs
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 21 // Terminal Provisions
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 22 // Renegotiations
        ]);


        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 4 // Performance Information
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 5 // Annual demand levels
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 6 // Income statements metrics
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 7 // Other financial metrics
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 8 // Key performance indicators
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 9 // Performance failures
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Generic
            'section_id' => 10 // Performance assessments
        ]);

       /*
        Data Entry - Project Coordinator
       =========================================================
        */

           DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 1 // Basic info.
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 2 // Contract milestones
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 3 // Parties
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 11 // Project details
        ]);
        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 12 // Project details
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 13 // Contract documents
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 14 // Announcements
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 15 // Procurement information
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 16 // Risks
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 17 // Evaluation of PPP
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 18 // Financial support
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 19 // Government support
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 20 // Tariffs
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 21 // Terminal Provisions
        ]);

        DB::table('permission_user_section')->insert([
            'user_id' => 5, // Data Entry - Project Coordinator
            'section_id' => 22 // Renegotiations
        ]);

    }
}
