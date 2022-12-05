{{-- Add User Modal --}}
<div class="modal modal-lg fade" id="display_user_modal" tabindex="-1" aria-labelledby="modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5">Group User List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <iframe id="group_user_list_iframe" class="w-100 height-400px" src="{{ route('chat.group.user.list') }}" frameborder="0"></iframe>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>