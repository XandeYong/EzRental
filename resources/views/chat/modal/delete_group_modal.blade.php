{{-- Delete User Modal --}}
<div class="modal modal-lg fade" id="delete_group_modal" tabindex="-1" aria-labelledby="create group modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form action="{{ route('chat.group.delete') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete Group</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <input id="groupID" type="hidden" name="groupID" value="">
                    <p class="text-center w-100">Are you sure you want to leave this group?</p>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" x-confirm="confirm delete?">Delete Group</button>
                </div>
            </form>

        </div>
    </div>
</div>