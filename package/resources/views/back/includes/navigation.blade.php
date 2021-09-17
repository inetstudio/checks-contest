<li class="{{ isActiveRoute('back.receipts-contest.*', 'mm-active') }}">
    <a href="#" aria-expanded="false"><i class="fa fa-qrcode"></i> <span class="nav-label">Конкурс по чекам</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        @include('admin.module.receipts-contest.receipts::back.includes.package_navigation')
        @include('admin.module.receipts-contest.prizes::back.includes.package_navigation')
        @include('admin.module.receipts-contest.statuses::back.includes.package_navigation')
    </ul>
</li>
