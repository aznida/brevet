<template>
    <div class="participant-layout">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container position-relative">
                <Link class="navbar-brand me-lg-3" href="/participant/dashboard">                
                    <span class="brand-text">BREVETISASI DEFA</span>
                </Link>
                <div v-if="$page.props.auth.participant" class="d-flex align-items-center gap-3 d-none d-lg-flex">
                    <Link 
                        href="/participant/dashboard" 
                        class="nav-link d-flex align-items-center gap-2"
                        :class="{ 'active': $page.url.startsWith('/participant/dashboard') }"
                    >
                        <i class="uil uil-estate"></i>
                        <span>Home</span>
                    </Link>
                    <Link 
                        href="/participant/results" 
                        class="nav-link d-flex align-items-center gap-2"
                        :class="{ 'active': $page.url.startsWith('/participant/results') }"
                    >
                        <i class="uil uil-chart"></i>
                        <span>Result</span>
                    </Link>
                    <Link 
                        href="/participant/history" 
                        class="nav-link d-flex align-items-center gap-2"
                        :class="{ 'active': $page.url.startsWith('/participant/history') }"
                    >
                        <i class="uil uil-history"></i>
                        <span>History</span>
                    </Link>
                    
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <div class="nav-link d-flex align-items-center gap-2" 
                             data-bs-toggle="dropdown" 
                             aria-expanded="false">
                            <div class="avatar-wrapper">
                                <img 
                                    src="https://atemis.telkom.co.id/new/media/users/profil-user.png" 
                                    alt="Profile" 
                                    class="avatar-image"
                                />
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper-lg">
                                        <img 
                                            src="https://atemis.telkom.co.id/new/media/users/profil-user.png" 
                                            alt="Profile" 
                                            class="avatar-image"
                                        />
                                    </div>
                                    <div class="ms-3">
                                        <strong>{{ $page.props.auth.participant.name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $page.props.auth.participant.role || 'Participant' }}</small>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <Link class="dropdown-item" href="/participant/profile">
                                    <i class="uil uil-user me-2"></i> Update Profil
                                </Link>
                            </li>
                            <li>
                                <Link class="dropdown-item text-danger" href="/logout" method="post" as="button">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sign out
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container content-wrapper">
            <slot />
        </div>

        <!-- Bottom Navigation untuk Mobile dengan Design Minimalis -->
        <div v-if="$page.props.auth.participant" class="mobile-nav d-lg-none">
            <Link 
                href="/participant/dashboard" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/dashboard') }"
            >
                <i class="uil uil-estate"></i>
                <span>Home</span>
            </Link>
            <Link 
                href="/participant/results" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/results') }"
            >
                <i class="uil uil-chart"></i>
                <span>Result</span>
            </Link>
            <Link 
                href="/participant/history" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/history') }"
            >
                <i class="uil uil-history"></i>
                <span>History</span>
            </Link>
            <Link 
                href="/logout"
                method="post"
                class="mobile-nav-item"
            >
                <i class="uil uil-signout"></i>
                <span>Logout</span>
            </Link>
        </div>
    </div>
</template>

<style scoped>
.participant-layout {
    padding-top: 80px;
    min-height: 100vh;
    position: relative;
}

.navbar {
    padding: 1rem 0;
    background-color: #1a2234 !important;
}

.content-wrapper {
    padding-top: 2rem;
    padding-bottom: 2rem;
    min-height: calc(100vh - 150px);
}

.brand-text {
    color: white;
    font-size: 24px;
    font-weight: bold;
    letter-spacing: 0.5px;
}

/* Style untuk Mobile Navigation yang Lebih Minimalis */
.mobile-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    background-color: #ffffff;
    display: none;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 -1px 4px rgba(0, 0, 0, 0.1);
    z-index: 9999;
}

.mobile-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #718096;
    padding: 6px; /* Menambah padding */
    transition: all 0.2s ease;
    width: 25%;
}

.mobile-nav-item i {
    font-size: 20px; /* Memperbesar ukuran icon */
    
}

.mobile-nav-item span {
    font-size: 11px; /* Memperbesar ukuran text */
    text-align: center;
    font-weight: 500; /* Menambah ketebalan font */
}

.mobile-nav-item.active {
    color: #0ea5e9; /* Warna biru modern */
    background-color: rgba(14, 165, 233, 0.1); /* Background dengan transparansi */
    box-shadow: 0 2px 8px rgba(14, 165, 233, 0.08); /* Subtle shadow untuk efek depth */
}
.mobile-nav-item:hover {
    color: #1a2234;
    background-color: rgba(26, 34, 52, 0.05);
    border-radius: 8px;
}

/* Media Query untuk Mobile */
@media (max-width: 991.98px) {
    .mobile-nav {
        display: flex !important;
    }
    
    .content-wrapper {
        padding-bottom: 100px;
    }
    
    .d-lg-flex {
        display: none !important;
    }
    
    .brand-text {
        font-size: 18px;
    }
}

.nav-link {
    color: #ffffff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    border-radius: 6px;
    position: relative;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
}

.nav-link.active {
    background-color: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 2px;
    background-color: #ffffff;
    border-radius: 2px;
}

.nav-link i {
    font-size: 1.2rem;
}

.nav-link span {
    font-weight: 500;
}

/* Avatar Styles */
.avatar-wrapper {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.2s;
}

.avatar-wrapper:hover {
    transform: scale(1.05);
}

.avatar-wrapper-lg {
    width: 56px;
    height: 56px;
    border-radius: 12px;  /* Mengubah menjadi persegi dengan radius */
    overflow: hidden;
    border: 2px solid #ffffff;
}

.avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Dropdown Styles */
.dropdown-toggle::after {
    display: none;  /* Menghilangkan tanda panah dropdown */
}

.dropdown-header {
    padding: 1rem;
    white-space: normal;
    border-bottom: 1px solid #e9ecef;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    color: #1a2234;
    text-decoration: none;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-menu {
    min-width: 280px;
    margin-top: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: none;
    border-radius: 0.5rem;
}

.dropdown-toggle::after {
    margin-left: 0.5rem;
}

.btn-light {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}

.btn-light:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
}
</style>

<script>

    //import Link
    import { Link } from '@inertiajs/vue3';

    export default {

        //register components
        components: {
            Link
        },

    }

</script>

<style>

</style>