@extends('joesama/entree::layouts.content')
@push('content.style')
@endpush
@section('content')

<div class="panel">
    <div class="panel-body">
        <div class="fixed-fluid">
            <div class="fixed-sm-200 pull-sm-left fixed-right-border">
				@include('joesama/project::corporate.notification.mail-sidebar')
            </div>
            <div class="fluid">

                <!-- VIEW MESSAGE -->
                <!--===================================================-->

                <div class="mar-btm pad-btm">
                    <h1 class="page-header text-overflow">
                        {{ $email->title }}
                    </h1>
                </div>

{{--                 <div class="row">
                    <div class="col-sm-7 toolbar-left">

                        <!--Sender Information-->
                        <div class="media">
                            <span class="media-left">
                            <img src="img/profile-photos/8.png" class="img-circle img-sm" alt="Profile Picture">
                        </span>
                            <div class="media-body text-left">
                                <div class="text-bold">Lisa D. Smith</div>
                                <small class="text-muted">lisa.aqua@themeon.net</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 toolbar-right">

                        <!--Details Information-->
                        <p class="mar-no"><small class="text-muted">Monday 12, May 2016</small></p>
                        <a href="#">
                            <strong>Holiday.zip</strong>
                            <i class="demo-psi-paperclip icon-lg icon-fw"></i>
                        </a>
                    </div>
                </div> --}}
{{--                 <div class="row pad-top">
                    <div class="col-sm-7 toolbar-left">

                        <!--Mail toolbar-->
                        <button class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></button>
                        <div class="btn-group btn-group">
                            <button class="btn btn-default"><i class="demo-pli-information icon-lg"></i></button>
                            <button class="btn btn-default"><i class="demo-pli-trash icon-lg"></i> Remove</button>
                        </div>
                    </div>
                    <div class="col-sm-5 toolbar-right">
                        <!--Reply & forward buttons-->
                        <div class="btn-group btn-group">
                            <a class="btn btn-default" href="#">
                            <i class="demo-psi-left-4"></i>
                            </a>
                            <a class="btn btn-default" href="#">
                            <i class="demo-psi-right-4"></i>
                            </a>
                        </div>
                    </div>
                </div> --}}

                <!--Message-->
                <!--===================================================-->
                <div class="mail-message">
                    Greetings {{ $profile->name }},
                    <br><br> 
                    {{ $content->get(0) }}
                    <br><br>
                    {{ $content->get(1) }}
                    <br><br>
                    To Login Please Click Link Below.
                    <br>
                    <i class="psi-link icon-fw"></i>
                    <a class="text-bold text-info" href="{{ handles( $content->get('PMOIS') ) }}">
                    	{{ memorize('threef.' .\App::getLocale(). '.name', config('app.name')) }}
                    </a>
                    <br><br>
                </div>
                <!--===================================================-->
                <!--End Message-->

                <!-- Attach Files-->
                <!--===================================================-->
{{--                 <div class="pad-ver">
                    <p class="text-main text-bold box-inline"><i class="demo-psi-paperclip icon-fw"></i> Attachments <span>(2) - </span></p>
                    <a href="#" class="btn-link">Download all</a> | <a href="#" class="btn-link">View all images</a>

                    <ul class="mail-attach-list list-ov">
                        <li>
                            <a href="#" class="thumbnail">
                                <div class="mail-file-img">
                                    <img class="image-responsive" src="img/bg-img/bg-img-4.jpg" alt="image">
                                </div>
                                <div class="caption">
                                    <p class="text-main mar-no">Nature.jpg</p>
                                    <small class="text-muted">Added: May 01, 2016</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="thumbnail">
                                <div class="mail-file-img">
                                    <img class="image-responsive" src="img/bg-img/bg-img-3.jpg" alt="image">
                                </div>
                                <div class="caption">
                                    <p class="text-main mar-no">Forest.png</p>
                                    <small class="text-muted">Added: May 07, 2016</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="thumbnail">
                                <div class="mail-file-icon">
                                    <i class="demo-pli-file-csv"></i>
                                </div>
                                <div class="caption">
                                    <p class="text-main mar-no">Reports.csv</p>
                                    <small class="text-muted">Added: May 10, 2016</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="thumbnail">
                                <div class="mail-file-icon">
                                    <i class="demo-pli-file-zip"></i>
                                </div>
                                <div class="caption">
                                    <p class="text-main mar-no">Project.zip</p>
                                    <small class="text-muted">Added: May 10, 2016</small>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div> --}}
                <!--===================================================-->
                <!-- End Attach Files-->


                <!--Quick reply : Summernote Placeholder -->
{{--                 <div id="demo-mail-textarea" class="mail-message-reply bg-trans-dark">
                    <strong>Reply</strong> or <strong>Forward</strong> this message...
                </div> --}}

                <!--Send button-->
{{--                 <div class="pad-btm">
                    <button id="demo-mail-send-btn" type="button" class="btn btn-primary btn-lg btn-block hide">
                    <span class="demo-psi-mail-send icon-lg icon-fw"></span>
                    Send Message
                	</button>
                </div> --}}
                <!--===================================================-->
                <!-- END VIEW MESSAGE -->

            </div>
        </div>
    </div>
</div>


@endsection
@push('content.script')
@endpush