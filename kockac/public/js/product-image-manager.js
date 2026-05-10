
let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let currentSlot = 0;
let isMainSlot = false;

function openImageModal(slot, isMain) {
    currentSlot = slot;
    isMainSlot = isMain;
    loadImages();
    let modal = new bootstrap.Modal(document.getElementById('imageLibraryModal'));
    modal.show();
}

function selectImage(imageId, imagePath) {
    document.getElementById('preview-' + currentSlot).src = imagePath;
    let inputId = isMainSlot ? 'image-id-0' : 'image-id-' + currentSlot;
    document.getElementById(inputId).value = imageId;
    document.getElementById('detach-' + currentSlot).classList.remove('d-none');

    let modal = bootstrap.Modal.getInstance(document.getElementById('imageLibraryModal'));
    modal.hide();
}

async function uploadImage(csrfToken) {
    let input = document.getElementById('upload-input');
    if (!input.files[0]) return;

    let formData = new FormData();
    formData.append('image', input.files[0]);
    formData.append('_token', csrfToken);

    let response = await fetch('/admin/images/upload', { method: 'POST', body: formData });
    if (response.ok) {
        input.value = '';
        await loadImages();
    }
}

async function deleteImage(imageId, csrfToken) {
    if (!confirm('Delete this image?')) return;
    await fetch('/admin/images/' + imageId, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
    await loadImages();
}

function detachImage(slot, placeholder) {
    document.getElementById('preview-' + slot).src = placeholder;
    let inputId = (slot === 0) ? 'image-id-0' : 'image-id-' + slot;
    document.getElementById(inputId).value = '';
    document.getElementById('detach-' + slot).classList.add('d-none');
}
