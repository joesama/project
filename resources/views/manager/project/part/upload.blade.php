<div class="col-md-12" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#workflow" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.project.upload') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="workflow">
      <div class="panel-body text-center approvalPanel">
          <form id="project-dropzone" action="{{ handles('api/upload/save/'.request()->segment(4).'/'.request()->segment(5)) }}" class="dropzone" enctype="multipart/form-data">
              @csrf
              <div class="dz-default dz-message">
                  <div class="dz-icon">
                      <i class="pli-upload-to-cloud icon-5x"></i>
                  </div>
                  <div>
                      <span class="dz-text">Drop files to upload</span>
                      <p class="text-sm text-muted">or click to pick manually</p>
                  </div>
              </div>
              <div class="fallback">
                  <input name="upload" id="upload" type="file" >
              </div>
          </form>
          {!! $upload !!}
      </div>
    </div>
  </div>
</div>
@push('content.style')
<link href="{{ asset('packages/joesama/entree/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endpush
@push('content.script')

<!--Dropzone [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/dropzone/dropzone.min.js') }}"></script>
<script type="text/javascript">

    Dropzone.options.projectDropzone = {
        paramName: "upload",
        autoProcessQueue: true,
        uploadMultiple: true,
        parallelUploads: 25,
        maxFiles: 25,

        // The setting up of the dropzone
        init: function() {
        var myDropzone = this;

        },
        uploadprogress: function(file, progress, bytesSent){
          if(progress == 100){
            location.reload()
          }
        }
    }

</script>
@endpush