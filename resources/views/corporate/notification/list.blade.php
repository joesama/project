@extends('joesama/entree::layouts.content')
@push('content.style')
@endpush
@section('content')
<!-- MAIL INBOX -->
<!--===================================================-->
<div class="panel">
    <div class="panel-body">
        <div class="fixed-fluid">
             <div class="fixed-sm-200 pull-sm-left fixed-right-border">
				@include('joesama/project::corporate.notification.mail-sidebar')
            </div>
            <div class="fluid">
                <div id="demo-email-list">
                    <div class="row">
                        <div class="col-sm-7 toolbar-left">

                            <!-- Mail toolbar -->
                            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

                            <!--Split button dropdowns-->
{{--                             <div class="btn-group">
                                <label id="demo-checked-all-mail" for="select-all-mail" class="btn btn-default">
                            <input id="select-all-mail" class="magic-checkbox" type="checkbox">
                            <label for="select-all-mail"></label>
                                </label>
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="dropdown-caret"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" id="demo-select-all-list">All</a></li>
                                    <li><a href="#" id="demo-select-none-list">None</a></li>
                                    <li><a href="#" id="demo-select-toggle-list">Toggle</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="demo-select-read-list">Read</a></li>
                                    <li><a href="#" id="demo-select-unread-list">Unread</a></li>
                                    <li><a href="#" id="demo-select-starred-list">Starred</a></li>
                                </ul>
                            </div> --}}

                            <!--Refresh button-->
{{-- 		                    <button id="mail-ref-btn" data-toggle="panel-overlay" data-target="#demo-email-list" class="btn btn-default" type="button">
		                        <i class="demo-psi-repeat-2"></i>
		                    </button> --}}

                            <!--Dropdown button (More Action)-->
{{--                             <div class="btn-group dropdown">
	                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
	                            More <i class="dropdown-caret"></i>
	                        </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Mark as read</a></li>
                                    <li><a href="#">Mark as unread</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Star</a></li>
                                    <li><a href="#">Clear Star</a></li>
                                </ul>
                            </div> --}}
                        </div>
{{--                         <div class="col-sm-5 toolbar-right">
                            <!--Pager buttons-->
                            <span class="text-main">
                            <strong></strong>
                            of
                            <strong>160</strong>
                        </span>
                            <div class="btn-group btn-group">
                                <button class="btn btn-default" type="button">
                                <i class="psi-arrow-left"></i>
                            </button>
                                <button class="btn btn-default" type="button">
                                <i class="psi-arrow-right"></i>
                            </button>
                            </div>
                        </div> --}}
                    </div>

                    <!--Mail list group-->
                    <ul id="demo-mail-list" class="mail-list pad-top bord-top">

                    	@foreach($mailing as $mail)
                        <!--Mail list item-->
                        <li class="mail-list-unread mail-attach {{ is_null(data_get($mail,'read')) ? 'text-bold' : 'text-thin' }}">
{{--                             <div class="mail-control">
                                <input id="email-list-1" class="magic-checkbox" type="checkbox">
                                <label for="email-list-1"></label>
                            </div> --}}
                            {{-- <div class="mail-star"><a href="#"><i class="demo-psi-star"></i></a></div> --}}
                            <div class="mail-from" style="width: 250px">
                            	{{ data_get($mail,'sender.name') }}
                            </div>
                            <div class="mail-time">
                            	{{ data_get($mail,'date')->format('d-m-Y H:i:s') }}
                            </div>
                            <div class="mail-attach-icon"></div>
                            <div class="mail-subject">
                                <a href="{{ handles('joesama/project::corporate/notification/view/'.$profile->corporate_id.'/'.data_get($mail,'id')) }}">
                                	@if(data_get($mail,'read') != 1)
                                	<span class="label label-danger">
					                     New
					                </span>
					                @endif
                                	{{ data_get($mail,'title') }}
                                </a>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>


                <!--Mail footer-->
                <div class="panel-footer clearfix">
                    <div class="pull-right">
                      {{ $mailing->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===================================================-->
<!-- END OF MAIL INBOX -->
@endsection
@push('content.script')
@endpush