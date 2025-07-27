<div class="row">
    @role('admin')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $user }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $game }}</h3>
                    <p>Total Apps</p>
                </div>
                <div class="icon">
                    <i class="nav-icon fas fa-gamepad"></i>
                </div>
                <a href="{{ route('admin.game.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $singlePush }}</h3>
                    <p>Total Single Push</p>
                </div>
                <div class="icon">
                    <i class="nav-icon fas fa-bullhorn"></i>
                </div>
                <a href="{{ route('admin.push.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $recurringPush }}</h3>
                    <p>Total Multiple Push</p>
                </div>
                <div class="icon">
                    <i class="nav-icon fas fa-hourglass"></i>
                </div>
                <a href="{{ route('admin.recurring.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endrole
</div>
