<!-- All Reviews Modal -->

<div class="modal fade" id="allReviewsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <p class="description-heading">All Reviews - {{ $product->name }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($product->reviews->count() > 0)
                    @foreach($product->reviews as $review)
                        <div class="mb-4">
                            <div class="row mb-1">
                                <div class="col-6">
                                    <h5>{{ $review->user->first_name }} {{ $review->user->last_name }}</h5>
                                </div>
                                <div class="col-6 text-end">
                                    {{ $review->created_at ? $review->created_at->format('d.m.Y') : '' }}
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->stars ? '⭐' : '' }}
                                    @endfor
                                </div>
                                @if($review->message)
                                    <div class="col-12">
                                        <p>{{ $review->message }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @else
                    <p class="text-muted">No reviews yet.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
