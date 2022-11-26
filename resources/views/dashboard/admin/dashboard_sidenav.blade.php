<div id="profile" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.profile') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-dashboard"></i>
            <h5>Profile</h5>
        </a>
    </div>
</div>

<div id="user_list" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.admin.userlist') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>User List</h5>
        </a>
    </div>
</div>

<div id="report" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.admin.report') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Report</h5>
        </a>
    </div>
</div>

@if (session()->has('account') && session()->get('account')['role'] == 'MA')
<div id="register_admin" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.admin.register_admin') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Register Admin</h5>
        </a>
    </div>
</div>
@endif
