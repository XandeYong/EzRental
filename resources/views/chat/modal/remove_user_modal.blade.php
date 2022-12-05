{{-- Add User Modal --}}
<div class="modal modal-lg fade" id="create_group_modal" tabindex="-1" aria-labelledby="create group modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form action="{{ route('chat.group.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create Group</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="group_name" class="form-label">Add User<span class="c-red">*</span></label>
                        <input type="text" class="form-control" name="name" value="" minlength="5" maxlength="255" id="group_name" required placeholder="Group Name...">
                        @if ($errors->has('name'))
                            <span class="c-red-error">*{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button id="visit_appointment_submit" type="submit" class="btn btn-primary">Create Group</button>
                </div>
            </form>

        </div>
    </div>
</div>