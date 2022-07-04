const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/bootstrap.js', 'public/js')
    .js('resources/assets/js/jquery-3.2.0.min.js', 'public/js')
    .js('resources/assets/js/custom.js', 'public/js')
    .js('resources/assets/js/material.min.js', 'public/js')
    .less('resources/assets/less/app.less', 'public/css')

/*
 |--------------------------------------------------------------------------
 |  Back-End Libraries Block
 |--------------------------------------------------------------------------
 |
 | This block, provides all the libraries that will be used in the back end
 |
 |
 */


mix.styles([
    'node_modules/adminbsb-materialdesign/plugins/bootstrap/css/bootstrap.css',
    'node_modules/adminbsb-materialdesign/plugins/node-waves/waves.css',
    'node_modules/adminbsb-materialdesign/plugins/animate-css/animate.css',
    'node_modules/adminbsb-materialdesign/plugins/sweetalert/sweetalert.css',
    'node_modules/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
    'node_modules/adminbsb-materialdesign/plugins/bootstrap-select/css/bootstrap-select.css',
    'node_modules/adminbsb-materialdesign/css/materialize.css',
    'node_modules/adminbsb-materialdesign/css/style.css',
], 'public/back/css/libs.css');

mix.scripts([
    'node_modules/adminbsb-materialdesign/plugins/jquery/jquery.js',
    'node_modules/adminbsb-materialdesign/plugins/bootstrap/js/bootstrap.js',
    'node_modules/adminbsb-materialdesign/plugins/jquery-slimscroll/jquery.slimscroll.js',
    'node_modules/adminbsb-materialdesign/plugins/node-waves/waves.js',
    'node_modules/adminbsb-materialdesign/plugins/momentjs/moment.js',
    'node_modules/adminbsb-materialdesign/plugins/jquery-countto/jquery.countTo.js',
    'node_modules/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js',
    'node_modules/adminbsb-materialdesign/plugins/sweetalert/sweetalert.min.js',
    'node_modules/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js'
], 'public/back/js/libs.js');

//Input Mask
mix.js('node_modules/adminbsb-materialdesign/plugins/jquery-inputmask/jquery.inputmask.bundle.js', 'public/back/plugins/jquery-inputmask');

//Bootstrap date time picker
mix.copy('node_modules/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css', 'public/back/plugins/bootstrap-material-datetimepicker');
mix.js('node_modules/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js', 'public/back/plugins/bootstrap-material-datetimepicker');

//Drop zone
mix.copy('node_modules/adminbsb-materialdesign/plugins/dropzone/dropzone.css', 'public/back/plugins/dropzone');
mix.js('node_modules/adminbsb-materialdesign/plugins/dropzone/dropzone.js', 'public/back/plugins/dropzone');

//Fine uploader
mix.copy('node_modules/fine-uploader/all.fine-uploader/fine-uploader.css', 'public/back/plugins/fineuploader-core');
mix.copy('node_modules/fine-uploader/all.fine-uploader/fine-uploader-gallery.css', 'public/back/plugins/fineuploader-core');
mix.copy('node_modules/fine-uploader/all.fine-uploader/fine-uploader-new.css', 'public/back/plugins/fineuploader-core');
mix.copy('node_modules/fine-uploader/all.fine-uploader/all.fine-uploader.core.js', 'public/back/plugins/fineuploader-core');
mix.copy('node_modules/fine-uploader/all.fine-uploader/all.fine-uploader.js', 'public/back/plugins/fineuploader-core');

//colorpicker
mix.copy('node_modules/adminbsb-materialdesign/plugins/bootstrap-colorpicker/', 'public/back/plugins/bootstrap-colorpicker');
mix.js('node_modules/adminbsb-materialdesign/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js', 'public/back/plugins/bootstrap-colorpicker');

//International telephone input
mix.copy('node_modules/intl-tel-input/build/css/intlTelInput.css', 'public/back/plugins/intl-tel-input');
mix.copy('node_modules/intl-tel-input/build/js/utils.js', 'public/back/plugins/intl-tel-input');
mix.copy('node_modules/intl-tel-input/build/js/intlTelInput.js', 'public/back/plugins/intl-tel-input');
mix.copy('node_modules/intl-tel-input/build/img', 'public/back/plugins/intl-tel-input/img');

//Data-table
mix.copy('node_modules/datatables.net/js/jquery.dataTables.js', 'public/back/plugins/datatable');
mix.copy('node_modules/datatables.net-bs/js/dataTables.bootstrap.js', 'public/back/plugins/datatable');
mix.copy('node_modules/datatables.net-bs/css/dataTables.bootstrap.css', 'public/back/plugins/datatable');

//Bootstrap select
mix.copy('node_modules/bootstrap-select/dist/js/bootstrap-select.js', 'public/back/plugins/bootstrap-select');

//Ajax bootstrap select
mix.copy('node_modules/ajax-bootstrap-select/dist/css/ajax-bootstrap-select.css', 'public/back/plugins/ajax-bootstrap-select');
mix.copy('node_modules/ajax-bootstrap-select/dist/js/ajax-bootstrap-select.js', 'public/back/plugins/ajax-bootstrap-select');

//Bootstrap date time picker
mix.copy('node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'public/back/plugins/eonasdan-bootstrap-datetimepicker');
mix.copy('node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'public/back/plugins/eonasdan-bootstrap-datetimepicker');

//Bootstrap spinner
mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-spinner/css/bootstrap-spinner.css', 'public/back/plugins/jquery-spinner');
mix.copy('node_modules/adminbsb-materialdesign/plugins/jquery-spinner/js/jquery.spinner.js', 'public/back/plugins/jquery-spinner');

//Responsive toolkit
mix.copy('node_modules/adminbsb-materialdesign/plugins/editable-table/mindmup-editabletable.js', 'public/back/plugins/editable-table');

//Chartist
mix.copy('node_modules/chartist/dist/chartist.min.css', 'public/front/plugins/chartist');
mix.copy('node_modules/chartist/dist/chartist.min.js', 'public/front/plugins/chartist');
mix.copy('node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js', 'public/front/plugins/chartist');
// mix.copy('node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css', 'public/front/plugins/chartist');

//Font awesome
mix.copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/back/plugins/font-awesome/css');
mix.copy('node_modules/font-awesome/fonts', 'public/back/plugins/font-awesome/fonts');

//Toastr
mix.copy('node_modules/toastr/build/toastr.min.js', 'public/back/plugins/toastr');
mix.copy('node_modules/toastr/build/toastr.css', 'public/back/plugins/toastr');

//Multi-select
mix.copy('node_modules/adminbsb-materialdesign/plugins/multi-select/css/multi-select.css', 'public/back/plugins/multi-select');
mix.copy('node_modules/adminbsb-materialdesign/plugins/multi-select/js/jquery.multi-select.js', 'public/back/plugins/multi-select');
mix.copy('node_modules/adminbsb-materialdesign/plugins/multi-select/img/switch.png', 'public/back/plugins/multi-select/img');

// Flags
mix.copy('node_modules/flag-icon-css/css', 'public/back/plugins/flag-icon-css/css');
mix.copy('node_modules/flag-icon-css/flags', 'public/back/plugins/flag-icon-css/flags');

// Browser update
// mix.copy('node_modules/browser-update/update.npm.full.js', 'public/back/plugins/browser-update');


/*
 |--------------------------------------------------------------------------
 |  End Back-End Libraries Block
 |--------------------------------------------------------------------------
 |
 |
 */
