{{-- Negotiation Modal --}}
<div class="modal modal-lg fade" id="negotiation_modal" tabindex="-1" aria-labelledby="Negotiation modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('rental_post_list.rental_post.create_negotiation') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Negotiation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @php
                        $message = 2;
                        $status = "disabled";
                        if (session()->get('account')['role'] == 'O' && $negotiation->status == 'tenant_offer') {
                            $user = "Tenant";
                        } elseif (session()->get('account')['role'] == 'T' && $negotiation->status == 'owner_offer') {
                            $user = "Owner";
                        } else {
                            $status = "";
                            $message = 1;
                            $user = "Your";
                        }
                    @endphp

                    <input type="hidden" name="id" value="{{ $negotiation->negotiation_id }}">

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="unit" class="form-label">Post ID</label>
                            <p class="form-control bg-light" readonly id="unit">{{ $negotiation->post_id }}</p>
                        </div>

                        <div class="col-md-12">
                            <label for="unit" class="form-label">Unit</label>
                            <p class="form-control bg-light" readonly id="unit">{{ $negotiation->condominium_name }}-{{ $negotiation->block }}-{{ $negotiation->floor }}-{{ $negotiation->unit }}</p>
                        </div>

                        <div class="col-md-12">
                            <label for="room" class="form-label">Room</label>
                            <p class="form-control bg-light" id="room">{{ $negotiation->room_size }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="negotiate_deposit_payment" class="form-label">Deposit Payment</label>

                        <div class="input-group mb-3">
                            <span class="input-group-text">RM</span>
                            <input type="number" class="form-control hideArrow" name="deposit_payment"
                                id="negotiate_deposit_payment"
                                aria-label="Amount (to the nearest Ringgit)" value="{{ $negotiation->deposit_price ?? 0 }}"
                                min="1">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="negotiate_monthly_payment" class="form-label">Monthly Payment</label>

                        <div class="input-group mb-3">
                            <span class="input-group-text">RM</span>
                            <input type="number" class="form-control hideArrow" name="monthly_payment"
                                id="negotiate_monthly_payment"
                                aria-label="Amount (to the nearest Ringgit)" value="{{ $negotiation->monthly_price ?? 0 }}"
                                min="1">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="negotiate_message" class="form-label">Message</label>
                        <textarea class="form-control" name="message" id="negotiate_message" placeholder="Leave a message..."
                            rows="3" maxlength="255">{{ nl2br(e($negotiation->message)) }}</textarea>
                    </div>

                    @if ($message == 2)
                    <div class="mb-3">
                        <label for="negotiate_message" class="form-label">{{ $user }}'s Message</label>
                        <p class="form-control" name="message" id="negotiate_message" placeholder="Leave a message..."
                            rows="3" maxlength="255">{{ nl2br(e($negotiation->message)) }}</p>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('chat.negotiation.reject', ['id' => $negotiation->negotiation_id]) }}" class="btn btn-danger">Reject</a>
                    <button type="submit" class="btn btn-warning">Further Negotiation</button>
                    <a class="btn btn-primary">Accept</a>
                </div>
            </form>

        </div>
    </div>
</div>