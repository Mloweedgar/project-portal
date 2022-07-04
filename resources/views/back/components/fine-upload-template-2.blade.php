

@section('styles')
<style>
    /* TODO: Put on styles sections*/

    .fine-uploader .qq-upload-button-selector.qq-upload-button{
        position:absolute !important;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:transparent;
        border:0;
        margin: 0;
        padding: 0;
    }

    .qq-drop-text{
        height:100%;
        display:flex;
        align-items: center;
        align-content: center;
        justify-content: center;
        flex-direction: column;
        width:100%;
        color: #607D8B;
    }

    .qq-drop-text .material-icons{
        font-size:50px;

    }

    .qq-gallery{
        position:relative;
        cursor:pointer;
        overflow:hidden;
        height:300px;
    }

    .qq-upload-list-selector.qq-upload-list{

        position: absolute;
        top:0;
        padding:0;
        margin:0;
        width:90%;

    }

    .qq-upload-list-selector.qq-upload-list li{
        margin:10px;
    }

    #upload-button{
        display:none;
        position:absolute;
        bottom:0;
        right:0;
        margin: 0 5px 15px 0;
    }

  ul.qq-upload-list-selector.qq-upload-list{
      max-height: 600px;
      overflow-y:visible;
  }

  ul.qq-upload-list-selector.qq-upload-list li{
      max-height: 600px;
      height:60px;
  }

  li .qq-upload-cancel-selector.qq-upload-cancel{
    top:auto;

  }

</style>
    @parent
@endsection

<form id="dynamic-form-validation" action="{{ route('project.gallery.upload') }}" method="POST">
    {{ csrf_field() }}

<script type="text/template" id="qq-template">

   <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text=" ">
       <div class="qq-upload-button-selector qq-upload-button">

       </div>
       <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
           <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
       </div>
       <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
           <span class="qq-upload-drop-area-text-selector"></span>
       </div>

       <div class="qq-drop-text ">

           <i class="material-icons">file_upload</i>
           <p>Click or drop file here</p>
           <button id="upload-button" type="submit" class="btn btn-large btn-primary waves-effect">{{__('project/gallery.add_to_project')}}</button>
       </div>
       <span class="qq-drop-processing-selector qq-drop-processing">
           <span>Processing dropped files...</span>
           <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
       </span>

       <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
           <li>
               <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
               <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                   <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
               </div>
               <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
               <!--
               <div class="qq-thumbnail-wrapper">
                   <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale {{isset($image) ? "src=".$image:''}}>
               </div>
               -->

               <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                   <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                    Retry
               </button>

               <div class="qq-file-info">
                   <div class="qq-file-name">
                       <span class="qq-upload-file-selector qq-upload-file"></span>
                       <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                   </div>
                   <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                   <span class="qq-upload-size-selector qq-upload-size"></span>
                   <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                       <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                   </button>
                   <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                       <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                   </button>
                   <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                       <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                   </button>
               </div>
               <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">
                  <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
               </button>
           </li>
       </ul>

       <dialog class="qq-alert-dialog-selector">
           <div class="qq-dialog-message-selector"></div>
           <div class="qq-dialog-buttons">
               <button type="button" class="qq-cancel-button-selector">Close</button>
           </div>
       </dialog>

       <dialog class="qq-confirm-dialog-selector">
           <div class="qq-dialog-message-selector"></div>
           <div class="qq-dialog-buttons">
               <button type="button" class="qq-cancel-button-selector">No</button>
               <button type="button" class="qq-ok-button-selector">Yes</button>
           </div>
       </dialog>

       <dialog class="qq-prompt-dialog-selector">
           <div class="qq-dialog-message-selector"></div>
           <input type="text">
           <div class="qq-dialog-buttons">
               <button type="button" class="qq-cancel-button-selector">Cancel</button>
               <button type="button" class="qq-ok-button-selector">Ok</button>
           </div>
       </dialog>
   </div>
</script>
  </form>
