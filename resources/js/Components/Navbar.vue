<template>
    <nav class="navbar navbar-top navbar-expand navbar-dashboard bg-white navbar-light p-0">
        <div class="container-fluid p-0 m-0">
            <div class="d-flex justify-content-between w-100 px-3 ms-sidebar" id="navbarSupportedContent">
                <div class="d-flex align-items-center">
                    <!-- Add toggle button -->
                    <button class="btn btn-link text-dark me-3 toggle-btn" @click="toggleSidebar">
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="6" width="16" height="3" rx="1.5" fill="currentColor"/>
                        <rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="currentColor"/>
                        <rect opacity="0.3" width="12" height="3" rx="1.5" fill="currentColor"/>
                        </svg>
                        </span>
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
                                <!-- Hapus class d-none d-lg-block agar nama pengguna muncul di mobile -->
                                <div class="media-body ms-2 text-dark align-items-center">
                                    <span class="mb-0 font-small fw-bold text-gray-900">{{ $page.props.auth.user.name }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1 border-0 shadow">
                            <Link class="dropdown-item d-flex align-items-center" href="/logout" method="POST" as="button">
                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z" fill="currentColor"/>
                                <path d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z" fill="currentColor"/>
                                </svg>
                                </span>
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
                if (!sidebar) {
                    console.error("Element #sidebarMenu tidak ditemukan");
                    return;
                }
                sidebar.classList.toggle('show');
                
                if (sidebar.classList.contains('show')) {
                    document.body.classList.add('sidebar-mobile-open');
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.classList.remove('sidebar-mobile-open');
                    document.body.style.overflow = '';
                }
            } else {
                // Desktop behavior remains the same
                this.isSidebarCollapsed = !this.isSidebarCollapsed;
                this.$page.props.sidebarCollapsed = this.isSidebarCollapsed;
                localStorage.setItem('sidebarCollapsed', this.isSidebarCollapsed);
                document.body.classList.toggle('sidebar-collapsed');
                const sidebarMenu = document.querySelector('#sidebarMenu');
                if (sidebarMenu) {
                    sidebarMenu.classList.toggle('collapsed');
                }
            }
        }
    },
    computed: {
        getPageTitle() {
            const route = this.$page.url;
            
            // Hanya deteksi URL admin
            if (route.includes('/admin/dashboard-mitra')) return 'Dashboard Mitra';
            if (route.includes('/admin/dashboard')) return 'Dashboard Admin';
            if (route.includes('/admin/categories')) return 'Manajemen Kategori';
            if (route.includes('/admin/areas')) return 'Manajemen Area';
            if (route.includes('/admin/exams')) return 'Manajemen Ujian';
            if (route.includes('/admin/exam_sessions')) return 'Manajemen Sesi Ujian';
            if (route.includes('/admin/questions')) return 'Manajemen Soal';
            if (route.includes('/admin/participants')) return 'Manajemen Peserta';
            if (route.includes('/admin/reports')) return 'Laporan Hasil Ujian';
            if (route.includes('/admin/pending-exams')) return 'Progres Ujian';
            if (route.includes('/admin/announcements')) return '📢 Manajemen Pengumuman';
            
            // Hapus atau komentar baris ini
            // if (route.includes('/participant/dashboard')) return 'Dashboard Peserta';
            // if (route.includes('/participant/exams')) return 'Ujian';
            
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
    width: 100% !important;
    max-width: 100% !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1020 !important;  /* Lowered z-index to stay behind sidebar */
    background-color: white !important;
    box-shadow: 0 2px 4px rgba(0,0,0,.1) !important;
    transition: all 0.3s ease-in-out !important;
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
        transition: transform 0.3s ease-in-out !important;
    }

    body.sidebar-mobile-open .navbar {
        transform: translateX(0) !important;
    }

    body {
        overflow-x: hidden !important;
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
        transform: translateX(0) !important;
        position: relative !important;
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

<style>
/* Tambahkan di bagian style */
.toggle-btn {
  display: flex !important;
  align-items: center;
  justify-content: center;
}

.toggle-btn .svg-icon {
  display: inline-block !important;
  visibility: visible !important;
}
</style>