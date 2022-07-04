@extends('layouts.back')


@section('styles')
    <link rel="stylesheet" href="{{asset('back/plugins/documentation/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('back/plugins/documentation/css/prettify.css')}}">
@endsection

@section('content')

    <section>
        <div class="container">
            <ul class="docs-nav" id="menu-left">
                @if (!Auth::user()->isAuditor() && !Auth::user()->isIT())
                    <li><strong>Dashboard</strong></li>
                    <li><a href="#dashboard" class=" ">Dashboard</a></li>
                    <li class="separator"></li>
                @endif
                @if (Auth::user()->isAdmin() || Auth::user()->isIT())
                    <li><strong>Website management</strong></li>
                    <li><a href="#banners" class=" ">Banners</a></li>
                    <li><a href="#sliders" class=" ">Sliders</a></li>
                    <li><a href="#graphs" class=" ">Graphs</a></li>
                    <li><a href="#footer" class=" ">Footer</a></li>
                    <li class="separator"></li>
                @endif
                @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())

                    <li><strong>Projects</strong></li>
                    <li><a href="#project_main_page" class=" ">Main page</a></li>
                        @if (Auth::user()->isAdmin())
                            <li><a href="#project_import" class=" ">Import a project</a></li>

                        @endif
                            <li><a href="#project_basic_info" class=" ">Project basic information</a></li>
                    <li><a href="#project_milestones" class=" ">Project milestones</a></li>
                    <li><a href="#procurement_documents" class=" ">Procurement documents</a></li>
                    <li><a href="#parties" class=" ">Parties</a></li>
                    <li><a href="#financial_structure" class=" ">Financial structure</a></li>
                    <li><a href="#contract_documents" class=" ">Contract documents</a></li>
                    <li><a href="#risks" class=" ">Risks</a></li>
                    <li><a href="#government_support" class=" ">Government support</a></li>
                    <li><a href="#tariffs" class=" ">Tariffs</a></li>
                    <li><a href="#termination_provisions" class=" ">Termination provisions</a></li>
                    <li><a href="#renegotiations" class=" ">Renegotiations</a></li>
                    <li><a href="#key_performance_information" class=" ">Key performance information</a></li>
                    <li><a href="#performance_failures" class=" ">Performance failures</a></li>
                    <li><a href="#performance_assessments" class=" ">Performance assessments</a></li>
                    <li><a href="#project_gallery" class=" ">Project gallery</a></li>
                    <li><a href="#project_announcements" class=" ">Project announcements</a></li>
                    <li class="separator"></li>
                @endif
                @if (Auth::user()->isAdmin())
                    <li><strong>Role Management</strong></li>
                    <li><a href="#edit_users_section" class=" ">Users management</a></li>
                    <li><a href="#edit_roles" class=" ">Edit roles</a></li>
                    <li><a href="#deleted_users" class=" ">Deleted users</a></li>
                    <li class="separator"></li>
                    <li><strong>Communications Management</strong></li>
                    <li><a href="#notifications_management" class=" ">Notifications management</a></li>
                    <li><a href="#newsletter_subscribers" class=" ">Newsletter subscribers</a></li>
                            <li><a href="#general_announcements" class=" ">General announcements</a></li>
                        <li class="separator"></li>
                @endif
                @if (Auth::user()->isAdmin() || Auth::user()->isIT())
                    <li><strong>System Configuration</strong></li>
                    <li><a href="#general_settings" class=" ">General settings</a></li>
                    @if (Auth::user()->isAdmin())
                        <li><a href="#sections_to_disclose" class=" ">Sections to disclose</a></li>
                    @endif
                    <li class="separator"></li>
                @endif
                @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())
                    <li><strong>Tasks Management</strong></li>
                    <li><a href="#request_for_modification" class=" ">Request for modification</a></li>
                    @if (!Auth::user()->isDataEntry() && !Auth::user()->isProjectCoordinator())
                        <li><a href="#accept_a_task" class=" ">Accept or decline a task</a></li>
                        <li><a href="#edit_a_task" class=" ">Edit a task</a></li>
                        <li><a href="#delete_a_task" class=" ">Delete a task</a></li>
                    @endif
                    <li class="separator"></li>
                @endif
                @if (Auth::user()->isAdmin())
                    <li><strong>Entities</strong></li>
                    <li><a href="#add_new_entity" class=" ">Add new entity</a></li>
                    <li><a href="#existing_entities" class=" ">Existing entities</a></li>
                    <li class="separator"></li>
                @endif

                <li><strong>General Information</strong></li>
                @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())
                    <li><a href="#project_visibility" class=" ">Project visibility</a></li>
                @endif
                    @if (!Auth::user()->isAuditor())
                <li><a href="#search_module" class=" ">Search module</a></li>
                    @endif
                    @if (Auth::user()->isAdmin() || Auth::user()->isAuditor())
                        <li><a href="#activity_log" class=" ">Activity log</a></li>
                    @endif
                    @if (!Auth::user()->isAuditor() && !Auth::user()->isIT() && !Auth::user()->isViewOnly())
                        <li><a href="#elements_order" class=" ">Project elements order</a></li>

                        @endif
                    <li class="separator"></li>
            </ul>
            <div class="docs-content">
                <h2> Documentation</h2>
                @if (!Auth::user()->isAuditor() && !Auth::user()->isIT())
                <h3 id="dashboard"> Dashboard</h3>
                <p>The dashboard is the first page the user will see after logging into the platform. It is a summary of the platform status.</p>
                <p>The first row of the dashboard contains four boxes that show information about the number of projects, the incomplete tasks, the total number of users registered in the platform and the amount of newsletter subscribers.</p>
                <p>The second row shows the information of projects and pending tasks.</p>
                <p>On the left, there are the latest updated projects on the platform where the user can click on their names to easily access the project page.</p>
                <p>On the right, there is a “Pending Tasks” section where the user will find all the tasks to be completed.</p>
                <img src="/img/documentation/{{env('APP_NAME')}}/dashboard.jpg" class="responsive-img" />
                @endif
                @if (Auth::user()->isAdmin() || Auth::user()->isIT())

                    <h2> Website management</h2>
                    <p>This page of the backend allows the user to manage different sections on the frontend. Only the administrator will have access to this section.</p>

                    <h3 id="banners"> Banners</h3>
                    <p>The banners’ section provides the administrators with the ability to publish advertisements on the website. The recommended size of a banner is 900px width and 150px height.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/banners1.jpg" class="responsive-img" />
                    <h4> Add new banner</h4>
                    <p>To add a new banner the user has to click on “Add new banner” and fill the form. All the fields are mandatory.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/banners2.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="yBlyG-Mpj4A">
                            <div class="play-button"></div>
                        </div>
                    </div>
                    <h4> Existing banners</h4>
                    <p>In this section, the user can edit or delete the existing banners. Only one banner can be active at the same time. If the user activates any other banner, the previous one will be automatically inactivated.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/banners3.jpg" class="responsive-img" />
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="D7DYPow3qPI">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="sliders"> Sliders</h3>
                    <p>Sliders page will show latest or relevant news of selected projects. The recommended size for a slider image is 1200px width and 500px height.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/sliders1.jpg" class="responsive-img" />
                    <h4> Add new slider</h4>
                    <p>To add a new slider the user has to click the “Add new slider” button and choose the project on the form that will be opened. All the fields are mandatory, title and url will be automatically generated once the Administrator chooses the name of the project, images can be selected from the gallery or upload custom ones.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/sliders2.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="hIuFpDZlo4A">
                            <div class="play-button"></div>
                        </div>
                    </div>
                    <h4> Existing sliders</h4>
                    <p>In this section, the user can edit or delete existing sliders. Unlike banners, multiple sliders can be active at the same time and all of them will be shown in the website.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/sliders3.jpg" class="responsive-img" />
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="BB2jWHkrCwQ">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="graphs"> Graphs</h3>
                    <p>On this page, the user can manage the graphs being displayed on the homepage.</p>
                    <p>There are different graphs available in this section, and the user can decide their order by using the drag & drop system (simply move the graph with the mouse to the desired position)</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/graphs1.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="nTvSq8cOmxs">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="footer"> Footer</h3>
                    <p>In this section, the Administrator can manage the different parts of the website footer.</p>
                    <h4> About PPP</h4>
                    <p>In this subsection, the administrator can edit the “About PPP” section at the footer of every page on the website just by editing the “About PPP Section Title” field and the “About PPP section Content” field and by clicking on the “Save” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/about1.jpg" class="responsive-img" />
                    <h4> Contact information</h4>
                    <p>In this subsection, the administrator can edit the contact information that can be found on the footer of every page of the website.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/contact1.jpg" class="responsive-img" />
                    <h4> Social media</h4>
                    <p>In this subsection, the administrator can edit the social media icons that can be found at the footer of every page of the website.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/social1.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="vQ2NhEw5kgo">
                            <div class="play-button"></div>
                        </div>
                    </div>

                @endif

                @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())

                    <h2> Projects</h2>
                    <p>This section of the backend allows the user to add and manage the projects on the platform.</p>

                    <h3 id="project_main_page"> Main page</h3>
                    <p>This page allows the user to create a new project and manage the existing ones. The user can see three sections on this page:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/project1.jpg" class="responsive-img" />
                    <h4> Add new project</h4>
                    <p>In this section, the user can add a new blank project to the database. A popup appears when the “Add project” is clicked to enter the project name:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/project2.jpg" class="responsive-img" />
                    <p>If the user clicks the “Ok” button of the popup, the new project will be created and the page will redirect to the new project “Basic Project Information” page.</p>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="vDc7S4pvhv4">
                            <div class="play-button"></div>
                        </div>
                    </div>
                    <h4> Filters</h4>
                    <p>In this section, the user can check the phase, region and sector to filter the projects on the table below:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/filters1.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="6h8aiy8tvP4">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h4> Projects table</h4>
                    <p>In this section, a table with all the projects in the platform will appear. In each project row, the user can click two different buttons:</p>
                    <ul>
                        <li>Edit button: by clicking this button, the page is redirected to the “Basic Project Information” of the selected project.</li>
                        <li>Delete button: by clicking this button, a confirmation popup will show up in the page. If the user clicks “Ok”, the project will be deleted.</li>
                        <li>Visibility project button: by clicking at this switch button, the selected project will be hidden at the “frontend” of the website.</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/project5.jpg" class="responsive-img" />

                    @if (Auth::user()->isAdmin())
                        <h3 id="project_import"> Import a project</h3>
                        <p>In this section, the user can import a full project from an excel sheet. The excel sheet to be imported must follow the template provided at the “Import project” section.</p>
                        <p>Is it possible to access the “Import project” section by clicking the blue button named as “Import project” at the main project page.</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/project1.jpg" class="responsive-img" />
                        <p>At the “Import project” page, the user can select the excel file from its computer and start the import of the excel sheet by clicking at the blue button names as “Import”.</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/projectimport.jpg" class="responsive-img" />
                    @endif

                    <h3 id="project_basic_info"> Project basic information</h3>
                    <p>This page of the backend allows the user to manage the basic information of the project.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/basicinfo1.jpg" class="responsive-img" />
                    <p>The user can see two types of sections on this page:</p>
                    <h4>Main information section</h4>
                    <p>In this section, the user selects the essential information of the project.</p>
                    <h4>Main information, sector</h4>
                    <p>The user can select the sector of the project. Multi-selection is available.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/sector.jpg" class="responsive-img" />
                    <h4>Main information, region</h4>
                    <p>The user can select the region of the project. Multi selection is available.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/region.jpg" class="responsive-img" />
                    <h4>Main information, phase</h4>
                    <p>The user can select the phase of the project. Only one phase can be selected.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/phase.jpg" class="responsive-img" />
                    <h4>Main information, sponsoring agency</h4>
                    <p>The user can select the sponsoring agency of the project. Only one sponsoring agency can be selected.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/sponsoring.jpg" class="responsive-img" />
                    <h4>Main information, project value</h4>
                    <p>The user have to introduce the project value in million of US$ and the local currency.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/projectvalue.jpg" class="responsive-img" />
                    <h4>Main information, Open Contracting ID</h4>
                    <p>The OCID number will be automatically created when the user creates a new project. After that, the user can manually modify the OCID number but the system will check if the modified OCID is available.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/ocid.jpg" class="responsive-img" />
                    <h4>Main information, Section of Information</h4>
                    <p>In this section, the user can upload the project needs, the description of asset and services to be provided, the rationale for selecting the project for development as a PPP, the name and deliverables of Transaction Advisor, the Unsolicited project – Rationale and the Project summary document.</p>
                    <p>All these sections will present the same structure. The section title cannot be modified and the user will fill in the description and will upload documents related to the section.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/sectioninformation.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="pkmTKx39o4U">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="project_milestones"> Project milestones</h3>
                    <p>This page of the backend allows the user to add and manage the project milestones on the platform.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/milestone.jpg" class="responsive-img" />
                    <p>The user can find two sections on this page:</p>
                    <h4>Add new milestone</h4>
                    <p>In this section, the user can click to display the information to be filled to add a new milestone.</p>
                    <p>After clicking the button, a new form will appear with four fields:</p>
                    <ul>
                        <li>The “Milestone name” field where the user can add a “Name” for the milestone to be added. (This field is required).</li>
                        <li>The “Type of milestone” field where the user can select the type of milestone. (This field is required and “Milestone accomplished” is selected by default). Milestone accomplished is used for those milestones that happened already and Futures milestones refer to deadlines relative to procurement of the project.</li>
                        <li>The “Deadline” field where the user can select the date (This field is required).</li>
                        <li>The “Description” field where the user can add the description for the new milestone (This field is required).</li>
                    </ul>
                    <p>When all the required fields are filled, the user can save all the information by clicking on the “Save” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/addmilestone.jpg" class="responsive-img" />
                    <h4>Existing milestones</h4>
                    <p>In this section, the user can edit or delete a milestone.</p>
                    <p>Edit a milestone: to edit a milestone, the user must click on the milestone name to display the information. The information can be edited and saved by clicking on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/addmilestone.jpg" class="responsive-img" />
                    <p>Delete a milestone: to delete a milestone, the user must click on the delete button on the header of the milestone box:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/milestone3.jpg" class="responsive-img" />
                    <p>A confirmation popup  will show up in the page. If the user clicks “Delete”, the milestone will be deleted.</p>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="1y8xgI0XYzE">
                            <div class="play-button"></div>
                        </div>
                    </div>
                    <h3 id="procurement_documents"> Procurement documents</h3>
                    <p>This page allows the user to add and manage the procurement documents of the project.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/procurementdoc1.jpg" class="responsive-img" />
                    <p>There are two sections available on this page:</p>
                    <h4>Add procurement</h4>
                    <p>In this section, the user can add a procurement document by clicking on “Add procurement”.</p>
                    <p>After clicking the button, a new form will appear with three fields:</p>
                    <ul>
                        <li>The “Procurement name” field where the user can add a “Name” for the procurement document to be added. (This field is required)</li>
                        <li>The “Description” field where the user can add a short description for the procurement document. (This field is required)</li>
                        <li>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</li>
                    </ul>
                    <p>When all the required fields are filled, the user can save all the information by clicking on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/procurement2.jpg" class="responsive-img" />
                    <h4>Existing procurement documents</h4>
                    <p>In this section, the user can click to edit the information of a procurement document or to delete it.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/procurement3.jpg" class="responsive-img" />
                    <ul>
                        <li>To edit a “Procurement Document”, the user must fill the changes and click on the “Publish” button.</li>
                        <li>To delete a “Procurement Document”, the user must click on the delete button on the header of the procurement document box.</li>
                    </ul>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="1zTbLBudoJI">
                            <div class="play-button"></div>
                        </div>
                    </div>
                    <h3 id="parties"> Parties</h3>
                    <p>This page allows the user to add and manage project parties.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/parties.jpg" class="responsive-img" />
                    <p>The user can find three sections on this page:</p>
                    <h4>Add party</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/addparty.jpg" class="responsive-img" />
                    <p>In this section, the user can click to display the parties’ list. If the user selects a party and clicks the “Add party” button, it will be added to the project.</p>
                    <h4>Contracting authority</h4>
                    <p>In this section, the user can click to display the information of the Contracting Authority for the project. This information is read-only in this section, but can be modified in the “Basic Project Information” page.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/contractingauth.jpg" class="responsive-img" />
                    <h4>Private parties</h4>
                    <p>In this section, the user can click to display the information of the Private Parties for the project. This information is read-only in this section, but can be modified in the “Entities” page.</p>
                    <p>The user can click on the delete button to remove the party from the project. After clicking the button, a confirmation popup  will show up in the page. If the user clicks “Yes”, the party will be removed.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/privateparty.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="IrCY9D2OIlA">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="financial_structure"> Financial Structure</h3>
                    <p>This page allows the user to add and manage the project Financial Structure.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/financialstructure1.jpg" class="responsive-img" />
                    <p>There are three sections available on this page:</p>
                    <h4>Add financial structure</h4>
                    <p>In this section, the user can add a Financial Structure by clicking on “Add financial” button.</p>
                    <p>After clicking the button, a new form will appear with three fields:</p>
                    <ul>
                        <li>The “Financial name” field where the user can add a “Name” for the financial structure to be added. (This field is required)</li>
                        <li>The “Description” field where the user can add a short description for the financial structure. (This field is required)</li>
                        <li>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</li>
                    </ul>
                    <p>When all the required fields are filled, the user can save all the information by clicking on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/financialstructure2.jpg" class="responsive-img" />
                    <h4>Existing financial structure</h4>
                    <p>In this section, the user can click to edit the information of a financial structure or to delete it.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/financialstructure3.jpg" class="responsive-img" />
                    <ul>
                        <li>To edit “Financial Structure information”, the user must fill all the required fields with the changes to be uploaded and click on the “Publish” button.</li>
                        <li>To delete a “Financial Structure” information, the user must click on the delete button on the header of the financial structure box.</li>
                    </ul>
                    <h4>Financial structure summary</h4>
                    <p>In this section, the user will be able to see all the information previously filled in the “Financial Structure” section as a table.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/financialstructure4.jpg" class="responsive-img" />

                    <h3 id="contract_documents"> Contract Documents</h3>
                    <p>This page allows the user to add and manage the project Contract documents.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/cdocgh1.jpg" class="responsive-img" />
                    <p>There are two sections available on this page:</p>
                    <h4>Add contract documents</h4>
                    <p>In this section, the user can add a Contract documents by clicking on “Add group of documents”.</p>
                    <p>After clicking the button, a new form will appear with three fields:</p>
                    <ul>
                        <li>The “Documents group name” field where the user can add a “Name” for the document or group of documents to be added. (This field is required)</li>
                        <li>The “Description” field where the user can add a short description for the document or group of documents. (This field is required)</li>
                        <li>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</li>
                    </ul>
                    <p>When all the required fields are filled, the user can save all the information by clicking on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/cdocgh2.jpg" class="responsive-img" />
                    <h4>Existing contract documents</h4>
                    <p>In this section, the user can click to edit the information of a Contract document or to delete it.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/cdocgh3.jpg" class="responsive-img" />
                    <ul>
                        <li>To edit a “Contract document”, the user must fill the changes and click on the “Publish” button.</li>
                        <li>To delete a “Contract document”, the user must click on the delete button on the header of the contract document box.</li>
                    </ul>

                    <h3 id="environement_social"> Environmental and social impact assessment report</h3>
                    <p>This page allows the user to add and manage the project Environment and social impact assessment report.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/envsocgh1.jpg" class="responsive-img" />
                    <p>The “Description” field where the user can add a short description for the report. (This field is required)</p>
                    <p>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</p>
                    <p>To edit the “Environment and Social impact assessment report”, the user must fill the changes and click on the “Publish” button.</p>

                    <h3 id="risks"> Risks</h3>
                    <p>This page allows the user to add and manage the project Risks.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/risks1.jpg" class="responsive-img" />
                    <p>There are four sections available on this page:</p>
                    <h4>Add risk</h4>
                    <p>In this section, the user can add a Risk by clicking on “Add risk” button.</p>
                    <p>After clicking the button, a new form will appear with four fields:</p>
                    <ul>
                        <li>The “Type of risk” field where the user can add a type of risk. (This field is required)</li>
                        <li>The “Description” field where the user can add a short description for the financial structure. (This field is required)</li>
                        <li>The “Allocation” field where the user can select the risk allocation. (This field is required)</li>
                        <li>The “Mitigation” field where the user can add the mitigation information of the risk. (This field is required)</li>
                    </ul>
                    <p>When all the required fields are filled, the user can save all the information by clicking on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/risks2.jpg" class="responsive-img" />
                    <h4>Existing risks</h4>
                    <p>In this section, the user can click to edit the information of a risk or to delete it.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/risks3.jpg" class="responsive-img" />
                    <ul>
                        <li>To edit a “Risk”, the user must fill all the required fields with the changes to be uploaded and click on the “Publish” button.</li>
                        <li>To delete a “Risk”, the user must click on the delete button on the header of the risk box:</li>
                    </ul>
                    <h4>Risks documents</h4>
                    <p>In this section, the user will be able to upload all the files needed to complement all the project risk information by clicking on the “Add” button or by “Drag & Drop” the files.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/risks4.jpg" class="responsive-img" />
                    <h4>Risks summary</h4>
                    <p>In this section, the user will be able to see all the information previously filled in the “Risks” section as a table.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/risks5.jpg" class="responsive-img" />

                    <h3 id="government_support"> Government Support</h3>
                    <p>This page allows the user to add and manage the project Government Support.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gov.jpg" class="responsive-img" />
                    <p>The user can find two sections on this page:</p>
                    <h4>Add government support</h4>
                    <p>In this section, the user can click to display the information to be filled to add a new Government Support.</p>
                    <p>After clicking the button, a new form will appear with four fields:</p>
                    <ul>
                        <li>The “Government Support name” field where the user can add a “Name” for the Government Support to be added. (This field is required)</li>
                        <li>The “Government Support description” field where the user can add a “Description” for the Government Support to be added. (This field is required)</li>
                        <li>The “Help” field where the user can add the “Help” for the new milestone (This field is required)</li>
                        <li>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gov1.jpg" class="responsive-img" />
                    <h4>Existing government support</h4>
                    <p>In this section, the user can click to edit the information of a Government Support or delete it.</p>
                    <ul>
                        <li>To edit a Government Support, the user must fill the changes and click on the “Publish” button</li>
                        <li>To delete a Government Support, the user must click on the delete button on the header of the Government Support box</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gov2.jpg" class="responsive-img" />

                    <h3 id="tariffs"> Tariffs</h3>
                    <p>This page allows the user to add and manage the project Tariffs.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/tariffs.jpg" class="responsive-img" />
                    <p>The user can find two sections on this page:</p>
                    <h4>Add tariff</h4>
                    <p>In this section, the user can click to display the information to be filled to add a new tariff.</p>
                    <p>After clicking the button, a new form will appear with three fields:</p>
                    <ul>
                        <li>The “Tariff name” field where the user can add a “Name” for the Tariff to be added. (This field is required).</li>
                        <li>The “Tariff description” field where the user can add a “Description” for the Tariff to be added. (This field is required).</li>
                        <li>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</li>
                    </ul>
                    <p>To save the new tariff, the user must click on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/tariffs2.jpg" class="responsive-img" />
                    <h4>Existing tariffs</h4>
                    <p>In this section, the user can click to edit the information of an existing tariff or delete it.</p>
                    <ul>
                        <li>To edit a tariff, the user must fill the changes and click on the “Publish” button.</li>
                        <li>To delete a tariff, the user must click on the delete button on the header of the tariff box.</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/tariffs3.jpg" class="responsive-img" />

                    <h3 id="termination_provisions"> Termination Provisions</h3>
                    <p>This page allows the user to add and manage the project Termination Provisions.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/termination.jpg" class="responsive-img" />
                    <p>The user can find three sections on this page:</p>
                    <h4>Add termination provisions</h4>
                    <p>In this section, the user can click to display the information to be filled to add a new termination provisions.</p>
                    <p>After clicking the button, a new form will appear with five fields:</p>
                    <ul>
                        <li>The “Party” field where the user can select a Party for the Termination Provisions to be added. (This field is required).</li>
                        <li>The “Termination Provisions name” field where the user can add a “Name” for the Termination Provisions to be added. (This field is required).</li>
                        <li>The “Termination Provisions description” field where the user can add a “Description” for the Termination Provisions to be added. (This field is required).</li>
                        <li>The “Termination Provisions payment” field where the user can add a “Description” for the Termination Provisions to be added. (This field is required).</li>
                        <li>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</li>
                    </ul>
                    <p>To save the new termination provisions, the user must click on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/termination2.jpg" class="responsive-img" />
                    <h4>Existing termination provisions</h4>
                    <p>In this section, the user can click to edit the information of an existing termination provisions or delete it.</p>
                    <ul>
                        <li>To edit a termination provision, the user must fill the changes and click on the “Publish” button.</li>
                        <li>To delete a termination provision, the user must click on the delete button on the header of the termination provision box.</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/termination3.jpg" class="responsive-img" />
                    <h4>Termination provisions summary</h4>
                    <p>In this section, the user can read a summary of all the termination provisions in the project in table format:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/termination4.jpg" class="responsive-img" />

                    <h3 id="renegotiations"> Renegotiations</h3>
                    <p>This page allows the user to add and manage the project Renegotiations.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/renegotiations.jpg" class="responsive-img" />
                    <p>The user can find three sections on this page:</p>
                    <h4>Add renegotiation</h4>
                    <p>In this section, the user can click to display the information to be filled to add a new renegotiation.</p>
                    <p>After clicking the button, a new form will appear with two fields:</p>
                    <ul>
                        <li>The “Renegotiation name” field where the user can add a “Name” for the Renegotiation to be added. (This field is required).</li>
                        <li>The “Renegotiation description” field where the user can add a “Description” for the Renegotiation to be added. (This field is required).</li>
                    </ul>
                    <p>To save the new renegotiation, the user must click on the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/renegotiations2.jpg" class="responsive-img" />
                    <h4>Existing renegotiation</h4>
                    <p>In this section, the user can click to edit the information of an existing renegotiation or delete it.</p>
                    <ul>
                        <li>To edit a renegotiation, the user must fill the changes and click on the “Publish” button.</li>
                        <li>To delete a renegotiation, the user must click on the delete button on the header of the renegotiation box.</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/renegotiations3.jpg" class="responsive-img" />
                    <h4>Renegotiation documents</h4>
                    <p>In this section, the user can upload or delete the renegotiation documents.</p>
                    <ul>
                        <li>To add a document, the user must click on the “Add” button and select the document from the user’s computer.</li>
                        <li>To delete a document, the user must click on the delete button on the document box.</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/renegotiations4.jpg" class="responsive-img" />

                    <h3 id="key_performance_information"> Key Performance Indicators</h3>
                    <p>The following section allows to the user to create, edit and delete Key Performance Indicators.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/kpi1.jpg" class="responsive-img" />
                    <h4>Create a new KPI</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/kpi2.jpg" class="responsive-img" />
                    <h4>KPI Type</h4>
                    <p>The KPI field is required. The combination of this field and the year field has to be unique.</p>
                    <p>If the KPI type is not available in the select box, you can create a new KPI type by clicking on the “Add new KPI type” button. A modal will appear with two fields:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/kpi3.jpg" class="responsive-img" />
                    <ul>
                        <li>The “Name” field where you can add a name for the new KPI type.</li>
                        <li>The “Unit” field where you can set the unit for the new KPI type.</li>
                    </ul>
                    <h4>Year</h4>
                    <p>The year field is required. The combination of this field and the KPI Type field has to be unique.</p>
                    <h4>Target</h4>
                    <p>The target field is required.</p>
                    <h4>Achievement</h4>
                    <p>The achievement field is optional.</p>
                    <p>Be aware that if a duplicated key performance indicator is saved, the platform will throw a validation message.</p>
                    <p>To create a new key performance indicator, fill out all the fields and click on the “Save” button.</p>
                    <h4>Edit KPI</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/kpi4.jpg" class="responsive-img" />
                    <p>There’s an information popup that gives tips for modifying the data.</p>
                    <p>For editing a key performance indicator, click on the record and modify the data. Is possible to edit multiple fields at once. Finally, when the editing process has been finished, click on the “Publish” button.</p>
                    <h4>Delete key performance indicator</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/kpi5.jpg" class="responsive-img" />
                    <p>For deleting a key performance indicator, click on the “delete” button, then confirm to proceed and the whole row will be deleted.</p>
                    <p>If a key performance indicator is modified with no data, the record will be automatically deleted when is saved.</p>
                    <h4>Tables</h4>
                    <p>For every five years, a new table will be generated. The information will be order descending by year.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/kpi6.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="Jne5K6VF75I">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="performance_failures"> Performance Failures</h3>
                    <p>The following section allows the user to create, edit and delete performance failures.</p>
                    <h4>Create a new performance failure</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/performance1.jpg" class="responsive-img" />
                    <h4>Title</h4>
                    <p>The title field is required.</p>
                    <h4>Category of failure</h4>
                    <p>The category of failure field is required and has to be unique.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/failure1.jpg" class="responsive-img" />
                    <p>To create a new type of key performance indicator, click on the “Add new category of failure” button, then fill out all the fields and finally click on “save”.</p>
                    <h4>Number of events</h4>
                    <p>The number of events field is required.</p>
                    <h4>Penalty or abatement provided in contract</h4>
                    <p>The penalty or abatement field is required.</p>
                    <h4>Penalty or abatement imposed</h4>
                    <p>The penalty or abatement imposed field is optional.</p>
                    <h4>Penalty paid or abatement imposed</h4>
                    <p>The penalty paid or abatement imposed field (Yes/No).</p>
                    <p>To create a new performance failure, fill out all the fields and click on the “Publish” button.</p>
                    <h4>Edit performance failure</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/failure2.jpg" class="responsive-img" />
                    <p>To edit an existing performance failure, edit the information, finally click on the “Publish” button.</p>
                    <h4>Delete performance failure</h4>
                    <p>To delete an existing performance failure, press on the “Delete” button and finally confirm to proceed.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/failure3.jpg" class="responsive-img" />
                    <h4>Information table</h4>
                    <p>Find below the performance failures table.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/failure4.jpg" class="responsive-img" />

                    <h3 id="performance_assessments"> Performance Assessments</h3>
                    <p>The following section allows to the user to create, edit and delete performance assessments.</p>
                    <h4>Create performance assessment</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/performanceassessment1.jpg" class="responsive-img" />
                    <h4>Title</h4>
                    <p>The title field is required.</p>
                    <h4>Description</h4>
                    <p>The description field is required.</p>
                    <p>To create a new performance assessment, fill out all the fields and click on the “Publish” button.</p>
                    <h4>Edit performance assessment</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/performanceassessment2.jpg" class="responsive-img" />
                    <p>To edit an existing performance assessment, edit the information and finally click on the “Publish” button.</p>
                    <h4>Delete performance assessment</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/performanceassessment3.jpg" class="responsive-img" />
                    <p>To delete an existing performance assessment, press on the “Delete” button and finally confirm to proceed.</p>

                    <h3 id="project_gallery"> Project Gallery</h3>
                    <p>In this section, the user can upload and manage all the images of a project. The user can upload images located at their computer by clicking on the “Click or drop picture here” area or by selecting a default image from the gallery by clicking on “Insert picture from gallery” area.</p>
                    <p>Bellow these options, the user can find all the project active images and they will be able to delete them by clicking on the “X” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gallery1.jpg" class="responsive-img" />
                    <h4>Upload image</h4>
                    <p>To upload an image, the user can drag and drop the image in the box or click on it to browse from its computer. Uploaded images can be deleted by clicking on the button located at the bottom right corner of the thumbnail.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gallery2.jpg" class="responsive-img" />
                    <h4>Insert picture</h4>
                    <p>When the user decided to insert a picture from gallery it will appear a pop up with the images separated by sector. The user will select the image and click on the Select button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gallery3.jpg" class="responsive-img" />
                    <p>When the item is selected, the user can delete or add it to the project.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gallery4.jpg" class="responsive-img" />
                    <h4>Gallery of the project</h4>
                    <p>In this section, the user will see all the pictures of the project and delete any of them if necessary.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gallery5.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="pVUPjuDBhqM">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="project_announcements"> Project Announcements</h3>
                    <p>This section allows the user to show different relevant information related to the project.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/announcement1.jpg" class="responsive-img" />
                    <p>The page will show a list of announcements where the user can edit them.</p>
                    <h4>Add new announcement</h4>
                    <p>In this section, the user can add a new Announcement by clicking on “Add announcement”.</p>
                    <p>After clicking the button, a new form will appear with three fields:</p>
                    <ul>
                        <li>The “Announcement name” field where the user can add a “Name” for the announcement to be added. (This field is required)</li>
                        <li>The “Description” field where the user can add a short description for the announcement. (This field is required)</li>
                        <li>The file upload field where the user can upload a file or multiple files by clicking on the “Add” button or by “Drag & Drop” the files. (Optional field)</li>
                    </ul>
                    <p>When all the required fields are filled, the user can save all the information by clicking on the “Add announcement” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/announcement2.jpg" class="responsive-img" />
                    <h4>Existing announcements</h4>
                    <p>In this section, the user can click to edit the information of an Announcement or to delete it.</p>
                    <ul>
                        <li>To edit an “Announcement”, the user must fill the changes and click on the “Publish” button.</li>
                        <li>To delete a “Announcement”, the user must click on the delete button on the header of the announcement box.</li>
                    </ul>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="0jSu7fJIdww">
                            <div class="play-button"></div>
                        </div>
                    </div>

                @endif

                @if (Auth::user()->isAdmin())

                    <h2>Role Management</h2>
                    <p>The Role management section allows the user to manage the information regarding to the users and user roles registered. Only the users with the administrator role have the capability of managing the following sections.</p>
                    <h3 id="edit_users_section">Users management</h3>
                    <p>Edit users section manages the information related to registered users. The following section has the functionality of creating, editing and deleting users.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user1.jpg" class="responsive-img" />
                    <h4>General</h4>
                    <h5>Email</h5>
                    <p>The user will use the email to log in and it needs to be unique. The section will automatically confirm if the email has been taken or not.</p>
                    <h5>Telephone</h5>
                    <p>The telephone by default isn’t required. If a telephone number is typed, the system will automatically confirm that the number of telephone digits match the chosen country dialing standards.</p>
                    <h5>Role</h5>
                    <p>The role is required, depending on the chosen role, the permissions will be selected.</p>
                    <h5>Types of roles:</h5>
                    <p>The following roles are the main roles of the platform.</p>
                    <ul>
                        <li>Administrator</li>
                        <li>View Only</li>
                        <li>Data Entry</li>
                        <li>Project Coordinator</li>
                        <li>IT User</li>
                        <li>Internal Auditor</li>
                    </ul>
                    <h5>Date added</h5>
                    <p>The date added is generated automatically when a new user is registered.</p>
                    <h5>Permissions</h5>
                    <p>The user permissions are required. For choosing permissions, a role has to be selected.</p>
                    <ul>
                        <li>Administrator Role: The permissions will be pre-selected and disabled by default.</li>
                        <li>Other roles: The permissions can be customized.</li>
                    </ul>
                    <p>If permissions haven't been chosen, the process of creating a new user can't proceed.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user2.jpg" class="responsive-img" />
                    <h5>Projects</h5>
                    <p>At least one project is required. The new user will only have access to the chosen projects.</p>
                    <p>For selecting a project, click on “Begin typing”, next type the name of the project to start searching it, then select the projects that will be assigned to the user.</p>
                    <p>The example below shows how to select projects.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user3.jpg" class="responsive-img" />
                    <p>For unselecting projects, click on a selected project.</p>
                    <h5>Sections</h5>
                    <p>At least one section is required. The new user will only have access to the chosen sections.</p>
                    <p>The example bellow shows selected sections.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user4.jpg" class="responsive-img" />
                    <h5>Password</h5>
                    <p>The password is generated randomly. The password length must be at least eight characters. An email is sent to the new user with the account information.</p>
                    <p>The example bellow shows the welcome email that the user receives.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user5.jpg" class="responsive-img" />
                    <h5>Comment (delete user)</h5>
                    <p>The comment of why a user is deleted is required. The minimum number of characters is between 10 and above. In this field, the reasons behind the deletion are explained.</p>
                    <h5>Assigned to (delete user)</h5>
                    <p>The “assigned to” field is required when a user is deleted. The deleted user associated projects will be assigned to the selected user.</p>
                    <h4>Create user</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user6.jpg" class="responsive-img" />
                    <h5>Steps</h5>
                    <ul>
                        <li>Fill out all fields (name, email, entity, role, telephone (optional)).</li>
                        <li>Choose user permissions (click on permissions button).</li>
                        <img src="/img/documentation/{{env('APP_NAME')}}/user7.jpg" class="responsive-img" />
                        <li>Click on “Add User”.</li>
                        <li>Confirm to proceed.</li>
                        <li>A success message will be shown.</li>
                    </ul>
                    <h4>Edit user</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user8.jpg" class="responsive-img" />
                    <h5>Steps</h5>
                    <ul>
                        <li>Click on the user record to modify it.</li>
                        <li>A popup with the user information will be shown.</li>
                        <img src="/img/documentation/{{env('APP_NAME')}}/user9.jpg" class="responsive-img" />
                        <li>Edit the user information.</li>
                        <li>Click on “Save”.</li>
                        <li>Confirm to proceed.</li>
                    </ul>
                    <h4>Delete user</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user10.jpg" class="responsive-img" />
                    <h5>Steps</h5>
                    <ul>
                        <li>Click on the user record to delete it.</li>
                        <li>A popup will be shown.</li>
                        <img src="/img/documentation/{{env('APP_NAME')}}/user11.jpg" class="responsive-img" />
                        <li>Fill out all the fields.</li>
                        <li>Click on delete user.</li>
                        <li>Confirm to proceed.</li>
                        <li>A success message will be shown.</li>
                    </ul>
                    <h3 id="edit_roles">Edit Roles</h3>
                    <p>Edit roles section manages the information related to user roles. The following section has the functionality of creating and editing roles.</p>
                    <h4>General</h4>
                    <h5>Role title</h5>
                    <p>The role title field is required.</p>
                    <h5>Account similar to</h5>
                    <p>The account similar to field is required. The functionality of the main chosen role will be equal as the new role.</p>
                    <h5>Description</h5>
                    <p>The description field is required.</p>
                    <h4>Create role</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user12.jpg" class="responsive-img" />
                    <h5>Steps</h5>
                    <ul>
                        <li>Fill out all the fields.</li>
                        <li>Click on save.</li>
                        <li>A success message will be shown.</li>
                    </ul>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="F1O3yPniK_w">
                            <div class="play-button"></div>
                        </div>
                    </div>
                    <h4>Edit role</h4>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user13.jpg" class="responsive-img" />
                    <h5>Steps</h5>
                    <ul>
                        <li>Click on the role record to modify it.</li>
                        <li>Edit the role information.</li>
                        <li>Click on “Save”.</li>
                    </ul>
                    <h4>Delete role</h4>
                    <p>In the following sections, the main roles can't be deleted.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user14.jpg" class="responsive-img" />
                    <h5>Steps</h5>
                    <ul>
                        <li>Click on the role record to delete it.</li>
                        <li>Confirm proceed.</li>
                        <li>A success message will be shown.</li>
                    </ul>
                    <h3 id="deleted_users">Deleted Users</h3>
                    <p>Deleted user section preserves records of the deleted users.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user15.jpg" class="responsive-img" />
                    <h2>Communications Management</h2>
                    <p>This page of the backend allows the administrator of the website to send notifications to the users in the platform and manage the newsletter subscriptions.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user16.jpg" class="responsive-img" />
                    <p>The user can see two sections on this page:</p>
                    <h3 id="notifications_management">Notifications Management</h3>
                    <p>In this section, the user can send a mail notification to a user, a group of users or to specific project users. To send a notification, the user must follow the next steps:</p>
                    <ul>
                        <li>The user must select to send the notification to the users with specific roles or to specific users</li>
                        <img src="/img/documentation/{{env('APP_NAME')}}/notificationsmanagement.jpg" class="responsive-img" />
                        <ul>
                            <li>Roles. In this dropdown, the user can select a specific role. The users with the role/s selected will receive the notification. The red button clears the selection and displays again the user dropdown</li>
                            <img src="/img/documentation/{{env('APP_NAME')}}/user18.jpg" class="responsive-img" />
                            <li>b.	Users: In this dropdown, the user can search the users by name. The users selected will receive the notification. The red button clears the selection and displays again the role dropdown:</li>
                        </ul>
                        <li>When the user selects who will receive the notification, the user must fill the notification information and then submit it</li>
                        <img src="/img/documentation/{{env('APP_NAME')}}/user19.jpg" class="responsive-img" />
                    </ul>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="8RTD6lQpqUw">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h3 id="newsletter_subscribers">Newsletter Subscribers</h3>
                    <p>In this section, the user can view and delete the newsletter subscribers:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/user20.jpg" class="responsive-img" />
                    <p>The user can delete subscribers one by one by clicking the delete button or multiple at once by checking the subscribers and clicking the “Delete subscribers” button on the bottom of the table. A confirmation popup will show up in the page. If the user confirms, the subscribers will be deleted.</p>
                        <h3 id="general_announcements">General announcements</h3>
                        <p>This page of the backend allows the user to add and manage the general announcements on the platform.</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/ga1.jpg" class="responsive-img" />
                        <h4>“Add a new announcement” Section</h4>
                        <p>In this section, the user can enter the information of the general announcement:</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/ga2.jpg" class="responsive-img" />
                        <ul>
                            <li>The “Announcement Title” field where the user can add a “Title” for the announcement to be added. (This field is required).</li>
                            <li>The “Announcement Description” field where the user can add the main information of the announcement. (This field is required).</li>
                            <li>The “Announcement Documents” field where the user can upload documents to the announcement.</li>
                        </ul>
                        <h4>“Edit an announcement” Section</h4>
                        <p>In order to edit an announcement, the user has to click the “Edit announcement” button on the announcements table. After that, the page will be redirected to a section where the user can edit the announcement fields.</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/ga3.jpg" class="responsive-img" />
                        <h4>“Delete an announcement” Section</h4>
                        <p>In order to delete an announcement, the user has to click the “Delete announcement” button on the announcements table. After that, a confirmation popup will appear before deleting the announcement.</p>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="hHeygErslQU">
                            <div class="play-button"></div>
                        </div>
                    </div>
                @endif

                @if (Auth::user()->isAdmin() || Auth::user()->isIT())

                    <h2>System Configuration</h2>
                    <h3 id="general_settings">General Settings</h3>
                    <p>General settings page has 6 different sections:</p>
                    <ul>
                        <li>Styling</li>
                        <li>Logo</li>
                        <li>Navigation</li>
                        <li>OCID API activation</li>
                        <li>Database backup</li>
                        <li>Platform currency</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf1.jpg" class="responsive-img" />
                    <h4>Styling section</h4>
                    <p>This section allows to create a custom theme and the possibility to change between them. Once the new theme is selected from the dropdown menu, the user can activate the theme by clicking at the blue button named as “Activate theme”.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf2.jpg" class="responsive-img" />
                    <p>You can customize the following elements:</p>
                    <ul>
                        <li>
                            Colors:
                            <ul>
                                <li>Primary color.</li>
                                <li>Secondary color.</li>
                            </ul>
                        </li>
                        <li>
                            Titles:
                            <ul>
                                <li>Font family.</li>
                                <li>Font size.</li>
                                <li>Letter spacing.</li>
                            </ul>
                        </li>
                        <li>
                            Body:
                            <ul>
                                <li>Font family.</li>
                                <li>Font size.</li>
                                <li>Letter spacing.</li>
                                <li>Line height.</li>
                                <li>Spacing for paragraphs.</li>
                            </ul>
                        </li>
                    </ul>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="W98udAg4jK8">
                            <div class="play-button"></div>
                        </div>
                    </div>
                    <h4>Logo section</h4>
                    <p>In this section, a new logo can be uploaded for the platform if needed, drop the logo image into the red box.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf3.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="MiUuH9omZbg">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    <h4>Navigation section</h4>
                    <p>In this section you can add more options to the navigation bar.</p>
                    <ul>
                        <li>Click on “Add item” button.</li>
                        <img src="/img/documentation/{{env('APP_NAME')}}/conf4.jpg" class="responsive-img" />
                        <li>Enter item’s name.</li>
                        <li>Enter item’s URL.</li>
                        <li>Click “Save” button.</li>
                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf5.jpg" class="responsive-img" />
                    <p>The result can be seen in the main page. The new item will appear in the navigation bar next to the default items.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf6.jpg" class="responsive-img" />
                    <h4>OCID API activation section</h4>
                    <p>This section allows the Administrator to activate or deactivate the OCID API of the platform.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf7.jpg" class="responsive-img" />
                    <h4>Database backup section</h4>
                    <p>This section allows the Administrator to make a backup of the platform.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf8.jpg" class="responsive-img" />
                    <h4>Currency section</h4>
                    <p>This section allows the Administrator to change the currency of the platform.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/conf9.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="sKy62Gtiqqs">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    @if (Auth::user()->isAdmin())
                        <h3 id="sections_to_disclose">Sections to Disclose</h3>
                        <p>In this section, the user can change the visibility of the section for the Backend and Frontend</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/conf10.jpg" class="responsive-img" />
                        <p>To change the visibility of a section, the user must click on the checkbox and press the “Save changes” button.</p>
                        <div class="video-wrapper">
                            <div class="youtube" data-embed="FB6hv-CHAcU">
                                <div class="play-button"></div>
                            </div>
                        </div>
                    @endif
                @endif

                @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())

                    <h2>Tasks Management</h2>
                    <p>This page of the backend allows the user to manage the tasks of the platform.</p>
                    <h3 id="request_for_modification">Request for modification</h3>
                    <p>In order to edit information, a user with the Data Entry or Project Coordinator roles have to submit a Request for Modification.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/task1.jpg" class="responsive-img" />
                    <p>When the “Request” button is clicked, the user will make the changes on the project and will fill a field with the reason for doing the Request for modification:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/task2.jpg" class="responsive-img" />
                    <p>The Administrator will receive a confirmation email for the Request for Modification and a new task will be generated. </p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/task3.jpg" class="responsive-img" />
                    <p>Also, the user will receive a confirmation email.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/task4.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="XbgmzuId7NI">
                            <div class="play-button"></div>
                        </div>
                    </div>

                    @if (!Auth::user()->isDataEntry() && !Auth::user()->isProjectCoordinator())

                        <h3 id="accept_a_task">Accept or decline a task</h3>
                        <p>After a task is created, the Administrator must accept or decline it. First, the administrator will see the changes provided by the user.</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/task7.jpg" class="responsive-img" />
                        <p>To accept or decline a task the administrator must click in one of the buttons as indicated below:</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/task8.jpg" class="responsive-img" />
                        <p>Once the task is accepted, the changes provided by the user will appear.</p>

                        <h3 id="edit_a_task">Edit a task</h3>
                        <p>If at some point of time, the Administrator needs to edit a task, he can always do this by pressing the “Edit” button and continue from there. Only task name can be changed.</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/task9.jpg" class="responsive-img" />

                        <div class="video-wrapper">
                            <div class="youtube" data-embed="PC0sjG8fuX0">
                                <div class="play-button"></div>
                            </div>
                        </div>

                        <h3 id="delete_a_task">Delete a task</h3>
                        <p>The Administrator can delete the task.</p>
                        <img src="/img/documentation/{{env('APP_NAME')}}/task10.jpg" class="responsive-img" />
                        <p>When a task is deleted, the user will receive a confirmation email.</p>
                        <div class="video-wrapper">
                            <div class="youtube" data-embed="BnwKbzQ4rHE">
                                <div class="play-button"></div>
                            </div>
                        </div>
                    @endif
                @endif
                @if (Auth::user()->isAdmin())

                    <h2>Entities</h2>
                    <p>This page of the backend allows the user to add and manage the entities on the platform.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/task11.jpg" class="responsive-img" />
                    <p>The user can see two sections on this page:</p>
                    <h3 id="add_new_entity">Add new entity</h3>
                    <p>In this section, the user can click to display the information to be filled to add a new entity:</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/ent1.jpg" class="responsive-img" />
                    <ul>
                        <li>Entity basic information: the user can enter the name, representative, address, telephone, fax, e-mail and description of the new entity.</li>
                        <li>Logo: the user can upload here the logo of the entity.</li>
                        <li>Useful links: the user can add links to the website and social media of the entity.</li>
                    </ul>
                    <p>To save the new entity, the user must click on the "Publish" button.</p>
                    <h3 id="existing_entities">Existing entities</h3>
                    <p>In this section, the user can edit or delete an entity.</p>
                    <p>To edit an entity, the user must click on the entity name to display the information. The information can be edited and saved by clicking the “Publish” button.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/ent2.jpg" class="responsive-img" />
                    <p>To delete an entity, the user must click on the delete button on the header of the entity box.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/ent3.jpg" class="responsive-img" />
                    <p>A confirmation popup  will show up in the page. If the user clicks “Delete”, the entity will be deleted.</p>
                @endif
                <h2>General Information</h2>
                @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())
                    <h3 id="project_visibility">Project visibility</h3>
                    <p>In order to change the visibility of the project section in the Frontend, the user must click on the switch placed on each page below the project menu.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gen1.jpg" class="responsive-img" />
                    <p>After clicking the switch, a confirmation popup will appear and the visibility will be changed.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gen2.jpg" class="responsive-img" />
                    <img src="/img/documentation/{{env('APP_NAME')}}/gen3.jpg" class="responsive-img" />
                    <p>Note: in projects subsections (for example Financial Structure inside Contract information), the first switch controls the visibility of the whole main section (in this case Contract information) and the second switch controls the visibility of the section the user is in (in this case Financial Structure).</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gen4.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="7ETI39ne6Ps">
                            <div class="play-button"></div>
                        </div>
                    </div>

                @endif
                @if (!Auth::user()->isAuditor())
                <h3 id="search_module">Search module</h3>
                <p>At the top left position of every page at the backend, there is a search box where the user will be able to search at any project.</p>
                <img src="/img/documentation/{{env('APP_NAME')}}/gen5.jpg" class="responsive-img" />
                <p>By clicking inside the search box, a new section will appear where the user can search anything inside every project.</p>
                <img src="/img/documentation/{{env('APP_NAME')}}/gen6.jpg" class="responsive-img" />
                <p>After searching, the module will return every project where the module found a match with the word or phrase to search and the locations of the information.</p>
                <img src="/img/documentation/{{env('APP_NAME')}}/gen7.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="t-Mn931mo7I">
                            <div class="play-button"></div>
                        </div>
                    </div>

                @endif
                @if (Auth::user()->isAdmin() || Auth::user()->isAuditor())
                    <h3 id="activity_log">Activity Log</h3>
                    <p>This section is the only one where the Internal Auditor (and Administrator) can enter after log in the backend.</p>
                    <img src="/img/documentation/{{env('APP_NAME')}}/gen8.jpg" class="responsive-img" />
                    <p>In this section, the user can see every action taken by other users in detail such as the creation of new projects, modifications at specific data and even the visibility changes under projects or full sections of the website, draft system included.</p>
                    <p>The user will be also able to filter the results and download the log in different file formats such as csv, excel or pdf.</p>
                    <div class="video-wrapper">
                        <div class="youtube" data-embed="87A8fu-gr78">
                            <div class="play-button"></div>
                        </div>
                    </div>
                @endif
                @if (!Auth::user()->isAuditor() && !Auth::user()->isIT() && !Auth::user()->isViewOnly())
                    <h3 id="elements_order">Project elements order</h3>
                    <ul>
                        <li>Procurement documents</li>
                        <li>Financial structure</li>
                        <li>Contract documents</li>
                        <li>Risks</li>
                        <li>Government support</li>
                        <li>Tariffs</li>
                        <li>Termination provisions</li>
                        <li>Renegotiations</li>
                        <li>Performance failures</li>
                        <li>Performance assessments</li>

                    </ul>
                    <img src="/img/documentation/{{env('APP_NAME')}}/orderdrag.jpg" class="responsive-img" />

                    <div class="video-wrapper">
                        <div class="youtube" data-embed="Qhpv7_mjDNg">
                            <div class="play-button"></div>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </section>

@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('back/plugins/documentation/js/prettify/prettify.js')}}"></script>
    <script src="{{asset('back/plugins/documentation/js/layout.js')}}"></script>
    <script src="{{asset('back/plugins/documentation/js/jquery.localscroll-1.2.7.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/documentation/js/jquery.scrollTo-1.4.3.1.js')}}" type="text/javascript"></script>

    <script>

        ( function() {

            var youtube = document.querySelectorAll( ".youtube" );

            for (var i = 0; i < youtube.length; i++) {

                var source = "https://img.youtube.com/vi/"+ youtube[i].dataset.embed +"/sddefault.jpg";

                var image = new Image();
                image.src = source;
                image.addEventListener( "load", function() {
                    youtube[ i ].appendChild( image );
                }( i ) );

                youtube[i].addEventListener( "click", function() {

                    var iframe = document.createElement( "iframe" );

                    iframe.setAttribute( "frameborder", "0" );
                    iframe.setAttribute( "allowfullscreen", "" );
                    iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=1" );

                    this.innerHTML = "";
                    this.appendChild( iframe );
                } );
            };

        } )();

    </script>

@endsection