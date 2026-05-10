<!-- Review Modal -->

<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="/products/{{ $product->product_id }}/reviews">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="cat-item dropdown-toggle text-center d-block" data-bs-toggle="dropdown">⭐⭐⭐⭐⭐</a>
                            <ul class="dropdown-menu" style="min-width: 100%;">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(5, this)">⭐⭐⭐⭐⭐</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(4, this)">⭐⭐⭐⭐</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(3, this)">⭐⭐⭐</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(2, this)">⭐⭐</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(1, this)">⭐</a></li>
                            </ul>
                            <input type="hidden" name="stars" id="stars-value" value="5">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Review</label>
                        <textarea name="message" class="form-control login-input" rows="4" placeholder="Write your review here...">{{ old('message') }}</textarea>
                        @error('message')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="add-to-cart btn-sm py-2 px-3">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
