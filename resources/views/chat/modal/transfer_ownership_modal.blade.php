{{-- Add User Modal --}}
<div class="modal modal-lg fade" id="transfer_ownership_modal" tabindex="-1" aria-labelledby="create group modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form action="{{ route('chat.group.user.transfer') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Transfer Group Ownership</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <input id="groupID" type="hidden" name="groupID" value="">
                    <div class="mb-3">
                        <label for="accountID" class="form-label">User ID<span class="c-red">*</span></label>
                        <input type="text" class="form-control" name="accountID" value="" minlength="2" maxlength="255" id="accountID" required placeholder="User id...">
                        @if ($errors->has('accountID'))
                            <span class="c-red-error">*{{ $errors->first('accountID') }}</span>
                        @endif
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Transfer</button>
                </div>
            </form>

        </div>
    </div>
</div>