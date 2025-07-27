<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        @role('admin')
            <li class="nav-item">
                <a href="{{ route('admin.game.index') }}"
                    class="nav-link {{ Route::is('admin.game.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-gamepad"></i>
                    <p>Apps
                        <span class="badge badge-info right">{{ $gameCount }}</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.push.index') }}"
                    class="nav-link {{ Route::is('admin.push.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-bullhorn"></i>
                    <p>Single Push <span class="badge badge-danger right">{{ $signlePushCount }}</span></p>
                </a>
            </li>
            <li class="nav-item">               
                <a href="{{ route('admin.recurring.index') }}"
                    class="nav-link {{ Route::is('admin.recurring.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-hourglass"></i>
                    <p>Multiple Push <span class="badge badge-success right">{{ $recurringPushCount }}</span></p>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="#" id='deliveryToggle' class="nav-link" data-bs-toggle="collapse" data-bs-target="#deliveryMenu" aria-expanded="false" aria-controls="deliveryMenu">                    
                    <i class="nav-icon fas fa-chart-line"></i> 
                    <p>Delivery Report <i class="nav-icon fas fa-caret-down float-right"></i></p>
                </a>               
                <ul id="deliveryMenu" class="collapse list-unstyled">
                    <li class="nav-item">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa fa-check"></i>
                            <p>Send Messages
                                <span class="badge badge-info right">{{ $userCount }}</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Scheduled Messages
                                <span class="badge badge-success right">{{ $RoleCount }}</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </li> --}}
            <li class="nav-item">
                <a href="#" id='settingsToggle' class="nav-link" data-bs-toggle="collapse" data-bs-target="#settingsMenu" aria-expanded="false" aria-controls="settingsMenu">                    
                    <i class="nav-icon fas fa-user"></i> 
                    <p>Settings <i class="nav-icon fas fa-caret-down float-right"></i></p>
                </a>               
                <ul id="settingsMenu" class="collapse list-unstyled">
                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}" class="nav-link {{ Route::is('admin.user.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Users
                                <span class="badge badge-info right">{{ $userCount }}</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.role.index') }}"
                            class="nav-link {{ Route::is('admin.role.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>Role
                                <span class="badge badge-success right">{{ $RoleCount }}</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.permission.index') }}"
                            class="nav-link {{ Route::is('admin.permission.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hat-cowboy"></i>
                            <p>Permission
                                <span class="badge badge-danger right">{{ $PermissionCount }}</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.profile.edit') }}"
                            class="nav-link {{ Route::is('admin.profile.edit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endrole
       

    </ul>
</nav>
