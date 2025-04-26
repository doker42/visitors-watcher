<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">LOGO</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active disabled" aria-current="page" href="#">
                        <svg class="bi"><use xlink:href="#house-fill"/></svg>
                        {{__('Dashboard')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('visitors.visitor.list', ['id' => 1])}}">
                        <svg class="bi"><use xlink:href="#people"/></svg>
                        {{__('Visitors')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('visitors.ignored_ip.list')}}">
                        <svg class="bi"><use xlink:href="#door"/></svg>
                        {{__('IgnoredIps')}}
                    </a>
                </li>
            </ul>

            <hr class="my-3">

        </div>
    </div>
</div>