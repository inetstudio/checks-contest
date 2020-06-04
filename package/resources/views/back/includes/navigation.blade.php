<li class="{{ isActiveRoute('back.receipts-contest.*') }}">
    <a href="#"><i class="fa fa-barcode"></i> <span class="nav-label">Конкурс по чекам</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        @include('admin.module.receipts-contest.receipts::back.includes.package_navigation')
        @include('admin.module.receipts-contest.prizes::back.includes.package_navigation')
        @include('admin.module.receipts-contest.statuses::back.includes.package_navigation')
    </ul>
</li>
