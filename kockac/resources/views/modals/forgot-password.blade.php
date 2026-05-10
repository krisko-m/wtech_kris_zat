<!-- Forgot Password Modal -->

<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title login-title">Forgot Password?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="forgot-form">
                    <p class="text-muted">Enter your email address and we'll send you a link to reset your password.</p>
                    <div class="mb-3">
                        <input type="email" id="forgot-email" class="form-control login-input w-100" placeholder="Email">
                        <div id="forgot-error" class="text-danger mt-1" style="display:none;">Please enter a valid email address.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" class="login-button" onclick="submitForgotPassword()">SEND RESET LINK</button>
                    </div>
                </div>

                <div id="forgot-success" style="display:none;">
                    <div class="text-center py-3">
                        <p class="description-heading">Check your inbox!</p>
                        <p class="text-muted">If an account with that email exists, we've sent a password reset link. Please check your email.</p>
                        <button type="button" class="login-button mt-2" data-bs-dismiss="modal">Back to Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
