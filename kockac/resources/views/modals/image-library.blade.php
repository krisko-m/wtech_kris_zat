<!-- Image Library Modal -->

<div class="modal fade" id="imageLibraryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Upload Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <label class="fw-bold mb-2">Upload New Image</label>
                        <div class="d-flex gap-2">
                            <input type="file" id="upload-input" class="form-control" accept="image/*">
                            <button type="button" class="btn btn-secondary" onclick="uploadImage()">Upload</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="loadImages()">Refresh List</button>
                </div>

                <!-- Image Grid -->
                <div id="image-grid" class="row g-3">
                    <div class="text-center p-5">
                        <div class="spinner-border text-secondary" role="status"></div>
                        <p class="mt-2 text-muted">Loading library...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
