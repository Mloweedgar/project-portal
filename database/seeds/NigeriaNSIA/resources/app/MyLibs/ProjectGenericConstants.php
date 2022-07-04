<?php

namespace App\MyLibs;

use App\Models\Project\Project;

class ProjectGenericConstants {

    /**
     * Get the order of the Project Details at the Backend
     *
     * @param Project $project
     * @return array
     */
    public static function getProjectDetailsOrder(Project $project){
        $sections_codes = [];

        if (!$project->isTypePPP()) {
            $sections_codes['cs'] = route('project-details-contract-summary', array('id' => $project->id));
        }

        $sections_codes['fi'] = route('project-details-financial', array('id' => $project->id));

        if (!$project->isTypePublic()) {
            $sections_codes['ri'] = route('project-details-risks', array('id' => $project->id));
        }

        if (!$project->isTypePublic()) {
            $sections_codes['gs'] = route('project-details-government-support', array('id' => $project->id));
        }

        if ($project->isTypePPP()) {
            $sections_codes['t'] = route('project-details-tariffs', array('id' => $project->id));
        }

        if ($project->isTypePPP()) {
            $sections_codes['ct'] = route('project-details-contract-termination', array('id' => $project->id));
        }

        if (!$project->isTypePublic()) {
            $sections_codes['r'] = route('project-details-renegotiations', array('id' => $project->id));
        }

        return $sections_codes;
    }

    /**
     * Get the order of the Project Performance at the Backend
     *
     * @param Project $project
     * @return array
     */
    public static function getProjectPerformanceOrder(Project $project){
        $sections_codes = [];

        if ($project->isTypePPP()) {
            $sections_codes =  [
                'kpi' => route('project.performance-information.key-performance-indicators', array('id' => $project->id)),
                'pf' => route('project.performance-information.performance-failures', array('id' => $project->id)),
                'pa' => route('project.performance-information.performance-assessments', array('id' => $project->id)),
            ];
        }

        return $sections_codes;

    }

    public static function getProjectSectionsList(Project $project)
    {
        return [
            [
                'section_code' => 'i',
                'name' => $project->getSectorName('i'),
                'group' => false
            ],
            [
                'section_code' => 'cm',
                'name' => $project->getSectorName('cm'),
                'group' => false
            ],
            [
                'section_code' => 'pri',
                'name' => $project->getSectorName('pri'),
                'group' => false
            ],
            [
                'section_code' => 'par',
                'name' => $project->getSectorName('par'),
                'group' => false
            ],
            [
                'section_code' => 'pd',
                'name' => $project->getSectorName('pd'),
                'group' => true
            ],
                [
                    'section_code' => 'cs',
                    'name' => $project->getSectorName('cs'),
                    'group' => false
                ],
                [
                    'section_code' => 'fi',
                    'name' => $project->getSectorName('fi'),
                    'group' => false
                ],
                [
                    'section_code' => 'd',
                    'name' => $project->getSectorName('d'),
                    'group' => false
                ],
                [
                    'section_code' => 'env',
                    'name' => $project->getSectorName('env'),
                    'group' => false
                ],
                [
                    'section_code' => 'ri',
                    'name' => $project->getSectorName('ri'),
                    'group' => false
                ],
                [
                    'section_code' => 'gs',
                    'name' => $project->getSectorName('gs'),
                    'group' => false
                ],
                [
                    'section_code' => 't',
                    'name' => $project->getSectorName('t'),
                    'group' => false
                ],
                [
                    'section_code' => 'ct',
                    'name' => $project->getSectorName('ct'),
                    'group' => false
                ],
                [
                    'section_code' => 'r',
                    'name' => $project->getSectorName('r'),
                    'group' => false
                ],
            [
                'section_code' => 'pi',
                'name' => $project->getSectorName('pi'),
                'group' => true,
                'parent' => null
            ],
                [
                    'section_code' => 'kpi',
                    'name' => $project->getSectorName('kpi'),
                    'group' => false,
                ],
                [
                    'section_code' => 'pf',
                    'name' => $project->getSectorName('pf'),
                    'group' => false,
                ],
                [
                    'section_code' => 'pa',
                    'name' => $project->getSectorName('pa'),
                    'group' => false,
                ],
            [
                'section_code' => 'g',
                'name' => $project->getSectorName('g'),
                'group' => false,
                'parent' => null
            ],
            [
                'section_code' => 'a',
                'name' => $project->getSectorName('a'),
                'group' => false,
            ],
        ];

    }

}
