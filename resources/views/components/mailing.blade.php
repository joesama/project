<!--Notification dropdown-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<li class="dropdown">
    @php
        $mailis = $profile->mails->where('read',null)->take(10)->sortByDesc('created_at')
    @endphp
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        <i class="pli-mail icon-lg"></i>
        @if($mailis->count() > 0)
        <span class="badge badge-header badge-danger"></span>
        @endif
    </a>
    <!--Notification dropdown menu-->
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
        <div class="nano scrollable">
            <div class="nano-content">
                <ul class="head-list">
                    @foreach($mailis as $email)
                    <li>
                        <a class="media" href="{{ handles('joesama/project::corporate/notification/view/'.$profile->corporate_id.'/'.$email->id) }}">
                            <div class="media-left">
                            @if(is_null(data_get($email,'read')))  
                                <i class="pli-mail-unread icon-2x"></i>
                            @else
                                <i class="pli-mail-read icon-2x"></i>
                            @endif
                            </div>
                            <div class="media-body">
                                <p class="mar-no text-nowrap text-main text-semibold">
                                    {{ data_get($email,'title') }}
                                </p>
                                <small>                         
                                    @if(is_null(data_get($email,'read')))
                                        <span class="label label-danger">New</span>
                                    @endif
                                    {{ \Carbon\Carbon::parse($email->created_at)->diffForHumans() }}
                                </small>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!--Dropdown footer-->
        <div class="pad-all bord-top">
            <a href="{{ handles('joesama/project::corporate/notification/list/'.$profile->corporate_id) }}" class="btn-link text-main box-block">
                <i class="pci-chevron chevron-right pull-right"></i>Show All Notifications
            </a>
        </div>
    </div>
</li>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--End notifications dropdown-->