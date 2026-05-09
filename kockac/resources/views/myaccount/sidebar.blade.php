<div class="col-md-3">
    <h2 class="account-heading mb-4">My Account</h2>
    <div class="account-sidebar">
        <a href="/account" class="account-nav-item d-flex justify-content-between align-items-center {{ request()->is('account') ? 'active' : '' }}">
            Account Settings <span>›</span>
        </a>
        <a href="/account/orders" class="account-nav-item d-flex justify-content-between align-items-center {{ request()->is('account/orders') ? 'active' : '' }}">
            Orders <span>›</span>
        </a>
        <a href="/account/change-password" class="account-nav-item d-flex justify-content-between align-items-center {{ request()->is('account/change-password') ? 'active' : '' }}">
            Change Password <span>›</span>
        </a>
        <a href="/account/logout" class="account-nav-item d-flex justify-content-between align-items-center {{ request()->is('account/logout') ? 'active' : '' }}">
            Log Out <span>›</span>
        </a>
    </div>
</div>
