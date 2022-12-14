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

            @if (auth()->guard('admin')->check())
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.users.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.users.*']) ? 'd-block' : 'display-none' }}">

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

                <li class="nav-item has-treeview {{ request()->routeIs(['admin.experts.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Experts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.experts.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.experts.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.experts.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} Experts</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.experts.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.experts.create']) ? 'active' : '' }}">
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
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.exams.*']) ? 'd-block' : 'display-none' }}">

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

                <li
                    class="nav-item has-treeview {{ request()->routeIs(['admin.exam-results.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Exam Results
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.exam-results.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.exam-results.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.exam-results.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All </p>
                            </a>
                        </li>




                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.settings.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.settings.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.settings.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>General </p>
                            </a>
                        </li>




                    </ul>
                </li>
            @else
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.users.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.users.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.users.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} users</p>
                            </a>
                        </li>

                     


                    </ul>
                </li>

             

                <li
                    class="nav-item has-treeview {{ request()->routeIs(['admin.exam-results.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Exam Results
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.exam-results.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.exam-results.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.exam-results.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All </p>
                            </a>
                        </li>




                    </ul>
                </li>
                
            @endif




        </ul>






    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
