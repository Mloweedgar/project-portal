<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>{{ env('APP_TITLE') }} - API Documentation</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!-- Global CSS -->
    <link rel="stylesheet" href="../docs/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="../docs/plugins/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../docs/plugins/prism/prism.css">
    <link rel="stylesheet" href="../docs/plugins/elegant_font/css/style.css">

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="../docs/css/styles.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="body-blue">
<div class="page-wrapper">
    <!-- ******Header****** -->
    <header id="header" class="header">
        <div class="container">
            <div class="branding">
                <h1 class="logo">
                    <a href="/api/documentation">
                        <span aria-hidden="true" class="icon_documents_alt icon"></span>
                        <span class="text-highlight">API</span> <span class="text-bold">DOCUMENTATION</span>
                    </a>
                </h1>
            </div><!--//branding-->
            <ol class="breadcrumb">
                <li><i class="fa fa-clock-o"></i> Last updated: {{ env('API_LAST_UPDATE') }}</li>
            </ol>
        </div><!--//container-->
    </header><!--//header-->
    <div class="doc-wrapper">
        <div class="container">
            <div class="doc-body">
                <div class="doc-content">
                    <div class="content-inner">
                        <section id="introduction-section" class="doc-section">
                            <h2 class="section-title">Introduction</h2>
                            <div class="section-block">
                                <p>
                                    The {{ env('APP_TITLE') }} <a href="https://en.wikipedia.org/wiki/Representational_state_transfer">REST</a> API provides functionality for retrieving all the content that is published in our <a href="{{ env('APP_URL') }}">website</a>.
                                    All the responses are delivered to the end user in <a href="http://www.json.org">JSON</a> format.
                                </p>
                                <div class="code-block">
                                    <h6>API Endpoint:</h6>
                                    <p><code>{{ env('APP_URL') }}api/</code></p>
                                </div><!--//code-block-->
                            </div>
                        </section><!--//doc-section-->

                        <section id="api-section" class="doc-section">
                            <h2 class="section-title">API Access</h2>
                            <div class="section-block">
                                <p>The API is public and can be accessed anytime, but there are some limitations in order to keep the API working fluently.</p>
                            </div><!--//section-block-->
                            <div id="status" class="section-block">
                                <h3 class="block-title">API Status</h3>
                                <p>There are two possible status for the API, which are <b>online</b> or <b>offline</b>. Depending on the status, the API can be accessed or not.</p>

                                <div class="code-block">
                                    <h6>Example request</h6>
                                    <pre><code class="language-markup">$ curl {{ env('APP_URL') }}api/</code></pre>
                                </div><!--//code-block-->

                                <div class="code-block">
                                    <h6>API Status Online Response</h6>
                                    <pre><code class="language-json">{
  "status": 200,
  "success": true,
  "data": {
    "api-status": "Online"
  }
}</code></pre>
                                </div><!--//code-block-->
                                <div class="code-block">
                                    <h6>API Status Offline Response</h6>
                                    <pre><code class="language-json">{
  "status": 500,
  "success": false,
  "error": {
    "code": "api_offline",
    "message": "The API is actually offline, please, try again later."
  }
}</code></pre>
                                </div><!--//code-block-->

                            </div><!--//section-block-->
                            <div id="throttle" class="section-block">
                                <h3 class="block-title">API Throttle</h3>
                                <p>
                                    To prevent our API from being overwhelmed by too many requests, the API Gateway throttles all the requests from the same client
                                    that exceeds more than <b>{{ env('API_THROTTLE') }} requests per minute</b>.
                                </p>

                                <div class="code-block">
                                    <h6>API Throttle Response</h6>
                                    <pre><code class="language-json">{
  "status": 500,
  "success": false,
  "error": {
    "code": "api_throttle_limit",
    "message": "Api throttle limit reached, please, try again later."
  }
}</code></pre>
                                </div><!--//code-block-->


                            </div>

                        </section>

                        <section id="projects-section" class="doc-section">
                            <h2 class="section-title">Projects</h2>
                            <div class="section-block">
                                <p>
                                    The API gives you the possibility to retrieve a list of all the projects that are actually published at the website and also,
                                    you can collect all the information related to a specific project.</p>
                            </div><!--//section-block-->
                            <div id="allProjects" class="section-block">
                                <h3 class="block-title">List all projects</h3>
                                <div class="code-block">
                                    <h6>Example request</h6>
                                    <pre><code class="language-markup">$ curl {{ env('APP_URL') }}api/projects</code></pre>
                                </div><!--//code-block-->
                                <p>
                                    <b>This endpoint allows you to retrieve a list of all the projects that are published at our website.</b>
                                </p>
                                <p>The list will include the <b>ocid</b> parameter, the <b>name</b>, the <b>url</b> endpoint to retrieve all the data of the project and the <b>publishedDate</b>.</p>
                                <div class="code-block">
                                    <h6>Example response</h6>
                                    <pre><code class="language-json">{
  "status": 200,
  "success": true,
  "data": [
    {
      "id": 1,
      "ocid": "ocds-12btn8-1",
      "name": "Lagos to Ibadan Expressway",
      "url": "{{ env('APP_URL') }}api/project/ocds-12btn8-1",
      "publishedDate": "2017-12-14T12:09:27+00:00"
    },
    {
      "id": 2,
      "ocid": "ocds-12btn8-2",
      "name": "Concession and leasing of grain storage facilities",
      "url": "{{ env('APP_URL') }}api/project/ocds-12btn8-2",
      "publishedDate": "2017-12-11T10:06:31+00:00"
    },
    {
      "id": 3,
      "ocid": "ocds-12btn8-3",
      "name": "Ibom Deep Seaport Project",
      "url": "{{ env('APP_URL') }}api/project/ocds-12btn8-3",
      "publishedDate": "2017-12-14T21:04:19+00:00"
    }
  ]
}</code></pre>
                                </div><!--//code-block-->
                            </div>
                            <div class="code-block">
                                <h6>Response details</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                            <td><b>id</b></td>
                                            <td><code>int</code></td>
                                        </tr>
                                        <tr><td colspan="2">This is the id of the project, it is exclusively used by the internal application.</td></tr>
                                        <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                            <td><b>ocid</b></td>
                                            <td><code>string</code></td>
                                        </tr>
                                        <tr><td colspan="2">The ocid parameter stands for "Open Contracting ID" and represents a globally unique identifier used to join up data on all stages of a contracting process.
                                                The ocid is the parameter used to identify and retrieve all the information of a project.</td></tr>
                                        <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                            <td><b>name</b></td>
                                            <td><code>string</code></td>
                                        </tr>
                                        <tr><td colspan="2">This is the name of the project.</td></tr>
                                        <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                            <td><b>url</b></td>
                                            <td><code>string</code></td>
                                        </tr>
                                        <tr><td colspan="2">This parameter represents a valid endpoint to retrieve all the information of a specific project.</td></tr>
                                        <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                            <td><b>publishedDate</b></td>
                                            <td><code>string</code></td>
                                        </tr>
                                        <tr><td colspan="2">This parameter represents the date and time in an international standard (<b>ISO 8601</b>) covering the exchange of date and time-related data.</td></tr>
                                        </tbody>
                                    </table>
                                </div><!--//table-responsive-->
                            </div>
                            <div id="individualProject" class="section-block">
                                <h3 class="block-title">Get all the data of a specific project</h3>
                                <div class="code-block">
                                    <h6>Example request</h6>
                                    <pre><code class="language-markup">$ curl {{ env('APP_URL') }}api/project/{ocid}</code></pre>
                                </div><!--//code-block-->
                                <p>
                                    <b>This endpoint allows you to retrieve all the data of a specific project.</b>
                                </p>
                                <p>
                                    The data retrieved from this endpoint complies with the <a href="http://standard.open-contracting.org/latest/en/">OCDS</a> standard.
                                    And implements the <a href="#">Transparency PPP Extension</a> for the disclose of contracting information of PPP projects.
                                </p>
                                <div class="code-block">
                                    <h6>Example response</h6>
                                    @if(isNigeriaSovereign())
                                        <pre><code class="language-json">{
    "extensions": ["{{ env("OCDS_EXTENSION_URL") }}"],
    "uri": "{{ env("OCDS_URI") }}api\/project\/ocds-12btn8-13",
    "version": "1.1",
    "publishedDate": "2017-12-18T15:16:47+00:00",
    "publisher": {
        "scheme": "{{ env("OCDS_SCHEME") }}",
        "name": "{{ env("OCDS_NAME") }}",
        "uri": "{{ env("OCDS_URI") }}",
        "uid": "{{ env("OCDS_UID") }}"
    },
    "records": [{
        "ocid": "ocds-12btn8-13",
        "releases": [{
            "ocid": "ocds-12btn8-13",
            "id": "13",
            "date": "2017-12-18T11:16:54+00:00",
            "initiationType": "tender",
            "tag": ["implementation"],
            "stage": "post-contract",
            "sectors": ["Industrial"],
            "locations": ["Anambra"],
            "sponsoringAgency": "Federal Ministry of Power, Works & Housing",
            "value": {
                "type": "final",
                "baseValue": {
                    "amount": 700000000,
                    "currency": "USD"
                },
                "localValue": {
                    "amount": 108000000000,
                    "currency": "NGN"
                }
            },
            "announcements": [{
                "id": 9,
                "name": "Announcement 9",
                "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                "documents": [],
                "datePublished": "2017-12-18T15:16:47+00:00"
            }],
            "development": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "descriptionOfServices": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "stakeholderConsultations": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "projectSummaryDocument": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project proposal received",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-02-09T00:00:00+00:00"
                }]
            },
            "procurement": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "descriptionOfServices": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "stakeholderConsultations": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "projectSummaryDocument": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project proposal received",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-02-09T00:00:00+00:00"
                }],
                "procurementDocuments": [{
                    "id": 13,
                    "name": "List of NSIA consultants and advisors throughout project life cycle: legal, financial, engineering, etc.",
                    "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "documents": [],
                    "datePublished": "2017-12-18T15:16:47+00:00"
                }]
            },
            "implementation": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "descriptionOfServices": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "stakeholderConsultations": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                        "documents": []
                    },
                    "projectSummaryDocument": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project proposal received",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-02-09T00:00:00+00:00"
                }],
                "procurementDocuments": [{
                    "id": 13,
                    "name": "List of NSIA consultants and advisors throughout project life cycle: legal, financial, engineering, etc.",
                    "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "documents": [],
                    "datePublished": "2017-12-18T15:16:47+00:00"
                }],
                "privateParties": [],
                "contractInformation": {
                    "financialStructure": [{
                        "id": 11,
                        "name": "Equity-debt ratio",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:16:47+00:00"
                    }],
                    "risks": {
                        "items": [{
                            "id": 15,
                            "name": "Construction \/ Completion",
                            "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                            "mitigation": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                            "allocation": "Private Sector"
                        }],
                        "documents": []
                    },
                    "tariffs": [{
                        "id": 11,
                        "name": "Tariff 1",
                        "description": "Tariff description",
                        "documents": [],
                        "datePublished": "2017-12-18T15:16:47+00:00"
                    }],
                    "terminationProvisions": [{
                        "id": 9,
                        "partyType": "authority",
                        "name": "Hello world",
                        "description": "asd",
                        "payment": "asdasd",
                        "documents": []
                    }],
                    "renegotiations": [{
                        "id": 13,
                        "name": "Rationale for variation",
                        "description": "Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:16:47+00:00"
                    }],
                    "guaranteesOrCommitmentsReceived": [{
                        "id": 13,
                        "name": "Guarantees",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:16:47+00:00"
                    }]
                },
                "performanceInformation": {
                    "keyPerformanceIndicators": [{
                        "id": 25,
                        "type": "Water loses (m\u00b3)",
                        "year": 2016,
                        "target": "1",
                        "achievement": "1"
                    }],
                    "performanceFailures": [{
                        "id": 13,
                        "name": "Performance failure 1",
                        "category": "Financial objectives",
                        "numberEvents": 1,
                        "penaltyType": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "penaltyImposed": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "penaltyPaid": true
                    }],
                    "performanceAssessments": [{
                        "id": 49,
                        "name": "Audit reports",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:16:47+00:00"
                    }]
                }
            }
        }]
    }]
}
</code></pre>
                                    @elseif(isNigeriaICRC())
                                        <pre><code class="language-json">{
  "extensions": ["{{ env("OCDS_EXTENSION_URL") }}"],
  "uri": "{{ env("OCDS_URI") }}api/project/ocds-12btn8-1",
  "version": "1.1",
  "publishedDate": "2017-12-18T16:29:06+00:00",
  "publisher": {
      "scheme": "{{ env("OCDS_SCHEME") }}",
      "name": "{{ env("OCDS_NAME") }}",
      "uri": "{{ env("OCDS_URI") }}",
      "uid": "{{ env("OCDS_UID") }}"
  },
  "records": [
    {
      "ocid": "ocds-12btn8-1",
      "releases": [
        {
          "ocid": "ocds-12btn8-1",
          "id": "1",
          "date": "2017-12-18T16:29:06+00:00",
          "initiationType": "tender",
          "tag": [
            "implementation"
          ],
          "stage": "implementation",
          "sectors": [
            "Transport"
          ],
          "locations": [
            "Cross River",
            "Adamawa"
          ],
          "sponsoringAgency": "Federal Ministry of Agriculture and Rural Development",
          "value": {
            "type": "final",
            "baseValue": {
              "amount": 156700000,
              "currency": "USD"
            },
            "localValue": {
              "amount": 674861000,
              "currency": "NGN"
            }
          },
          "announcements": [
            {
              "id": 1,
              "name": "Announcement 1",
              "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
              "documents": [],
              "datePublished": "2017-12-18T16:29:16+00:00"
            }
          ],
          "development": {
            "basicProjectInformation": {
              "projectNeed": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "descriptionOfAsset": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "descriptionOfServices": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "rationalePPP": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "stakeholderConsultations": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "projectSummaryDocument": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              }
            },
            "milestones": [
              {
                "id": 1,
                "title": "Project proposal received",
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                "status": "met",
                "dueDate": null,
                "dateMet": "2016-03-01T00:00:00+00:00"
              }
            ]
          },
          "procurement": {
            "basicProjectInformation": {
              "projectNeed": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "descriptionOfAsset": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "descriptionOfServices": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "rationalePPP": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "stakeholderConsultations": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "projectSummaryDocument": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              }
            },
            "milestones": [
              {
                "id": 1,
                "title": "Project proposal received",
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                "status": "met",
                "dueDate": null,
                "dateMet": "2016-03-01T00:00:00+00:00"
              }
            ],
            "procurementDocuments": [
              {
                "id": 1,
                "name": "Feasibility Study Report",
                "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                "documents": [],
                "datePublished": "2017-12-18T16:29:16+00:00"
              }
            ]
          },
          "implementation": {
            "basicProjectInformation": {
              "projectNeed": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "descriptionOfAsset": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "descriptionOfServices": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "rationalePPP": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "stakeholderConsultations": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              },
              "projectSummaryDocument": {
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                "documents": []
              }
            },
            "milestones": [
              {
                "id": 1,
                "title": "Project proposal received",
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                "status": "met",
                "dueDate": null,
                "dateMet": "2016-03-01T00:00:00+00:00"
              }
            ],
            "procurementDocuments": [
              {
                "id": 1,
                "name": "Feasibility Study Report",
                "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                "documents": [],
                "datePublished": "2017-12-18T16:29:16+00:00"
              }
            ],
            "privateParties": [
              {
                "id": 3,
                "name": "Federal Ministry of Environment",
                "nameRepresentative": null,
                "address": null,
                "phone": null,
                "fax": null,
                "email": null,
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ",
                "facebook": null,
                "twitter": null,
                "instagram": null,
                "website": "http://environment.gov.ng/index.html"
              }
            ],
            "contractInformation": {
              "financialStructure": [
                {
                  "id": 1,
                  "name": "Equity-debt ratio",
                  "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                  "documents": [],
                  "datePublished": "2017-12-18T16:29:16+00:00"
                }
              ],
              "risks": {
                "items": [
                  {
                    "id": 1,
                    "name": "Pre-construction risk",
                    "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "mitigation": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "allocation": "Public Sector"
                  }
                ],
                "documents": []
              },
              "tariffs": [
                {
                  "id": 1,
                  "name": "Tariff 1",
                  "description": "Tariff description",
                  "documents": [],
                  "datePublished": "2017-12-18T16:29:16+00:00"
                }
              ],
              "terminationProvisions": [
                {
                  "id": 1,
                  "partyType": "operator",
                  "name": "Event",
                  "description": "Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.",
                  "payment": "Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.",
                  "documents": []
                }
              ],
              "renegotiations": [
                {
                  "id": 1,
                  "name": "Rationale for variation",
                  "description": "Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.",
                  "documents": [],
                  "datePublished": "2017-12-18T16:29:16+00:00"
                }
              ],
              "redactedPPPAgreement": [
                {
                  "id": 1,
                  "name": "Document 1",
                  "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                  "documents": [],
                  "datePublished": "2017-12-18T16:29:16+00:00"
                }
              ],
              "governmentSupport": [
                {
                  "id": 1,
                  "name": "Guarantees",
                  "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                  "documents": [],
                  "datePublished": "2017-12-18T16:29:16+00:00"
                }
              ]
            },
            "performanceInformation": {
              "keyPerformanceIndicators": [
                {
                  "id": 1,
                  "type": "Water loses (m³)",
                  "year": 2016,
                  "target": "1",
                  "achievement": "1"
                }
              ],
              "performanceFailures": [
                {
                  "id": 1,
                  "name": "Performance failure 1",
                  "category": "Financial objectives",
                  "numberEvents": 1,
                  "penaltyType": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                  "penaltyImposed": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                  "penaltyPaid": true
                }
              ],
              "performanceAssessments": [
                {
                  "id": 1,
                  "name": "Audit reports",
                  "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                  "documents": [],
                  "datePublished": "2017-12-18T16:29:16+00:00"
                }
              ]
            }
          }
        }
      ]
    }
  ]
}</code></pre>
                                    @elseif(isKenya())
                                        <pre><code class="language-json">{
    "extensions": ["{{ env("OCDS_EXTENSION_URL") }}"],
    "uri": "{{ env("OCDS_URI") }}api\/project\/ocds-2q8bt1-1",
    "version": "1.1",
    "publishedDate": "2017-12-18T15:46:50+00:00",
    "publisher": {
        "scheme": "{{ env("OCDS_SCHEME") }}",
        "name": "{{ env("OCDS_NAME") }}",
        "uri": "{{ env("OCDS_URI") }}",
        "uid": "{{ env("OCDS_UID") }}"
    },
    "records": [{
        "ocid": "ocds-2q8bt1-1",
        "releases": [{
            "ocid": "ocds-2q8bt1-1",
            "id": "1",
            "date": "2017-12-18T15:46:37+00:00",
            "initiationType": "tender",
            "tag": ["implementation"],
            "stage": "post-procurement",
            "sectors": ["Transport"],
            "locations": ["Mombasa"],
            "sponsoringAgency": "Kenya Urban Roads Authority (KURA)",
            "value": {
                "type": "final",
                "baseValue": {
                    "amount": 156700000,
                    "currency": "USD"
                },
                "localValue": {
                    "amount": 674861000,
                    "currency": "KES"
                }
            },
            "announcements": [{
                "id": 1,
                "name": "Announcement 1",
                "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                "documents": [],
                "datePublished": "2017-12-18T15:46:49+00:00"
            }],
            "development": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "The proposed project seeks to apply a PPP arrangement for the development of a 2nd Nyali Bridge connecting the Mombasa Island with the North mainland to ease congestion on the existing Nyali Bridge and to make the traffic less dependent on a single channel crossing.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "transactionAdvisor": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "unsolicitedProject": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "projectSummaryDocument": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project proposal received",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-02-09T00:00:00+00:00"
                }]
            },
            "procurement": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "The proposed project seeks to apply a PPP arrangement for the development of a 2nd Nyali Bridge connecting the Mombasa Island with the North mainland to ease congestion on the existing Nyali Bridge and to make the traffic less dependent on a single channel crossing.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "transactionAdvisor": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "unsolicitedProject": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "projectSummaryDocument": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project proposal received",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-02-09T00:00:00+00:00"
                }],
                "procurementDocuments": [{
                    "id": 1,
                    "name": "Feasibility Study Report",
                    "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "documents": [],
                    "datePublished": "2017-12-18T15:46:49+00:00"
                }]
            },
            "implementation": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "The proposed project seeks to apply a PPP arrangement for the development of a 2nd Nyali Bridge connecting the Mombasa Island with the North mainland to ease congestion on the existing Nyali Bridge and to make the traffic less dependent on a single channel crossing.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "transactionAdvisor": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "unsolicitedProject": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    },
                    "projectSummaryDocument": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project proposal received",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-02-09T00:00:00+00:00"
                }],
                "procurementDocuments": [{
                    "id": 1,
                    "name": "Feasibility Study Report",
                    "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "documents": [],
                    "datePublished": "2017-12-18T15:46:49+00:00"
                }],
                "privateParties": [{
                    "id": 3,
                    "name": "Ministry of Transport and Infrastructure (MOTI)",
                    "nameRepresentative": null,
                    "address": "Ministry of Transport, Infrastructure, Housing and Urban Development, Transcom House, NGONG ROAD, P.o Box 52692 - 00200, NAIROBI, KENYA",
                    "phone": "+254-020-2729200",
                    "fax": null,
                    "email": "",
                    "description": "Our Vision: To be global leader in provision of transport infrastructure, maritime economy, the built environment and sustainable urban development. Our Mission: \"To develop and sustain world class transport infrastructure, maritime economy, public works and housing for sustainable socio-economic development\"",
                    "facebook": "https:\/\/www.facebook.com\/Ministry-of-Transport-and-Infrastructure-GoK-493194307419924\/?fref=ts",
                    "twitter": "https:\/\/twitter.com\/transportke",
                    "instagram": "",
                    "website": "http:\/\/www.transport.go.ke"
                }],
                "contractInformation": {
                    "financialStructure": [{
                        "id": 1,
                        "name": "Equity-debt ratio",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:49+00:00"
                    }],
                    "risks": {
                        "items": [{
                            "id": 1,
                            "name": "Pre-construction risk",
                            "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                            "mitigation": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                            "allocation": "Public Sector"
                        }],
                        "documents": []
                    },
                    "tariffs": [{
                        "id": 1,
                        "name": "Tariff 1",
                        "description": "Tariff description",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:49+00:00"
                    }],
                    "terminationProvisions": [{
                        "id": 1,
                        "partyType": "operator",
                        "name": "Event",
                        "description": "Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.",
                        "payment": "Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.",
                        "documents": []
                    }],
                    "renegotiations": [{
                        "id": 1,
                        "name": "Rationale for variation",
                        "description": "Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:50+00:00"
                    }],
                    "redactedPPPAgreement": [{
                        "id": 1,
                        "name": "Document 1",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:50+00:00"
                    }],
                    "governmentSupport": [{
                        "id": 1,
                        "name": "Guarantees",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:50+00:00"
                    }]
                },
                "performanceInformation": {
                    "keyPerformanceIndicators": [{
                        "id": 1,
                        "type": "Water loses (m\u00b3)",
                        "year": 2016,
                        "target": "1",
                        "achievement": "1"
                    }],
                    "performanceFailures": [{
                        "id": 1,
                        "name": "Performance failure 1",
                        "category": "Financial objectives",
                        "numberEvents": 1,
                        "penaltyType": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "penaltyImposed": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "penaltyPaid": true
                    }],
                    "performanceAssessments": [{
                        "id": 1,
                        "name": "Audit reports",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:50+00:00"
                    }]
                }
            }
        }]
    }]
}
</code></pre>
                                    @else
                                        <pre><code class="language-json">{
    "extensions": ["{{ env("OCDS_EXTENSION_URL") }}"],
    "uri": "{{ env("OCDS_URI") }}api\/project\/ocds-2q8bt1-1",
    "version": "1.1",
    "publishedDate": "2017-12-18T15:46:11+00:00",
    "publisher": {
        "scheme": "{{ env("OCDS_SCHEME") }}",
        "name": "{{ env("OCDS_NAME") }}",
        "uri": "{{ env("OCDS_URI") }}",
        "uid": "{{ env("OCDS_UID") }}"
    },
    "records": [{
        "ocid": "ocds-2q8bt1-1",
        "releases": [{
            "ocid": "ocds-2q8bt1-1",
            "id": "1",
            "date": "2017-12-18T15:45:37+00:00",
            "initiationType": "tender",
            "tag": ["implementation"],
            "stage": "pre-procurement",
            "sectors": ["Transport"],
            "locations": ["Western", "Central"],
            "sponsoringAgency": "Ministry of Finance of Ghana",
            "value": {
                "type": "final",
                "baseValue": {
                    "amount": 156700000,
                    "currency": "USD"
                },
                "localValue": {
                    "amount": 674861000,
                    "currency": "GHS"
                }
            },
            "announcements": [{
                "id": 1,
                "name": "Announcement 1",
                "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                "documents": [],
                "datePublished": "2017-12-18T15:46:11+00:00"
            }],
            "development": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "descriptionOfServices": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "stakeholderConsultations": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project milestone 1",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. EDITED",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-05-24T00:00:00+00:00"
                }]
            },
            "procurement": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "descriptionOfServices": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "stakeholderConsultations": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project milestone 1",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. EDITED",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-05-24T00:00:00+00:00"
                }],
                "procurementDocuments": [{
                    "id": 1,
                    "name": "Feasibility Study Report",
                    "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "documents": [],
                    "datePublished": "2017-12-18T15:46:11+00:00"
                }]
            },
            "implementation": {
                "basicProjectInformation": {
                    "projectNeed": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "descriptionOfAsset": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "descriptionOfServices": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "rationalePPP": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    },
                    "stakeholderConsultations": {
                        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.",
                        "documents": []
                    }
                },
                "milestones": [{
                    "id": 1,
                    "title": "Project milestone 1",
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. EDITED",
                    "status": "met",
                    "dueDate": null,
                    "dateMet": "2016-05-24T00:00:00+00:00"
                }],
                "procurementDocuments": [{
                    "id": 1,
                    "name": "Feasibility Study Report",
                    "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                    "documents": [],
                    "datePublished": "2017-12-18T15:46:11+00:00"
                }],
                "privateParties": [{
                    "id": 3,
                    "name": "Ministry of Transport of Ghana",
                    "nameRepresentative": null,
                    "address": null,
                    "phone": null,
                    "fax": null,
                    "email": null,
                    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ",
                    "facebook": null,
                    "twitter": null,
                    "instagram": null,
                    "website": "http:\/www.mot.gov.gh\/"
                }],
                "contractInformation": {
                    "financialStructure": [{
                        "id": 1,
                        "name": "Equity-debt ratio",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:11+00:00"
                    }],
                    "risks": {
                        "items": [{
                            "id": 1,
                            "name": "Pre-construction risk",
                            "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                            "mitigation": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at.",
                            "allocation": "Public Sector"
                        }],
                        "documents": []
                    },
                    "tariffs": [{
                        "id": 1,
                        "name": "Tariff 1",
                        "description": "Tariff description",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:11+00:00"
                    }],
                    "terminationProvisions": [{
                        "id": 1,
                        "partyType": "operator",
                        "name": "Event",
                        "description": "Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.",
                        "payment": "Ad eum alia porro, nec ei aliquip laoreet. Sed no consul impetus. An esse iuvaret qui. Iudico phaedrum intellegat nec ut, libris dolorum an eam, sea at habeo admodum maiestatis.",
                        "documents": []
                    }],
                    "renegotiations": [{
                        "id": 1,
                        "name": "Rationale for variation",
                        "description": "Soluta numquam pro ei, mel id civibus iudicabit iracundia. Eam affert percipit ea. Alterum noluisse his ea. Vis in erant viris. Ei sit iusto tation repudiandae, quas altera referrentur est at.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:11+00:00"
                    }],
                    "contractDocuments": [{
                        "id": 1,
                        "name": "Document 1",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:11+00:00"
                    }],
                    "governmentSupport": [{
                        "id": 1,
                        "name": "Guarantees",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:11+00:00"
                    }],
                    "environmentAndSocialImpact": {
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": []
                    }
                },
                "performanceInformation": {
                    "keyPerformanceIndicators": [{
                        "id": 1,
                        "type": "Water loses (m\u00b3)",
                        "year": 2016,
                        "target": "1",
                        "achievement": "1"
                    }],
                    "performanceFailures": [{
                        "id": 1,
                        "name": "Performance failure 1",
                        "category": "Financial objectives",
                        "numberEvents": 1,
                        "penaltyType": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "penaltyImposed": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "penaltyPaid": true
                    }],
                    "performanceAssessments": [{
                        "id": 1,
                        "name": "Performance assessment 1",
                        "description": "Lorem ipsum dolor sit amet, ne eam dicat nostrum. Ad zril principes vim, nec etiam alienum in, eos molestie facilisis interesset at. Magna iracundia inciderint cum ut, at vis suscipit nominati efficiendi. Id intellegat inciderint usu, ea unum dicta scripta has, aeque dissentiet per id. Vel no feugiat graecis. Est purto dissentias ea.",
                        "documents": [],
                        "datePublished": "2017-12-18T15:46:11+00:00"
                    }]
                }
            }
        }]
    }]
}
</code></pre>
                                    @endif
                                </div><!--//code-block-->
                                <div class="code-block">
                                    <h6>Response details</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>extensions</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">An array of all the OCDS extensions that are implementing the response.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>uri</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The endpoint of the current response.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>version</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">This is the version of the OCDS standard that is in use on the response.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>publishedDate</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">This parameter represents the creation date and time in an international standard (<b>ISO 8601</b>) covering the exchange of date and time-related data.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>publisher / </span><b>scheme</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The scheme that holds the unique identifiers used to identify the item being identified.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>publisher / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the organization or department responsible for publishing this data.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>publisher / </span><b>uri</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A URI to identify the publisher.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>publisher / </span><b>uid</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The unique ID for this entity under the given ID scheme.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / </span><b>ocid</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A globally unique identifier for this Open Contracting Process. Composed of a publisher prefix and an identifier for the contracting process.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>ocid</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A globally unique identifier for this Open Contracting Process. Composed of a publisher prefix and an identifier for the contracting process.</td></tr>

                                            <!-- BASIC PROJECT INFORMATION -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The unique identifier of this project.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>date</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The creation date of the project.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>initiationType</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">String specifying the type of initiation process used for this contract. Currently only tender is supported.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>tag</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">This parameter represents the current stage of the project.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>stage</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">This parameter represents the current stage of the project.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>sector</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">An array of the different sectors involving this project.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>locations</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">An array of all the locations where this project takes place.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / </span><b>sponsoringAgency</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the Sponsoring Agency.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / value / </span><b>type</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Type of budget, there are two options available "Indicative" or "Final".</td></tr>

                                            <!-- VALUE -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / value / baseValue / </span><b>amount</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The base value of the project in US dollars.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / value / baseValue / </span><b>currency</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The currency of this value amount.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / value / localValue / </span><b>amount</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The value of the project in the local currency.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / value / localValue / </span><b>currency</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The currency of this value amount.</td></tr>

                                            <!-- ANNOUNCEMENTS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / announcements / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the announcement.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / announcements / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the announcement.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / announcements / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The description of the announcement.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / announcements / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the announcement.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / announcements / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to this announcement. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>

                                            <!-- DEVELOPMENT START -->
                                            <!-- BASIC PROJECT INFORMATION -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / projectNeed / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A detailed description of the project needs.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / projectNeed / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to projectNeed. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / descriptionOfAsset / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the description of asset.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / descriptionOfAsset / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to descriptionOfAsset. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / descriptionOfServices / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the description of services.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / descriptionOfServices / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to descriptionOfServices. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / rationaleForSelectionOfPPPModel / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the rational for selection of ppp model.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / rationaleForSelectionOfPPPModel / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to rationaleForSelectionOfPPPModel. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / stakeholderConsultations / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the stakeholder consultations.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / stakeholderConsultations / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to stakeholderConsultations. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / projectSummaryDocument / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the project summary documents.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / basicProjectInformation / projectSummaryDocument / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to projectSummaryDocument. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>

                                            <!-- MILESTONES -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / milestones / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / milestones / </span><b>title</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The title of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / milestones / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / milestones / </span><b>status</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The status of the milestone. It's value can be "met" or "schedule".</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / milestones / </span><b>dueDate</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The due date of the milestone if the status is "schedule".</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / development / milestones / </span><b>dateMet</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The date met of the milestone if the status is "met".</td></tr>

                                            <!-- PROCUREMENT START -->
                                            <!-- BASIC PROJECT INFORMATION -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / projectNeed / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A detailed description of the project needs.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / projectNeed / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to projectNeed. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / descriptionOfAsset / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the description of asset.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / descriptionOfAsset / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to descriptionOfAsset. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / descriptionOfServices / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the description of services.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / descriptionOfServices / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to descriptionOfServices. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / rationaleForSelectionOfPPPModel / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the rational for selection of ppp model.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / rationaleForSelectionOfPPPModel / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to rationaleForSelectionOfPPPModel. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / stakeholderConsultations / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the stakeholder consultations.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / stakeholderConsultations / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to stakeholderConsultations. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / projectSummaryDocument / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the project summary documents.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / basicProjectInformation / projectSummaryDocument / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to projectSummaryDocument. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>

                                            <!-- MILESTONES -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / milestones / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / milestones / </span><b>title</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The title of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / milestones / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / milestones / </span><b>status</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The status of the milestone. It's value can be "met" or "schedule".</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / milestones / </span><b>dueDate</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The due date of the milestone if the status is "schedule".</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / milestones / </span><b>dateMet</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The date met of the milestone if the status is "met".</td></tr>

                                            <!-- PROCUREMENT DOCUMENTS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / procurementDocuments / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the procurement document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / procurementDocuments / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The title of the procurement document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / procurementDocuments / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The description of the procurement document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / procurement / procurementDocuments / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to procurementDocuments. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>

                                            <!-- IMPLEMENTATION START -->
                                            <!-- BASIC PROJECT INFORMATION -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / projectNeed / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A detailed description of the project needs.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / projectNeed / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to projectNeed. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / descriptionOfAsset / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the description of asset.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / descriptionOfAsset / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to descriptionOfAsset. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / descriptionOfServices / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the description of services.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / descriptionOfServices / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to descriptionOfServices. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / rationaleForSelectionOfPPPModel / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the rational for selection of ppp model.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / rationaleForSelectionOfPPPModel / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to rationaleForSelectionOfPPPModel. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / stakeholderConsultations / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the stakeholder consultations.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / stakeholderConsultations / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to stakeholderConsultations. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / projectSummaryDocument / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">Details of the project summary documents.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / basicProjectInformation / projectSummaryDocument / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to projectSummaryDocument. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>

                                            <!-- MILESTONES -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / milestones / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / milestones / </span><b>title</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The title of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / milestones / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the milestone.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / milestones / </span><b>status</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The status of the milestone. It's value can be "met" or "schedule".</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / milestones / </span><b>dueDate</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The due date of the milestone if the status is "schedule".</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / milestones / </span><b>dateMet</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The date met of the milestone if the status is "met".</td></tr>

                                            <!-- PROCUREMENT DOCUMENTS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / procurementDocuments / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the procurement document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / procurementDocuments / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The title of the procurement document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / procurementDocuments / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The description of the procurement document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / procurementDocuments / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to procurementDocuments. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>

                                            <!-- PARTIES -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>nameRepresentative</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the representative of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>address</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The address of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>phone</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The phone number of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>fax</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The fax number of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>email</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The email of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>description</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>facebook</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The facebook page of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>twitter</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The twitter of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>instagram</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The instagram of the party.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / parties / </span><b>website</b></td>
                                                <td><code>string</code> or <code>null</code></td>
                                            </tr>
                                            <tr><td colspan="2">The website of the party.</td></tr>

                                            <!-- CONTRACT INFORMATION -->
                                            <!-- REDACTED PPP AGREEMENT -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / redactedPPPAgreement / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the redacted ppp agreement.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / redactedPPPAgreement / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the redacted ppp agreement.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / redactedPPPAgreement / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the redacted ppp agreement.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / redactedPPPAgreement / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to redactedPPPAgreement. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / redactedPPPAgreement / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the redacted ppp agreement.</td></tr>

                                            <!-- FINANCIAL STRUCTURE -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / financialStructure / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the financial structure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / financialStructure / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the financial structure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / financialStructure / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the financial structure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / financialStructure / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to financialStructure. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / financialStructure / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the financial structure.</td></tr>

                                            <!-- RISKS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / risks / items / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the risk.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / risks / items / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the risk.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / risks / items / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the risk.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / risks / items / </span><b>mitigation</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The mitigation of the risk.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / risks / items / </span><b>allocation</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The allocation of the risk.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / risks / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to risks. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>

                                            <!-- GOVERNMENT SUPPORT -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / governmentSupport / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the government support.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / governmentSupport / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the government support.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / governmentSupport / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the government support.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / governmentSupport / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to governmentSupport. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / governmentSupport / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the government support.</td></tr>

                                            <!-- TARIFFS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / tariffs / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the tariff.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / tariffs / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the tariff.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / tariffs / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the tariff.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / tariffs / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to tariffs. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / tariffs / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the tariff.</td></tr>

                                            <!-- TERMINATION PROVISIONS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / terminationProvisions / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the termination provision.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / terminationProvisions / </span><b>partyType</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The party type of the termination provision.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / terminationProvisions / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the termination provision.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / terminationProvisions / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the termination provision.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / terminationProvisions / </span><b>payment</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The payment of the termination provision.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / terminationProvisions / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to terminationProvisions. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / terminationProvisions / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the termination provision.</td></tr>

                                            <!-- RENEGOTIATIONS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / renegotiations / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the renegotiation.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / renegotiations / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the renegotiation.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / renegotiations / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the renegotiation.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / renegotiations / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to renegotiations. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / renegotiations / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the renegotiation.</td></tr>

                                            <!-- PERFORMANCE INFORMATION -->
                                            <!-- KEY PERFORMANCE INDICATORS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / keyPerformanceIndicators / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the key performance indicator.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / keyPerformanceIndicators / </span><b>type</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The type of the key performance indicator.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / keyPerformanceIndicators / </span><b>year</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The year of the key performance indicator.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / keyPerformanceIndicators / </span><b>target</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The target value of the key performance indicator.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / keyPerformanceIndicators / </span><b>achievement</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The achievement value of the key performance indicator.</td></tr>

                                            <!-- PERFORMANCE FAILURES -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / performanceFailures / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the performance failure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / performanceFailures / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the performance failure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / performanceFailures / </span><b>category</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The category of the performance failure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / performanceFailures / </span><b>numberEvents</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The number of events of the performance failure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / performanceFailures / </span><b>penaltyType</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The penalty type of the performance failure.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / performanceFailures / </span><b>penaltyImposed</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The penalty imposed of the key performance indicator.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / performanceInformation / performanceFailures / </span><b>penaltyPaid</b></td>
                                                <td><code>boolean</code></td>
                                            </tr>
                                            <tr><td colspan="2">Inform if the penalty has been paid or not.</td></tr>

                                            <!-- PERFORMANCE ASSESSMENTS -->
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / performanceAssessments / </span><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the performance assessment.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / performanceAssessments / </span><b>name</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the performance assessment.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / performanceAssessments / </span><b>description</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">A description of the performance assessment.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / performanceAssessments / </span><b>documents</b></td>
                                                <td><code>array</code></td>
                                            </tr>
                                            <tr><td colspan="2">The list of documents attached to performanceAssessments. See the <a class="scrollto" href="#document-object">document object</a> for more information.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><span>records / releases / implementation / contractInformation / performanceAssessments / </span><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the performance assessment.</td></tr>

                                            </tbody>
                                        </table>
                                    </div><!--//table-responsive-->
                                </div>
                                <div id="document-object" class="code-block">
                                    <h6>Document object details</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>id</b></td>
                                                <td><code>int</code></td>
                                            </tr>
                                            <tr><td colspan="2">The internal id of the document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>title</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The name of the document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>format</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The mime-type of the document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>url</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The download link of the document.</td></tr>
                                            <tr style="border-top: 2px solid #b5e1f7; background-color: #fff;">
                                                <td><b>datePublished</b></td>
                                                <td><code>string</code></td>
                                            </tr>
                                            <tr><td colspan="2">The publication date of the document.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div><!--//content-inner-->
                </div><!--//doc-content-->
                <div class="doc-sidebar hidden-xs">
                    <nav id="doc-nav">
                        <ul id="doc-menu" class="nav doc-menu" data-spy="affix">
                            <li><a class="scrollto" href="#introduction-section">Introduction</a></li>
                            <li>
                                <a class="scrollto" href="#api-section">API Access</a>
                                <ul class="nav doc-sub-menu">
                                    <li><a class="scrollto" href="#status">API Status</a></li>
                                    <li><a class="scrollto" href="#throttle">API Throttle</a></li>
                                </ul><!--//nav-->
                            </li>
                            <li>
                                <a class="scrollto" href="#projects-section">Projects</a>
                                <ul class="nav doc-sub-menu">
                                    <li><a class="scrollto" href="#allProjects">List all projects</a></li>
                                    <li><a class="scrollto" href="#individualProject">Individual project</a></li>
                                </ul><!--//nav-->
                            </li>
                        </ul><!--//doc-menu-->
                    </nav>
                </div><!--//doc-sidebar-->
            </div><!--//doc-body-->
        </div><!--//container-->
    </div><!--//doc-wrapper-->

</div><!--//page-wrapper-->

<footer id="footer" class="footer text-center">
    <div class="container">
        <!--/* This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can check out other license options via our website: themes.3rdwavemedia.com */-->
        <small class="copyright">{{ env('APP_TITLE') }} @ {{ \Carbon\Carbon::now()->format('Y') }}</small>

    </div><!--//container-->
</footer><!--//footer-->


<!-- Main Javascript -->
<script type="text/javascript" src="../docs/plugins/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="../docs/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../docs/plugins/prism/prism.js"></script>
<script type="text/javascript" src="../docs/plugins/jquery-scrollTo/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="../docs/plugins/jquery-match-height/jquery.matchHeight-min.js"></script>
<script type="text/javascript" src="../docs/js/main.js"></script>

</body>
</html>
