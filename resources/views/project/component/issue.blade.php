<div class="panel panel-primary">
  <div class="panel-heading" id="headingIssue">
    <h4 class="panel-title">
      <a data-parent="#accordionExample" data-toggle="collapse" href="#issues" aria-expanded="true" aria-controls="budget">
          {{ __('joesama/project::project.category.issue') }}
      </a>
    </h4>
  </div>
  <div id="issues" class="panel-collapse collapse in" aria-labelledby="headingIssue" >
    <div class="panel-body">
      {!! $issueTable !!}
    </div>
  </div>
</div>