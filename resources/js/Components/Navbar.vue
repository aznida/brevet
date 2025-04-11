<template>
    <nav class="navbar navbar-top navbar-expand navbar-dashboard bg-white navbar-light p-0">
        <div class="container-fluid p-0 m-0">
            <div class="d-flex justify-content-between w-100 px-3 ms-sidebar" id="navbarSupportedContent">
                <div class="d-flex align-items-center">
                    <!-- Add toggle button -->
                    <button class="btn btn-link text-dark me-3 toggle-btn" @click="toggleSidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </button>
                    <div class="header-title">
                        <h5 class="mb-0 text-dark"><b>{{ getPageTitle }}</b></h5>
                    </div>
                </div>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center" >
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="media d-flex align-items-center">
                                <img class="avatar rounded-circle" alt="Image placeholder" :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user.name}&amp;background=4e73df&amp;color=ffffff&amp;size=100`">
                                <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                                    <span class="mb-0 font-small fw-bold text-gray-900">{{ $page.props.auth.user.name }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1 border-0 shadow">
                            <Link class="dropdown-item d-flex align-items-center" href="/logout" method="POST" as="button">
                                <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
    data() {
        return {
            isSidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' || false
        }
    },
    methods: {
        toggleSidebar() {
            if (window.innerWidth <= 768) {
                // Mobile behavior
                const sidebar = document.querySelector('#sidebarMenu');
                sidebar.classList.toggle('show');
                
                if (sidebar.classList.contains('show')) {
                    document.body.classList.add('sidebar-mobile-open');
                    this.$el.style.transform = 'translateX(250px)';
                } else {
                    document.body.classList.remove('sidebar-mobile-open');
                    this.$el.style.transform = 'translateX(0)';
                }
            } else {
                // Desktop behavior remains the same
                this.isSidebarCollapsed = !this.isSidebarCollapsed;
                this.$page.props.sidebarCollapsed = this.isSidebarCollapsed;
                localStorage.setItem('sidebarCollapsed', this.isSidebarCollapsed);
                document.body.classList.toggle('sidebar-collapsed');
                document.querySelector('#sidebarMenu').classList.toggle('collapsed');
            }
        }
    },
    computed: {
        getPageTitle() {
            const route = this.$page.url;
            
            if (route.includes('/admin/dashboard')) return 'Dashboard Admin';
            if (route.includes('/admin/categories')) return 'Manajemen Kategori';
            if (route.includes('/admin/areas')) return 'Manajemen Area';
            if (route.includes('/admin/exams')) return 'Manajemen Ujian';
            if (route.includes('/admin/exam_sessions')) return 'Manajemen Sesi Ujian';
            if (route.includes('/admin/questions')) return 'Manajemen Soal';
            if (route.includes('/admin/participants')) return 'Manajemen Peserta';
            if (route.includes('/admin/reports')) return 'Laporan Hasil Ujian';
            if (route.includes('/participant/dashboard')) return 'Dashboard Peserta';
            if (route.includes('/participant/exams')) return 'Ujian';
            
            return 'Dashboard';
        }
    },
    mounted() {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            this.isSidebarCollapsed = true;
            this.$page.props.sidebarCollapsed = true;
            document.body.classList.add('sidebar-collapsed');
            document.querySelector('#sidebarMenu').classList.add('collapsed');
        }
    }
}
</script>

<style>
.navbar {
    border-radius: 0 !important;
    margin: 0 !important;
    width: 100vw !important;
    max-width: 100vw !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1020 !important;  /* Lowered z-index to stay behind sidebar */
    background-color: white !important;
    box-shadow: 0 2px 4px rgba(0,0,0,.1) !important;
    transition: transform 0.3s ease-in-out !important;
}

.container-fluid {
    border-radius: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    width: 100% !important;
}

#navbarSupportedContent {
    height: 60px !important;
}
main {
    padding-top: 100px !important;
}
.container-fluid.px-0 {
    padding-left: 1.5rem !important;
    padding-right: 1.5rem !important;
}
h4 {
    color: #333;
    font-weight: 600;
}

.ms-sidebar {
    margin-left: 250px !important;
    transition: margin-left 0.3s ease-in-out !important;
}

.sidebar-collapsed .ms-sidebar {
    margin-left: 70px !important;
}

main {
    padding-top: 100px !important;
    margin-left: 250px !important;
    transition: margin-left 0.3s ease-in-out !important;
}

.sidebar-collapsed main {
    margin-left: 70px !important;
}

@media (max-width: 768px) {
    .ms-sidebar,
    main {
        margin-left: 0 !important;
        width: 100% !important;
        overflow-x: hidden !important;
    }

    .navbar {
        width: 100% !important;
        overflow: hidden !important;
    }

    body {
        overflow-x: hidden !important;
        overflow-y: visible !important;
        position: relative !important;
        width: 100% !important;
        height: 100% !important;
    }

    .container-fluid {
        max-width: 100% !important;
        overflow-x: hidden !important;
    }

    main {
        padding-right: 15px !important;
        padding-left: 15px !important;
        padding-bottom: 100px !important;
        height: auto !important;
        min-height: 100% !important;
        position: relative !important;
        overflow-y: visible !important;
        transform: none !important;
    }

    #app {
        height: auto !important;
        min-height: 100% !important;
        overflow-y: visible !important;
        position: relative !important;
    }

    .sidebar-mobile-open main {
        transform: translateX(250px) !important;
    }
}

.toggle-btn {
    text-decoration: none !important;
    border: none !important;
    padding: 0 !important;
}

.toggle-btn:focus {
    box-shadow: none !important;
    outline: none !important;
}

.toggle-btn:active {
    transform: none !important;
}
</style>