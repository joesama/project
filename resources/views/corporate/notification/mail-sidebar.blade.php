{{-- <div class="pad-btm bord-btm">
    <a href="mailbox-compose.html" class="btn btn-block btn-success">Compose Mail</a>
</div> --}}

{{-- <p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Folders</p> --}}
<div class="list-group bg-trans pad-btm bord-btm">
    <a href="{{ handles('joesama/project::corporate/notification/list/'.$profile->corporate_id) }}" class="list-group-item mail-nav-unread">
        @php
            $unread = $profile->mails->where('read',null)->count();
        @endphp
        <i class="pli-mail-unread icon-lg icon-fw"></i> Inbox ({{ $unread }})
    </a>
{{-- 	<a href="#" class="list-group-item">
        <i class="demo-pli-pen-5 icon-lg icon-fw"></i> Draft
    </a>
    <a href="#" class="list-group-item">
        <i class="demo-pli-mail-send icon-lg icon-fw"></i> Sent
    </a>
    <a href="#" class="list-group-item mail-nav-unread">
        <i class="demo-pli-fire-flame-2 icon-lg icon-fw"></i> Spam (5)
    </a>
    <a href="#" class="list-group-item">
        <i class="demo-pli-trash icon-lg icon-fw"></i> Trash
    </a> --}}
</div>

{{-- <div class="list-group bg-trans">
    <a href="#" class="list-group-item"><i class="demo-pli-male-female icon-lg icon-fw"></i> Address Book</a>
    <a href="#" class="list-group-item"><i class="demo-pli-folder-with-document icon-lg icon-fw"></i> User Folders</a>
</div> --}}

<!-- Friends -->
{{-- <div class="list-group bg-trans pad-ver bord-ver">
    <p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Friends</p>

    <!-- Menu list item -->
    <a href="#" class="list-group-item list-item-sm">
        <span class="badge badge-purple badge-icon badge-fw pull-left"></span>
        Joey K. Greyson
    </a>
    <a href="#" class="list-group-item list-item-sm">
        <span class="badge badge-info badge-icon badge-fw pull-left"></span>
        Andrea Branden
    </a>
    <a href="#" class="list-group-item list-item-sm">
        <span class="badge badge-pink badge-icon badge-fw pull-left"></span>
        Lucy Moon
    </a>
    <a href="#" class="list-group-item list-item-sm">
        <span class="badge badge-success badge-icon badge-fw pull-left"></span>
        Johny Juan
    </a>
    <a href="#" class="list-group-item list-item-sm">
        <span class="badge badge-danger badge-icon badge-fw pull-left"></span>
        Susan Sun
    </a>
</div>

<p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Labels</p>
<ul class="list-inline mar-hor">
    <li class="tag tag-xs">
        <a href="#"><i class="demo-pli-tag"></i> Family</a>
    </li>
    <li class="tag tag-xs">
        <a href="#"><i class="demo-pli-tag"></i> Home</a>
    </li>
    <li class="tag tag-xs">
        <a href="#"><i class="demo-pli-tag"></i> Work</a>
    </li>
    <li class="tag tag-xs">
        <a href="#"><i class="demo-pli-tag"></i> Film</a>
    </li>
    <li class="tag tag-xs">
        <a href="#"><i class="demo-pli-tag"></i> Music</a>
    </li>
    <li class="tag tag-xs">
        <a href="#"><i class="demo-pli-tag"></i> Photography</a>
    </li>
</ul> --}}
