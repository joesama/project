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
        <h3 class="panel-title">{{ __('joesama/project::manager.workflow.report') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="workflow">
      <div class="panel-body text-center">
        <div class="row">
          <div class="col-md-12 pad-no mar-btm">
            <button id="monthReport" class="btn btn-dark pull-right mar-hor">
              <i class="fa fa-plus icon-fw"></i>
              {{ __('joesama/project::report.monthly.form')  }}
            </button>
            <a class="btn btn-dark pull-right mar-hor" href="{{ route('report.weekly.form',[request()->segment(4), request()->segment(5)]) }}">
              <i class="fa fa-plus icon-fw"></i>
              {{ __('joesama/project::report.weekly.form')  }}
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            {!! $weeklyReport !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            {!! $monthlyReport !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@php
  $initial = $monthlyWorkflow->first();
  $next = $monthlyWorkflow->splice(1,1)->first();
@endphp
@push('content.script')
<!--Bootbox Modals [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/bootbox/bootbox.min.js') }}"></script>
<script type="text/javascript">
    $('#monthReport').on('click', function(){
        bootbox.dialog({
            title: "{{ __('joesama/project::report.monthly.form') }} ",
            message:'<textarea id="remark" name="remark" rows="9" class="form-control" placeholder="Your content here.."></textarea>',
            buttons: {
                success: {
                    label: "{{ __('joesama/project::form.submit') . __('joesama/project::report.monthly.form') }}",
                    className: "btn-primary",
                    callback: function() {
                      var formData = new FormData();
                      formData.append('_token', '{{  csrf_token() }}');
                      formData.append('project_id', '{{ request()->segment(5) }}');
                      formData.append('start', '{{ $reportStart }}');
                      formData.append('end', '{{ $reportEnd }}');
                      formData.append('cycle', '{{ $reportDue }}');
                      formData.append('state', '{{ $initial['step'] }}');
                      formData.append('status', '{{ $initial['status'] }}');
                      formData.append('need_action', '{{ array_get($initial,'profile.id') }}');
                      formData.append('need_step', '{{ $next['step'] }}');
                      formData.append('remark', $('#remark').val());
                      formData.append('type', 'monthly');
                      formData.append('register',true);

                      var path = "{{ handles('/api/workflow/process/'.request()->segment(4).'/'.request()->segment(5)) }}"
                      var redirect = "{{ handles('/manager/project/view/'.request()->segment(4).'/'.request()->segment(5)) }}"
                      
                      swal({
                        type: 'success',
                        text: app.swalert.confirm.success,
                        showConfirmButton: false,
                        timer: 10000
                      })

                      axios.post(path,formData)
                      .then(function (response) {
                        window.location = redirect + '/' + response.data.id
                      })
                      .catch(function (error) {
                        swal(
                          'Oops...',
                          app.swalert.confirm.failed,
                          'error'
                        )
                      });
                      // $.niftyNoty({
                      //     type: 'purple',
                      //     icon : 'fa fa-check',
                      //     message : "Hello " + name + ".<br> You've chosen <strong>" + answer + "</strong>",
                      //     container : 'floating',
                      //     timer : 4000
                      // });
                    }
                }
            }
        });

        $(".demo-modal-radio").niftyCheck();
    });
</script>
@endpush