<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImportProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:role_admin;role_data_entry_project_coordinator');
    }

    public function index()
    {
        return view('back.import-project');
    }

    public function download(Request $request)
    {
        $templates_path = storage_path('app'.DIRECTORY_SEPARATOR.'import-project'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR);

        $name = 'zanzibar_ppp';
        
        $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        $excel_file = $templates_path.$name.'.xlsx';
        return Response::download($excel_file, 'template_'.$name.'.xlsx', $headers);
    }

    public function import(Request $request)
    {
        $response = [];

        // labels for exceptions
        $label_sectors = trans('excel.sectors');

        $label_regions = trans('excel.regions');
        
        $label_stage = trans('excel.phase');

        // ----------------------------------------------------------

        $name = md5(rand().$request->file('qqfile')).'.xlsx';
        // $name = md5(rand().$request->file('qqfile')).'.xlsx';
        $excel_path = Storage::putFileAs('import-project', $request->file('qqfile'), $name);
        $full_excel_path = storage_path('app'.DIRECTORY_SEPARATOR.$excel_path);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        // $spreadsheet = $reader->load("zanzibar_ppp.xlsx");
        $spreadsheet = $reader->load($full_excel_path);
        $activeSheet = $spreadsheet->getActiveSheet();

        DB::beginTransaction();
        try {
            // Project

            $project_name = $activeSheet->getCell('C1')->getValue();
            if ($project_name == '') {
                throw new \Exception('Project name can not be empty. Place it on cell C1 please');
            }

            if (env('APP_DEBUG') === true) {
                $project_name .= '-'.rand();
            }

            $basic_information = [];

            $sectors = [];
            $sectors_insert = [];

            $regions = [];
            $regions_insert = [];

            $stage_id = 0;
            $sponsor_id = 0;

            for ($i = 1; $i <= $activeSheet->getHighestDataRow(); $i++) {
                $key = $activeSheet->getCell('A'.$i)->getValue();

                if (substr($key, 0, '5' ) === 'field') {
                    $field = explode(':', $key)[1];
                    $value = trim($activeSheet->getCell('C'.$i)->getValue());

                    if (!in_array($field, ['sectors', 'regions', 'stage', 'sponsor', 'project_value_usd', 'project_value_second'])) {
                        $basic_information[$field] = $value;
                    } else {
                        switch($field) {
                            case 'sectors':
                                $sectors_names = array_map('trim',explode(',', $value));
                                $sectors_ids = [];
                                foreach ($sectors_names as $sector_name) {
                                    $sector_id = \DB::table('sectors')->select('id')->where('name', $sector_name)->first();
                                    if ($sector_id) {
                                        $sectors_ids[] = $sector_id->id;
                                    } else { // Nonexistent
                                        $valid_sectors = implode("</strong>, <strong>", array_column(\DB::table('sectors')->select('name')->get()->toArray(), 'name'));
                                        throw new \Exception("Could not recognize $label_sectors '$sector_name'. Valid ones are: <strong>".$valid_sectors."</strong>");
                                    }
                                }

                                foreach ($sectors_ids as $sector_id) {
                                    $sectors_insert[] = [
                                        'sector_id' => $sector_id
                                    ];
                                }
                                break;

                            case 'regions':
                                $regions_names = array_map('trim',explode(',', $value));
                                // $regions_ids = \DB::table('locations')->select('id')->whereIn('name', $regions_names)->get()->pluck('id')->toArray();

                                $regions_ids = [];
                                foreach ($regions_names as $region_name) {
                                    $region_id = \DB::table('locations')->select('id')->where('name', $region_name)->first();
                                    if ($region_id) {
                                        $regions_ids[] = $region_id->id;
                                    } else { // Nonexistent
                                        $valid_regions = implode("</strong>, <strong>", array_column(\DB::table('locations')->select('name')->get()->toArray(), 'name'));
                                        throw new \Exception("Could not recognize $label_regions '$region_name'. Valid ones are: <br/><strong>".$valid_regions."</strong>");
                                    }
                                }

                                foreach ($regions_ids as $region_id) {
                                    $regions_insert[] = [
                                        'location_id' => $region_id
                                    ];
                                }
                                break;

                            case 'stage':
                                $stage_id = \DB::table('stages')->select('id')->where('name', $value)->first();
                                if ($stage_id) {
                                    $stage_id = $stage_id->id;
                                } else { // Stage does not exist
                                    $valid_stages = implode("</strong>, <strong>", array_column(\DB::table('stages')->select('name')->get()->toArray(), 'name'));
                                    throw new \Exception("Could not recognize $label_stage '$value'. Valid ones are: <strong>".$valid_stages."</strong>");
                                }
                                $basic_information['stage_id'] = $stage_id;
                                break;

                            case 'sponsor':
                                $sponsor_id = \DB::table('entities')->select('id')->where('name', $value)->first();
                                if ($sponsor_id) {
                                    $sponsor_id = $sponsor_id->id;
                                } else {
                                    // create sponsor
                                    \DB::table('entities')->insert([
                                        'name' => $value,
                                        'description' => '',
                                        'draft' => 0,
                                        'requested_modification' => 0,
                                        'published' => 1
                                    ]);
                                    $sponsor_id = \DB::getPdo()->lastInsertId();
                                    $response['events'][] = "Entity '$value' didn't exist and, was created";
                                }

                                $basic_information['sponsor_id'] = $sponsor_id;
                                break;

                            case 'project_value_usd':
                                if (substr($value, 0, 1) === '=') {
                                    throw new \Exception("Project Value can not contain Excel formulas");
                                } elseif ($value == '') {
                                    throw new \Exception('Project Value can not be empty');
                                } elseif (strlen(str_replace('.', '', str_replace(',', '', $value))) > 8) {
                                    throw new \Exception('Project Value must be in million. Example: 1.52 and not 1520000');
                                }
                                $basic_information[$field] = str_replace(',','.', trim($value, "'"));
                                break;

                            case 'project_value_second':
                                if (substr($value, 0, 1) === '=') {
                                    throw new \Exception("Second Project Value can not contain Excel formulas");
                                } elseif (strlen(str_replace('.', '', str_replace(',', '', $value))) > 10) {
                                    throw new \Exception('Second Project Value must be in million. Example: 1.52 and not 1520000');
                                }
                                if ($value == '') {
                                       $basic_information[$field] = 0;
                                } else {
                                    $basic_information[$field] = str_replace(',','.', trim($value, "'"));
                                }
                                break;

                            // this field only appears in NSIA Excel
                            /*case 'type':
                                $types = [1 => 'public', 2 => 'private', 3 => 'ppp'];
                                foreach ($types as $type_id => $type) {
                                    if (stripos($value, $type) !== false) {
                                        $basic_information['type'] = $type_id;
                                        break;
                                    }
                                }
                                break;*/
                        }
                    }
                }
            }

            // Check project name
            if (\DB::table('projects')->select('id')->where('name', $project_name)->first()) {
                throw new \Exception("Project name '$project_name' is already taken");
            }

            // Project Basic Information
            $project_insert_query = \DB::table('projects')->insert([
                'name' => $project_name,
                'user_id' => 1,
                'active' => false,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
                        $project_id = \DB::getPdo()->lastInsertId();
\DB::commit();
//            $project_id = \DB::getPdo()->lastInsertId();

            $basic_information['project_id'] = $project_id;
            $ocid = \DB::table('configs')->select('value')->where('name', 'ocid')->first()->value;
            $basic_information['ocid'] = $ocid . '-'.$project_id;

            \DB::table('project_information')->insert($basic_information);

            // add foreign key
            foreach ($regions_insert as &$region_insert) {
                $region_insert['project_information_id'] = $project_id;
            }
            foreach ($sectors_insert as &$sector_insert) {
                $sector_insert['project_information_id'] = $project_id;
            }

            \DB::table('location_project_information')->insert($regions_insert);
            \DB::table('sector_project_information')->insert($sectors_insert);

            \DB::table('project_details')->insert(['project_id' => $project_id]);
            \DB::table('performance_information')->insert(['project_id' => $project_id]);
            \DB::table('pi_key_performance_main')->insert(['performance_information_id' => $project_id]);

            $exclude_sections = ['parties', 'kpi'];

            $in_section = '';
            $sections = [];

            for ($i = 1; $i <= $activeSheet->getHighestDataRow(); $i++) {
                $key = $activeSheet->getCell('A'.$i)->getValue();

                if (substr($key, 0, '7' ) === 'section') // section starts
                {
                    $section = explode(':', $key)[1];

                    if (!in_array($section, $exclude_sections))
                    {
                        $in_section = $section;
                        $sections[$in_section]['name'] = trim($activeSheet->getCellByColumnAndRow(1, $i)->getValue());
                        $sections[$in_section]['data'] = [];
                        $sections[$in_section]['columns'] = '';
                    } else {
                        $in_section = '';
                    }
                }
                elseif (substr($key, 0, '7' ) === 'columns') // columns of the sections
                {
                    $columns = explode(':', $key)[1];
                    $num_columns = count(explode(',', $columns));
                    $sections[$in_section]['columns'] = $columns;
                    $sections[$in_section]['columns_labels'] = [];

                    for ($col=1; $col <= $num_columns; $col++) {
                        $sections[$in_section]['columns_labels'][] = trim($activeSheet->getCellByColumnAndRow($col, $i)->getValue());
                    }
                }
                elseif ($in_section && $activeSheet->getHighestDataColumn($i) !== 'A') // data of the section
                {
                    $dataRow = [];

                    $num_columns = count(explode(',', $sections[$in_section]['columns']));

                    $value = '';
                    $has_some_value = false;
                    for ($col=1; $col <= $num_columns; $col++) {
                        $value = trim($activeSheet->getCellByColumnAndRow($col, $i)->getValue());
                        if ($value) {
                            $has_some_value = true;
                            $dataRow[] = $value;
                        } elseif ($has_some_value) {
                            $dataRow[] = '';
                        }
                    }

                    if (count($dataRow) > 0) {
                        $sections[$in_section]['data'][] = $dataRow;
                    }
                }
                else // not interested in (empty rows between sections, project basic information, parties & kpi sections ...)
                {
                    $in_section = '';
                }
            }

            // lets build an easy array to later process for inserts
            $sections_inserts = [];
            foreach ($sections as $table => $section_values)
            {
                $columns = explode(',', $section_values['columns']);

                $data = $section_values['data'];

                foreach ($data as $data_key => $data_values)
                {
                    foreach ($columns as $num_column => $column)
                    {
                        // Used for error messages
                        $column_name = $section_values['columns_labels'][$num_column];
                        $section_name = $section_values['name'];

                        // we need to replace the string with the relation ID
                        if (substr($column, 0, '8' ) === 'relation') {
                            $relation_data = explode(';', rtrim(substr($column, 9), ']'));

                            list($relation_table, $relation_column, $foreign_key_column) = $relation_data;

                            $value_column = $data_values[$num_column];

                            $foreign_key_id = \DB::table($relation_table)->select('id')->where($relation_column, $value_column)->first();
                            if ($foreign_key_id) {
                                $foreign_key_id = $foreign_key_id->id;
                            } else {
                                $possible_values = implode("', '", array_column(\DB::table($relation_table)->select($relation_column)->get()->toArray(), $relation_column));
                                throw new \Exception(
                                    "'$value_column' is not a valid value for '$column_name' column  inside '$section_name' section. Possible values are: ".
                                    "'$possible_values'"
                                );
                            }

                            $sections_inserts[$table][$data_key][$foreign_key_column] = $foreign_key_id;
                        } else {
                            $data_value = $data_values[$num_column] ?? '';

                            if ($data_value) {
                                // date format of contract milestones
                                if ($table === 'contract_milestones' && $column === 'date') {
                                    $date_format = \DateTime::createFromFormat('Y-m-d', $data_value);
                                    $datetime_format = \DateTime::createFromFormat('Y-m-d H:i:s', $data_value);

                                    if ($date_format) {
                                        $data_value = $date_format->format('Y-m-d');
                                    } elseif ($datetime_format) {
                                        $data_value = $datetime_format->format('Y-m-d');
                                    } else {
                                        throw new \Exception("'$data_value' is not a valid date format for '$section_name' section. It must follow the following format: Year-Month-Day (".date('Y-m-d').")");
                                    }
                                }

                                // only yes or no performance failures
                                if ($table === 'pi_performance_failures') {
                                    if ($column === 'number_events') {
                                        if (!is_numeric($data_value)) {
                                            throw new \Exception("'$data_value' is not a valid value for '$column_name' in '$section_name' section. The value must be a number");
                                        }
                                    }

                                    if ($column === 'penalty_paid') {
                                        if (!in_array(strtolower($data_value), ['yes', 'no'])) {
                                            throw new \Exception("'$data_value' is not a valid value for '$column_name' in '$section_name' section. It can only be: Yes or No");
                                        } else {
                                            if (strtolower($data_value) == 'yes') {
                                                $data_value = 1;
                                            } elseif (strtolower($data_value) == 'no') {
                                                $data_value = 0;
                                            }
                                        }
                                    }
                                }

                                // termination provisions enum: concessionaire, authority (exception)
                                if ($table === 'pd_contract_termination' && $column === 'party_type') {
                                    if (!in_array(strtolower($data_value), ['operator', 'authority'])) {
                                        throw new \Exception("'$data_value' is not a valid Party Type in '$section_name' section");
                                    }
                                }
                            }

                            $sections_inserts[$table][$data_key][$column] = $data_value;
                        }

                        // put project related foreign key column
                        if (substr($table, 0, '3' ) === 'pd_' && $table !== 'pd_procurement') {
                            $project_column = 'project_details_id';
                        } elseif (substr($table, 0, '3' ) === 'pi_') {
                            $project_column = 'performance_information_id';
                        } else {
                            $project_column = 'project_id';
                        }

                        $sections_inserts[$table][$data_key][$project_column] = $project_id;
                    }
                }
            }

            // insert it all !!!
            foreach ($sections_inserts as $section_table => $section_data)
            {
                \DB::table($section_table)->insert($section_data);
            }

            // parties section
            $parties_insert = [];
            $parties_started_at = 0;

            $parties_to_insert_starts_after = 0;
            /*if ($basic_information['type'] === 1 || $basic_information['type'] === 2) {
                $parties_to_insert_starts_after = 2;
            } else {*/
                $parties_to_insert_starts_after = 1;
            //}
            
            for ($i = 1; $i <= $activeSheet->getHighestDataRow(); $i++)
            {
                $key = $activeSheet->getCell('A'.$i)->getValue();

                if (substr($key, 0, 15 ) === 'section:parties')
                {
                    $parties_started_at = $i;
                }
                elseif ($parties_started_at)
                {
                    $highestCol = \PhpOffice\PhpSpreadsheet\Cell::columnIndexFromString($activeSheet->getHighestDataColumn($i));
                    if ($highestCol === 1) {
                        break;
                    }

                    if (($i-$parties_started_at) > $parties_to_insert_starts_after) {
                        $entity_name = trim($activeSheet->getCellByColumnAndRow(1, $i)->getValue());

                        if ($entity_name) {
                            $entity_id = \DB::table('entities')->select('id')->where($relation_column, $entity_name)->first();
                            if ($entity_id) {
                                $entity_id = $entity_id->id;
                            } else {
                                \DB::table('entities')->insert([
                                    'name' => $entity_name,
                                    'description' => '',
                                    'draft' => 0,
                                    'requested_modification' => 0,
                                    'published' => 1
                                ]);
                                $entity_id = \DB::getPdo()->lastInsertId();
                                $response['events'][] = "Entity '$entity_name' didn't exist, and was created";
                            }

                            $parties_insert[] = [
                                'project_id' => $project_id,
                                'entity_id' => $entity_id,
                                'party' => 1,
                                'sponsor' => 0,
                            ];
                        }
                    }
                }
            }

            // insert parties
            \DB::table('entity_project')->insert($parties_insert);

            
            //if ($basic_information['type'] !== 3) {

                // interesting part comes here ... KPI !!!
                $kpi_years = [];
                $kpi_values = [];

                $kpi_started_at = 0;
                for ($i = 1; $i <= $activeSheet->getHighestDataRow(); $i++) {
                    $key = $activeSheet->getCell('A'.$i)->getValue();

                    if (substr($key, 0, 11 ) === 'section:kpi')
                    {
                        $kpi_started_at = $i;
                    }
                    elseif ($kpi_started_at) // inside KPI section
                    {
                        $highestCol = \PhpOffice\PhpSpreadsheet\Cell::columnIndexFromString($activeSheet->getHighestDataColumn($i));

                        if ($highestCol === 1) {
                            break;
                        }

                        // kpi years
                        if (($i-$kpi_started_at) === 1) {
                            for ($col=2; $col <= $highestCol; $col++) {

                                $years_value = trim($activeSheet->getCellByColumnAndRow($col, $i)->getValue());

                                if ($years_value) {
                                    $kpi_years[] = $years_value;
                                }
                            }
                            $kpi_years = array_values(array_unique($kpi_years));
                        }

                        // kpi values
                        if (($i-$kpi_started_at) > 2) {

                            $kpi_type = 0;

                            for ($col=1; $col <= $highestCol; $col++) {
                                $performance_value = trim($activeSheet->getCellByColumnAndRow($col, $i)->getValue());

                                // KPI types (first columns)
                                if ($col === 1) {
                                    if ($performance_value) {
                                        $kpi_type_and_unit = explode('(', $performance_value);

                                        // no unit
                                        if (count($kpi_type_and_unit) === 1) {
                                            $kpi_type_and_unit[] = '-';
                                        }

                                        list($type_name, $type_unit) = $kpi_type_and_unit;
                                        $type_unit = rtrim($type_unit, ')');

                                        $type_id = \DB::table('pi_key_performance_indicators_kpi_types')->select('id')->where('name', $type_name)->where('unit', $type_unit)->first();
                                        if ($type_id) {
                                            $performance_value = $type_id->id;
                                        } else {
                                            // create KPI type
                                            \DB::table('pi_key_performance_indicators_kpi_types')->insert([
                                                'name' => $type_name,
                                                'unit' => $type_unit,
                                            ]);
                                            $performance_value = \DB::getPdo()->lastInsertId();
                                            $response['events'][] = "KPI Type '$type_name($type_unit)' didn't exist, and was created";
                                        }

                                        $kpi_type = $performance_value;

                                        if (isset($kpi_values[$kpi_type])) {
                                            throw new \Exception("KPI type '$type_name' is duplicated. Duplicate KPI types are not supported");
                                        }
                                    } else {
                                        $i = $activeSheet->getHighestDataRow(); // EXIT from section if first column is empty
                                    }

                                } else {
                                    // I'm in a column higher than 1, and column 1 was empty, so I'm a target or an achievement of some years
                                    // but don't have a KPI, ignore
                                    if ($kpi_type !== 0) {
                                        $kpi_values[$kpi_type][] = $performance_value !== '' ? $performance_value : '0';
                                    }
                                }
                            }
                        }
                    }
                }

                // build kpi inserts
                if ($kpi_years) {
                    $kpi_inserts = [];

                    foreach ($kpi_values as $kpi_type => $kpi_value)
                    {
                        // needed to insert empty kpis
                        $last_kpi = count($kpi_value)-1;
                        unset($kpi_value[$last_kpi]);

                        // fill all the empty values with 0
                        if (count($kpi_value) === 0) {
                            for ($i=0;$i <= ((count($kpi_years)*2)-1); $i++) {
                                $kpi_value[] = 0;
                            }
                        }

                        $kpi_set = array_chunk($kpi_value, 2);
                        foreach ($kpi_set as $kpi_set_key => $kpi_s)
                        {
                            if (isset($kpi_years[$kpi_set_key])) {
                                $kpi_inserts[] = [
                                    'year' => $kpi_years[$kpi_set_key],
                                    'target' => $kpi_s[0] ?? 0, // put to zero if empty
                                    'achievement' => $kpi_s[1] ?? 0, // put to zero if empty
                                    'type_id' => $kpi_type,
                                    'pi_key_performance_main_id' => $project_id
                                ];
                            }
                        }
                    }
                } else {
                    throw new \Exception('KPI years can not be empty');
                }

                // insert kpi
                \DB::table('pi_key_performance_indicators')->insert($kpi_inserts);
            //}


            $response['events'][] = "Project '$project_name' was sucessfully imported. <a href='".route('project.project-information', ['id' => $project_id])."'>Go to project</a>";

            \DB::commit();

            $response['success'] = true;
        } catch (\Exception $e) {
            \DB::rollBack();

            $response['success'] = false;
            $response['error'] = $e->getMessage();

            // regulate keys
            $keys_regulated = false;
            $autoincrement = $this->getAutoincrementOf('pi_key_performance_main');
            $tables_check = ['projects', 'project_information'];
            foreach ($tables_check as $table_check) {
                if ($this->getAutoincrementOf($table_check) > $autoincrement) {
                    $this->setAutoincrementOf($table_check, $autoincrement);
                    $keys_regulated = true;
                }
            }
            if ($keys_regulated) {
                $response['error'] = 'Please try again. ' . $e->getMessage();
            }
        } finally {
            // Remove Excel
            unlink(storage_path('app'.DIRECTORY_SEPARATOR.'import-project'.DIRECTORY_SEPARATOR.$name));
        }

        return response()
            ->json($response);
    }

    private function getAutoincrementOf($table)
    {
        return \DB::table('information_schema.tables')->select('AUTO_INCREMENT as increment')->where('table_name', $table)->first()->increment;
    }

    private function setAutoincrementOf($table, int $auto_increment)
    {
        return \DB::statement('ALTER TABLE '.$table.' AUTO_INCREMENT='.$auto_increment);
    }
}
