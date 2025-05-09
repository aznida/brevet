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
                        class="btn btn-primary d-flex align-items-center gap-2"
                    >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </Link>
                    <Link 
                        href="/participant/results" 
                        class="btn btn-success text-white d-flex align-items-center gap-2"
                    >
                        <i class="fas fa-chart-bar"></i>
                        <span>Result</span>
                    </Link>
                    <Link 
                        href="/logout" 
                        method="POST" 
                        class="btn btn-danger d-flex align-items-center gap-2" 
                        as="button"
                    >
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </Link>
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
                href="/participant/profile" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/profile') }"
            >
                <i class="uil uil-user"></i>
                <span>Profile</span>
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
    padding: 10px 20px;
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
    padding: 4px;
    transition: all 0.2s ease;
    width: 25%;
}

.mobile-nav-item i {
    font-size: 16px;
    margin-bottom: 2px;
}

.mobile-nav-item span {
    font-size: 9px;
    text-align: center;
}

.mobile-nav-item.active {
    color: #6366f1;
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