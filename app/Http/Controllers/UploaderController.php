<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Banner;
use App\Models\Mystery;
use App\Models\Project\Project;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Zipper;

class DirectoryException extends \Exception {}

class UploaderController extends Controller
{

    public function __construct()
    {



    }

    /**
     * @param Project $project
     * @param array $args
     * @return array
     */
    public static function documentsApiLoader(Project $project, $args = array()){

        $out = array();

        if($args){

            try {

                // Get all files within that Project/Section/Position
                $uploadedFiles = Media::where('project', $project->id)
                    ->where('section', $args["section"]);

                if (isset($args["position"])) {
                    $uploadedFiles->where('position', $args["position"]);
                }

                $uploadedFiles = $uploadedFiles->get();

                foreach($uploadedFiles as $file){

                    $out[] = array(
                        'id' => $file->id,
                        'documentType' => self::getOcdsDocumentTypeApi($args["section"], $args["position"]),
                        'title' => $file->old_name,
                        'format' => $file->mime_type,
                        'url' => route('application.media',["id"=> $file->id]),
                        'datePublished' => $file->created_at->format('c'),
                    );
                }

            } catch (FatalThrowableError $fatal) {

                Log::critical(
                    PHP_EOL.
                    "|- Action: UploaderController@documentsApiLoader".PHP_EOL.
                    "|- User ID: API".PHP_EOL.
                    "|- Line number: ".$fatal->getLine().PHP_EOL.
                    "|- Message: ".$fatal->getMessage().PHP_EOL.
                    "|- File: ".$fatal->getFile()
                );

            }

        } else {

            try {

                // Get all files within that Project/Section/Position
                $uploadedFiles = Media::where('project', $project->id)
                    ->get();

                foreach($uploadedFiles as $file){

                    $out[] = array(
                        'id' => $file->id,
                        'title' => $file->old_name,
                        'format' => $file->mime_type,
                        'url' => route('application.media',["id"=> $file->id]),
                        'datePublished' => $file->created_at->format('c'),
                    );
                }

            } catch (FatalThrowableError $fatal) {

                Log::critical(
                    PHP_EOL.
                    "|- Action: UploaderController@documentsApiLoader".PHP_EOL.
                    "|- User ID: API".PHP_EOL.
                    "|- Line number: ".$fatal->getLine().PHP_EOL.
                    "|- Message: ".$fatal->getMessage().PHP_EOL.
                    "|- File: ".$fatal->getFile()
                );

            }

        }

        return $out;

    }


    /**
     * @param Request $request
     */
    public function initFiles(Request $request){

        // Init result output
        $result = array();

        try {

            // Get all files within that Project/Section/Position
            $uploadedFiles = Media::where('project', $request["projectAddress"])
                ->where('section', $request["sectionAddress"])
                ->where('position', $request["positionAddress"])
                ->get();

            foreach($uploadedFiles as $file){
                if ($request["sectionAddress"]=='s'){

                    $result[] = array(
                        'name' => $file->old_name,
                        'uuid' => $file->name,
                        'size' => $file->size,
                        'thumbnailUrl' => route('uploader.s',['position'=>$request["positionAddress"]])
                    );

                }else{

                    $result[] = array(
                        'name' => $file->old_name,
                        'uuid' => $file->name,
                        'size' => $file->size,
                    );

                }

            }

        } catch (FatalThrowableError $fatal) {

            Log::critical(
                PHP_EOL.
                "|- Action: UploaderController@storeUpload".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$fatal->getLine().PHP_EOL.
                "|- Message: ".$fatal->getMessage().PHP_EOL.
                "|- File: ".$fatal->getFile()
            );

        }

        Log::debug($result);

        echo json_encode($result);

    }

    /**
     * @param Request $request
     */
    public function storeUpload(Request $request){

        // Init result output
        $result = array(
            'success' => false
        );

        try{
            // Calculate the position of the file that is being uploaded
            /**
             * UPLOADS ARE PROCESSED ASYNCHRONOUSLY
             * KEEP IN MIND THIS IF YOU NEED TO MODIFY THE POSITIONING OF THE ELEMENTS
             */
            if($request["positionAddress"] == -1){

                // CREATE ATTEMPT
                // Auto position the element
                $countNewUpload = Media::where('uniqueToken', $request['uniqueToken'])->count();

                if($countNewUpload != 0){

                    $accessZone = "EQUALITY ZONE";

                    $elementPosition = Media::where('uniqueToken', $request['uniqueToken'])->first()->position;

                } else {

                    $accessZone = "INCREMENTAL ZONE";

                    if(!Auth::user()->isAdmin() && !Auth::user()->isProjectCoordinator()) {

                        $elementPosition = 0;

                    } else {

                        $elementPosition = $this->getNextGeneratedID($request["sectionAddress"]);

                    }

                }

                Log::debug(
                    PHP_EOL.
                    "|- Token: ".$request['uniqueToken'].PHP_EOL.
                    "|- Incoming Position: ".$request["positionAddress"].PHP_EOL.
                    "|- Final Position: ".$elementPosition.PHP_EOL.
                    "|- Zone: ".$accessZone.PHP_EOL.
                    "|- Counter: ".$countNewUpload
                );

            } else {

                // UPDATE ATTEMPT
                // Use default position
                $elementPosition = $request["positionAddress"];

            }

            // Build or use the path directory

            if ($request['sectionAddress']=='ga'){
                $directory = '/vault/ga/'.$request["projectAddress"];
            }else{
                $directory = $this->calculateStoragePath(array(
                    'projectAddress' => $request["projectAddress"],
                    'sectionAddress' => $request["sectionAddress"],
                    'positionAddress' => $elementPosition
                ));
            }

            $fileToUpload = new File($request["qqfile"]);

            /**
             * SANITIZE THE FILE NAME OF THE FILE
             */
            $firstFileParsed = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $request["qqfilename"]);
            $secondFileParsed = mb_ereg_replace("([\.]{2,})", '', $firstFileParsed);
            $thirdFileParsed = preg_replace('/\s+/', '-', $secondFileParsed);
            $finalParsedName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $thirdFileParsed);

            $uniqueFilename = $finalParsedName . "-" . $request["qquuid"]. "." .$fileToUpload->extension();

            // Upload the file to the resultant directory
            if (Storage::putFileAs($directory, $fileToUpload, $uniqueFilename)) {

                DB::beginTransaction();

                // If banner exists in that position delete previous one
                if ($request["positionAddress"] != -1 && $request["sectionAddress"] == 'b' && $request["projectAddress"] == '0') {
                    $banner = Media::where('section', 'b')->where('position', $request["positionAddress"])->first();
                    if ($banner) {
                        $banner->delete();
                        Storage::delete($banner->path);
                    }
                    // If entity logo already exists
                } elseif ($request["positionAddress"] != -1 && $request["sectionAddress"] == 'par' && $request["projectAddress"] == '0') {
                    $entity_logo = Media::where('section', 'par')->where('position', $request["positionAddress"])->first();
                    if ($entity_logo) {
                        $entity_logo->delete();
                        Storage::delete($entity_logo->path);
                    }
                }

                if(Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator() || Auth::user()->isIT()){

                    $dbFile = new Media();
                    $dbFile->name = $request["qquuid"];
                    $dbFile->old_name = $request["qqfilename"];
                    $dbFile->extension = $fileToUpload->extension();
                    $dbFile->mime_type = $fileToUpload->getMimeType();
                    $dbFile->project = $request["projectAddress"];
                    $dbFile->section = $request["sectionAddress"];
                    $dbFile->path = $directory . "/" . $uniqueFilename;
                    $dbFile->position = $elementPosition;
                    $dbFile->size = $fileToUpload->getSize();
                    $dbFile->uniqueToken = $request["uniqueToken"];
                    $dbFile->save();

                    if ($request["projectAddress"] != 0 && !$request["sectionAddress"]=="ga") {
                        $project = Project::find($request["projectAddress"]);
                        $project->touch();
                    }

                } else {

                    $dbFile = new Mystery();
                    $dbFile->name = $request["qquuid"];
                    $dbFile->old_name = $request["qqfilename"];
                    $dbFile->extension = $fileToUpload->extension();
                    $dbFile->mime_type = $fileToUpload->getMimeType();
                    $dbFile->project = $request["projectAddress"];
                    $dbFile->section = $request["sectionAddress"];
                    $dbFile->path = $directory . "/" . $uniqueFilename;
                    $dbFile->position = $elementPosition;
                    $dbFile->size = $fileToUpload->getSize();
                    $dbFile->uniqueToken = $request["uniqueToken"];
                    $dbFile->save();

                }

                DB::commit();

                array_set($result, 'success', true);
            }

        } catch (DirectoryException $d) {

            Log::error(
                PHP_EOL.
                "|- Action: UploaderController@storeUpload".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$d->getLine().PHP_EOL.
                "|- Message: ".$d->getMessage().PHP_EOL.
                "|- File: ".$d->getFile()
            );

        } catch (FileNotFoundException $notFound) {

            Log::error(
                PHP_EOL.
                "|- Action: UploaderController@storeUpload".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$notFound->getLine().PHP_EOL.
                "|- Message: ".$notFound->getMessage().PHP_EOL.
                "|- File: ".$notFound->getFile()
            );

        } catch (FatalThrowableError $fatal) {

            Log::critical(
                PHP_EOL.
                "|- Action: UploaderController@storeUpload".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$fatal->getLine().PHP_EOL.
                "|- Message: ".$fatal->getMessage().PHP_EOL.
                "|- File: ".$fatal->getFile()
            );

        }

        echo json_encode($result);

    }

    /**
     * @param $uuid
     */
    public function deleteUpload($uuid){

        try{

            DB::beginTransaction();

            $fileRecord = Media::where('name', $uuid)->first();
            $fileToDelete = $fileRecord->path;

            if ($fileRecord->section=="all"){

                // Retrieve and delete the file record at the database

                // Delete the database record
                $fileRecord->delete();

                // Delete the file
                Storage::delete($fileToDelete);

            } else {

                if(Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator() || Auth::user()->isIT()) {

                    // Delete the database record
                    $fileRecord->delete();

                    // Delete the file
                    Storage::delete($fileToDelete);

                } else {

                    // Retrieve and delete the file record at the database
                    $fileRecord->to_delete = 1;
                    $fileRecord->save();
                }

            }


            DB::commit();

        } catch (FileNotFoundException $notFound) {

            Log::error(
                PHP_EOL.
                "|- Action: UploaderController@storeUpload".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$notFound->getLine().PHP_EOL.
                "|- Message: ".$notFound->getMessage().PHP_EOL.
                "|- File: ".$notFound->getFile()
            );

        } catch (FatalThrowableError $fatal) {

            Log::critical(
                PHP_EOL.
                "|- Action: UploaderController@storeUpload".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$fatal->getLine().PHP_EOL.
                "|- Message: ".$fatal->getMessage().PHP_EOL.
                "|- File: ".$fatal->getFile()
            );

        }

    }

    /**
     * Get the OCDS document type of a file based on its section and position
     * @param $section
     * @param $position
     * @return string
     */
    public static function getOcdsDocumentTypeApi($section, $position){

        switch ($section){
            // Basic Project Information
            case 'i':
                // Basic Project Information is special =P
                switch ($position){
                    case 2: $out = 'needsAssessment'; break;
                    case 3: $out = 'marketStudies'; break;
                    case 4: $out = 'marketStudies'; break;
                    case 5: $out = 'feasibilityStudy'; break;
                    case 6: $out = 'feasibilityStudy'; break;
                    case 7: $out = 'feasibilityStudy'; break;
                    default: $out = 'x_other';
                }
                break;
            // Procurement Documents
            case 'pri': $out = 'biddingDocuments'; break;
            // Redacted PPP Agreement
            case 'd': $out = 'contractSigned'; break;
            // Financial Structure
            case 'fi': $out = 'contractAnnexe'; break;
            // Risks
            case 'ri': $out = 'riskProvisions'; break;
            // Government Support
            case 'gs': $out = 'assetAndLiabilityAssessment'; break;
            // Tariffs
            case 't': $out = 'contractSigned'; break;
            // Termination Provisions
            case 'ct': $out = 'contractSigned'; break;
            // Renegotiation
            case 'r': $out = 'contractSigned'; break;
            // Performance Assessments
            case 'pa'; $out = 'finalAudit'; break;

            // According to the OCDS PPP Profile, documents code list
            // additional entries can be included with a x_ prefix
            default: $out = 'x_other'; break;
        }

        return $out;

    }

    /**
     * @param $section
     * @return mixed
     */
    private function getNextGeneratedID($section){

        switch ($section) {

            // Projects
            case 'i': $elementPosition = $this->getNextAutoIncrement('project_information'); break;
            case 'cm': $elementPosition = $this->getNextAutoIncrement('contract_milestones'); break;
            case 'par': $elementPosition = $this->getNextAutoIncrement('entities'); break;
            case 'pd': $elementPosition = $this->getNextAutoIncrement('project_details'); break;
            case 'pi': $elementPosition = $this->getNextAutoIncrement('performance_information'); break;
            case 'g': $elementPosition = $this->getNextAutoIncrement('project_galleries'); break;

            // Project Details
            case 'd': $elementPosition = $this->getNextAutoIncrement('pd_document'); break;
            case 'env': $elementPosition = $this->getNextAutoIncrement('pd_enviroment'); break;
            case 'a': $elementPosition = $this->getNextAutoIncrement('pd_announcements'); break;
            case 'pri': $elementPosition = $this->getNextAutoIncrement('pd_procurement'); break;
            case 'ri': $elementPosition = $this->getNextAutoIncrement('pd_risks'); break;
            case 'e': $elementPosition = $this->getNextAutoIncrement('pd_evaluation'); break;
            case 'fi': $elementPosition = $this->getNextAutoIncrement('pd_financial'); break;
            case 'gs': $elementPosition = $this->getNextAutoIncrement('pd_government_support'); break;
            case 't': $elementPosition = $this->getNextAutoIncrement('pd_tariffs'); break;
            case 'ct': $elementPosition = $this->getNextAutoIncrement('pd_contract_termination'); break;
            case 'r': $elementPosition = $this->getNextAutoIncrement('pd_renegotiations'); break;

            // Performance Information
            case 'pa': $elementPosition = $this->getNextAutoIncrement('pi_performance_assessment'); break;

            // Others
            case 's': $elementPosition = $this->getNextAutoIncrement('sliders'); break;
            case 'b': $elementPosition = $this->getNextAutoIncrement('banners'); break;


            // USE ZERO FOR STATIC AND UNALLOCATED ITEMS
            default: $elementPosition = 0;

        }

        return $elementPosition;

    }

    /**
     * @param $table
     * @return mixed
     */
    private function getNextAutoIncrement($table){

        $statement = DB::select("show table status like '$table'");

        return $statement[0]->Auto_increment;

    }

    /**
     * @param array $args
     * @return bool|string
     * @throws DirectoryException
     */
    private function calculateStoragePath(Array $args){

        /**
         * --- Path legend
         * Project -> projectAddress -> id / Integer
         * Section -> sectionAddress -> Criss reference excel
         * Position -> positionAddress -> id / Integer
         *
         * --- Path
         * /vault/<Project>/<Section>/<Position>/
         */

        if ($args["sectionAddress"]=="logo"){

            $pointingDirectory = "/public/" . $args["sectionAddress"];

        } else {

            /**
             * This duality at ENDPOINT folders is because the necessity to upload
             * the content that comes from RFM into a provisional folder.
             * Then, if the task is accepted, we move the files form the provisional
             * to the core upload folder.
             */
            if(Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator()){

                $pointingDirectory = "/vault/" . $args["projectAddress"] . "/" . $args["sectionAddress"] . "/" . $args["positionAddress"];

            } else {

                $pointingDirectory = "/mysterybox/" . $args["projectAddress"] . "/" . $args["sectionAddress"] . "/" . $args["positionAddress"];

            }

        }

        if(Storage::makeDirectory($pointingDirectory)){

            $out = $pointingDirectory;

        } else {

            throw new DirectoryException("There was a problem creating the directory.");

        }

        return $out;

    }

    /**

     * Loads the image galleries of a project
     * @params $project_id, $position
     * @return \Illuminate\Http\Response
     */

    public function getGalleryImage($id_image){

        $img = Media::find($id_image);

        if ($img){

            $img_path = "../storage/app/".$img->path;
            if (!file_exists($img_path)) {
                $img_path = public_path($img->path);
            }

            $img_mime_type = $img->mime_type;


            $response = response()->make(\File::get($img_path));

            $response->header("Content-Type", $img_mime_type);

            return $response;

        } else {

            return abort(404);

        }
    }
    /**
     * Loads the logo of an entity
     * @param $position
     * @return \Illuminate\Http\Response
     */
    public function getEntityLogo($position){

        $logo = Media::where("section","par")
            ->where("position",$position)
            ->first();


        if ($logo){

            $logo_path = "../storage/app/".$logo->path;
            if (!file_exists($logo_path)) {
                $logo_path = public_path($logo->path);
            }
            $logo_mime_type = $logo->mime_type;


            $response = response()->make(\File::get($logo_path));

            $response->header("Content-Type", $logo_mime_type);

            return $response;

        } else {

            abort(404);

        }

    }


    public function getBannerImage($position){

        $img = Media::where("section","=","b")
            ->where("position","=",$position)
            ->first();

        if ($img){

            $img_path = "../storage/app/".$img->path;
            if (!file_exists($img_path)) {
                $img_path = public_path($img->path);
            }
            $img_mime_type = $img->mime_type;

            $response = response()->make(\File::get($img_path));

            $response->header("Content-Type", $img_mime_type);

            return $response;

        } else {

            abort(404);

        }
    }

    public function getSliderImage($position){

        $img = Media::where("section","=","s")
            ->where("position","=",$position)
            ->orderBy('id', 'desc')
            ->first();

        if ($img){

            // Get if uploaded or from gallery

            $file_array = explode('/',$img->path);

            if (in_array('vault',$file_array)){
                $img_path = "../storage/app".$img->path;
            } else {
                $img_path = "../public".$img->path;
            }

            $img_mime_type = $img->mime_type;


            $response = response()->make(\File::get($img_path));

            $response->header("Content-Type", $img_mime_type);

            return $response;

        } else {

            abort(404);

        }
    }

    public function getLogo(){

        $logo = Media::where("section","logo")
            ->first();


        if ($logo){

            $logo_path = "../storage/app".$logo->path;
            $logo_mime_type = $logo->mime_type;

        } else {

            $logo_path = "../public/img/logo.png";
            $logo_mime_type = "image/png";
        }

        $response = response()->make(\File::get($logo_path));

        $response->header("Content-Type", $logo_mime_type);

        return $response;

    }

    public function getMystery($id){

        $media = Mystery::where("id",$id)->first();

        if ($media){

            $media_path = "../storage/app".$media->path;
            $media_mime_type = $media->mime_type;

        } else {

            return abort('404');

        }

        $response = response()->make(\File::get($media_path));

        $response->header("Content-Type", $media_mime_type);

        return $response;

    }

    public function getMedia($id){

        $media = Media::where("id",$id)->first();

        if ($media){

            $media_path = "../storage/app".$media->path;
            $media_mime_type = $media->mime_type;

        } else {

            return abort('404');

        }

        switch ($media_mime_type) {
            case 'image/png':
            case 'image/jpeg':
            case 'application/pdf':
            case 'image/gif':
            case 'text/plain': return \response()->file($media_path); break;

            default: return \response()->download($media_path);
        }

    }

    public function getProjectFile($id){

        $media = Media::where("name",$id)->first();

        if ($media){

            $media_path = "../storage/app".$media->path;
            $media_mime_type = $media->mime_type;

        } else {

            return abort('404');

        }

        /*$response = response()->make(\File::get($media_path));

        $response->header("Content-Type", $media_mime_type);*/

        return \response()->download($media_path);

    }

    public function getAllProjectFiles($id){

        $project = Project::find($id);

        // Get available sections of the project
        $availableSections = $project->visibleSections();

        // Get all the files

        $files = Media::whereIn("section",$availableSections)->where("project",$id)->get();

        if (count($files)>0){

            \File::deleteDirectory("../storage/app/project/".$project->id);

            // Generate the zip name

            $zip_name = str_slug($project->name)."-".date("Y-m-d-H-i-s").".zip";

            // Check if dummy exists, if not, it creates it
            if(!file_exists("../storage/app/dummy")) {
                Storage::makeDirectory("/dummy");
            }

            foreach ($files as $file){

                $folder_name = $project->getSectorName($file->section);

                if(!file_exists("../storage/app/dummy/".$project->id."/".$folder_name)) {
                    Storage::makeDirectory("/dummy/".$project->id."/".$folder_name);
                }


                $old_name = "../storage/app".$file->path;
                $new_name = "../storage/app/dummy/".$project->id."/".$folder_name."/".$file->old_name;
                copy($old_name,$new_name);

            }

            $zipper = new \Chumper\Zipper\Zipper();
            $zipper->make(storage_path('app/project/'.$id."/".$zip_name))->add("../storage/app/dummy/".$project->id);

            /*$zipper = new \Chumper\Zipper\Zipper();
            $zipper->make(storage_path('app/project/'.$id."/".$zip_name));

            foreach ($files as $file){

                $folder_name = $project->getSectorName($file->section);
                $zipper->folder($folder_name)->add('../storage/app'.$file->path);

            }*/

            $zipper->close();

            $dbFile = new Media();
            $dbFile->name = $zip_name;
            $dbFile->old_name = $zip_name;
            $dbFile->extension = "zip";
            $dbFile->mime_type = "application/zip";
            $dbFile->project = $id;
            $dbFile->section = "all";
            $dbFile->path = '/project/'.$id."/".$zip_name;
            $dbFile->position = 0;
            $dbFile->uniqueToken = str_random(22);

            $dbFile->save();

            \File::deleteDirectory("../storage/app/dummy/".$project->id);

            // Get available sections of the project

            if ($dbFile){

                return ['name'=>$dbFile->name];


            } else {

                return false;

            }

        } else {

            return false;

        }



    }


}
