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

        return [
            'd' => route('project-details-documents', array('id' => $project->id)),
            'fi' => route('project-details-financial', array('id' => $project->id)),
            'env' => route('project-details-environment', array('id' => $project->id)),
            'ri' => route('project-details-risks', array('id' => $project->id)),
            'e' => route('project-details-evaluation-ppp', array('id' => $project->id)),
            'gs' => route('project-details-government-support', array('id' => $project->id)),
            't' => route('project-details-tariffs', array('id' => $project->id)),
            'ct' => route('project-details-contract-termination', array('id' => $project->id)),
            'r' => route('project-details-renegotiations', array('id' => $project->id)),
            'aw' => route('project-details-award', array('id' => $project->id)),
            /*
            'env' => route('project-details-environment', array('id' => $project->id)),
             */
        ];

    }

    /**
     * Get the order of the Project Performance at the Backend
     *
     * @param Project $project
     * @return array
     */
    public static function getProjectPerformanceOrder(Project $project){

        return [
            /*
            'dl' => route('project.performance-information.annual-demand-levels', array('id' => $project->id)),
            'ism' => route('project.performance-information.income-statements-metrics', array('id' => $project->id)),
            'of' => route('project.performance-information.other-financial-metrics', array('id' => $project->id)),
            */
            'kpi' => route('project.performance-information.key-performance-indicators', array('id' => $project->id)),
            'pf' => route('project.performance-information.performance-failures', array('id' => $project->id)),
            'pa' => route('project.performance-information.performance-assessments', array('id' => $project->id)),
        ];

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
                    'section_code' => 'aw',
                    'name' => $project->getSectorName('aw'),
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
