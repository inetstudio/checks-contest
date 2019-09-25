<li class="{{ isActiveRoute('back.checks-contest.*') }}">
    <a href="#"><i class="fa fa-barcode"></i> <span class="nav-label">Конкурс по чекам</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        @include('admin.module.checks-contest.checks::back.includes.package_navigation')
        @include('admin.module.checks-contest.prizes::back.includes.package_navigation')
        @include('admin.module.checks-contest.statuses::back.includes.package_navigation')
    </ul>
</li>
