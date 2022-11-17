<div id="profile" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.profile') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-dashboard"></i>
            <h5>Profile</h5>
        </a>
    </div>
</div>

<div id="room_rental_post" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.owner.room_rental_post.list') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Room Rental Post</h5>
        </a>
    </div>
</div>

<div id="digital_contract" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="#" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Digital Contract</h5>
        </a>
    </div>
</div>

<div id="rent_request" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.tenant.rentrequest') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Rent Request</h5>
        </a>
    </div>
</div>

<div id="room_visit_appointment" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.tenant.roomvisitappointment') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Room Visit Appointment</h5>
        </a>
    </div>
</div>

<div id="maintainance_request" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ URL('/dashboard/rentingrecord/maintenancerequest/indexForOwner/' . Crypt::encrypt('RRP0')) }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Maintainance Request</h5>
        </a>
    </div>
</div>

<div id="notification" class="row navlist-item">
    <div class="navlist-item-title">
        <a href="{{ route('dashboard.notification') }}" class="unselectable">
            <i class="ico-sm ico-sidebar ico-list-task"></i>
            <h5>Notification</h5>
        </a>
    </div>
</div>