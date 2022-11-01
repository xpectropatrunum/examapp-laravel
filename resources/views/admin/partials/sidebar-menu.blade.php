<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs(['admin.dashboard', 'admin.']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        {{ __('admin.dashboard') }}
                    </p>
                </a>
            </li>


            <li class="nav-item has-treeview {{ request()->routeIs(['admin.users.*']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Users
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview {{ request()->routeIs(['admin.users.*']) ? 'd-block' : 'display-none' }}">

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ request()->routeIs(['admin.users.index']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('admin.all') }} users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.create') }}"
                            class="nav-link {{ request()->routeIs(['admin.users.create']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('admin.add') . ' ' . __('admin.new') }}</p>
                        </a>
                    </li>



                </ul>
            </li>

            <li class="nav-item has-treeview {{ request()->routeIs(['admin.exams.*']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Exams
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview {{ request()->routeIs(['admin.exams.*']) ? 'd-block' : 'display-none' }}">

                    <li class="nav-item">
                        <a href="{{ route('admin.exams.index') }}"
                            class="nav-link {{ request()->routeIs(['admin.exams.index']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('admin.all') }} exams</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.exams.create') }}"
                            class="nav-link {{ request()->routeIs(['admin.exams.create']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('admin.add') . ' ' . __('admin.new') }}</p>
                        </a>
                    </li>



                </ul>
            </li>
         
        
         
          

       

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
