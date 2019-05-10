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
  Dropzone.autoDiscover = false;

  var dropzone = new Dropzone('#project-dropzone', {
    paramName: "upload",
    autoProcessQueue: true,
    addRemoveLinks: false,
    uploadMultiple: true,
    parallelUploads: 25,
    maxFiles: 25,
    init: function(file) {

      this.on("addedfile", function(file) {
        file._removeLink = Dropzone.createElement(`<a class="dz-remove" href="javascript:" data-dz-remove>${this.options.dictRemoveFile}</a>`);
        file.previewElement.appendChild(file._removeLink);
      });

      // this.on("completemultiple", function(file) {
      //   console.log(file)
      // });

      this.on("completemultiple", function(file) {

        var _this = this;

        for (var i = file.length - 1; i >= 0; i--) {

          var selectedFile = file[i];

          var uploadedFile = JSON.parse(selectedFile.xhr.response)[0];

          selectedFile._removeLink.setAttribute('data-id',uploadedFile.id);

          selectedFile._removeLink.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (selectedFile.upload.progress != 0) {

              var path = "{{ handles('api/upload/delete/'.request()->segment(4).'/'.request()->segment(5)) .'/' }}" + uploadedFile.id

              swal({
                  title: app.swalert.confirm.title,
                  text: app.swalert.confirm.text,
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: app.swalert.confirm.proceed,
                  cancelButtonText: app.swalert.cancel.title,
                  reverseButtons: true,
              }).then((result) => {
                if (result.value) {
                  if (selectedFile.upload.progress != 0) {
                    axios.get(path)
                    .then(function (response) {
                      swal({
                        type: 'success',
                        text: app.swalert.confirm.success,
                        showConfirmButton: false,
                        timer: 1500
                      })

                      // Remove the file preview.
                      _this.removeFile(selectedFile);

                    })
                    .catch(function (error) {
                      swal(
                        'Oops...',
                        app.swalert.confirm.failed,
                        'error'
                      )
                    });
                  }
                } else if (
                  result.dismiss === swal.DismissReason.cancel
                ) {
                  swal(
                    app.swalert.cancel.title,
                    app.swalert.cancel.text,
                    'error'
                  )
                }
              });

            }

          });

        }

      });
    },
    renameFile: function(file) {
        var dt = new Date();
        var time = dt.getTime();
       return time+file.name;
    },
  })

  function removeFile(file) {

        removeButton.addEventListener("click", function(e) {
          e.preventDefault();
          e.stopPropagation();

          if (file.upload.progress != 0) {

            var uploadedFile = JSON.parse(file.xhr.response)[0];

            var path = "{{ handles('api/upload/delete/'.request()->segment(4).'/'.request()->segment(5)) .'/' }}" + uploadedFile.id

            swal({
                title: app.swalert.confirm.title,
                text: app.swalert.confirm.text,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: app.swalert.confirm.proceed,
                cancelButtonText: app.swalert.cancel.title,
                reverseButtons: true,
            }).then((result) => {
              if (result.value) {
                if (file.upload.progress != 0) {
                  axios.get(path)
                  .then(function (response) {
                    swal({
                      type: 'success',
                      text: app.swalert.confirm.success,
                      showConfirmButton: false,
                      timer: 1500
                    })

                    // Remove the file preview.
                    _this.removeFile(file);

                  })
                  .catch(function (error) {
                    swal(
                      'Oops...',
                      app.swalert.confirm.failed,
                      'error'
                    )
                  });
                }
              } else if (
                result.dismiss === swal.DismissReason.cancel
              ) {
                swal(
                  app.swalert.cancel.title,
                  app.swalert.cancel.text,
                  'error'
                )
              }
            });

          }

        });
  }

</script>
@endpush