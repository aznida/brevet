<template>
    <nav id="sidebarMenu" 
         class="sidebar d-lg-block bg-gray-800 text-white collapse" 
         :class="{ 'collapsed': collapsed }" 
         data-simplebar
         @mouseenter="handleMouseEnter"
         @mouseleave="handleMouseLeave">
        <div class="sidebar-inner px-4 pt-3">
            <!-- Remove the close button div -->
            <ul class="nav flex-column pt-3 pt-md-0">

                <li class="nav-item">
                    <span class="text-center mt-2 d-flex justify-content-between">
                        <span>
                            <img 
                                src="/assets/images/logo.png" 
                                alt="Brevetisasi DEFA Logo" 
                                class="brand-logo"
                                style="height: 40px;"
                            >
                        </span>
                        <span>

                        </span>
                    </span>
                </li>

                <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/dashboard') }">
                    <Link href="/admin/dashboard" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-speedometer2 icon icon-xs me-2" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z" />
                                <path fill-rule="evenodd"
                                    d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">Dashboard</span>
                    </span>
                    </Link>
                </li>
                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/pending-exams') }">
                    <Link href="/admin/pending-exams" class="nav-link d-flex justify-content-between">
                        <span>
                            <span class="sidebar-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" 
                                    class="bi bi-hourglass icon icon-xs me-2" viewBox="0 0 16 16">
                                    <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3.5v-1h-1a.5.5 0 0 1-.5-.5zm2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13.5v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3v-1h-7z"/>
                                </svg>
                            </span>
                            <span class="sidebar-text">Progres Ujian</span>
                        </span>
                    </Link>
                </li>

                <li role="separator" class="dropdown-divider mt-2 mb-2 border-gray-700"></li>

                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/categories') }">
                    <Link href="/admin/categories" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-bookmarks icon icon-xs me-2" viewBox="0 0 16 16">
                                <path
                                    d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1H4z" />
                                <path
                                    d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">Kategori</span>
                    </span>
                    </Link>
                </li>

                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/areas') }">
                    <Link href="/admin/areas" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-back icon icon-xs me-2" viewBox="0 0 16 16">
                                <path
                                    d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">TREG-Area</span>
                    </span>
                    </Link>
                </li>

                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/participants') }">
                    <Link href="/admin/participants" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-people-fill icon icon-xs me-2" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                <path fill-rule="evenodd"
                                    d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">Partisipan</span>
                    </span>
                    </Link>
                </li>

                <li role="separator" class="dropdown-divider mt-2 mb-2 border-gray-700"></li>

                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/exams') }">
                    <Link href="/admin/exams" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-pencil-square icon icon-xs me-2" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">Ujian</span>
                    </span>
                    </Link>
                </li>
                <!---
                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/performance_assessments') }">
                    <Link href="/admin/performance_assessments" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-stopwatch icon icon-xs me-2" viewBox="0 0 16 16">
                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z" />
                                <path
                                    d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">360 Assessment</span>
                    </span>
                    </Link>
                </li>
            -->
                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/exam_sessions') }">
                    <Link href="/admin/exam_sessions" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-stopwatch icon icon-xs me-2" viewBox="0 0 16 16">
                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z" />
                                <path
                                    d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">Sesi Ujian</span>
                    </span>
                    </Link>
                </li>

                <li role="separator" class="dropdown-divider mt-2 mb-2 border-gray-700"></li>

                <li class="nav-item" :class="{ 'active': $page.url.startsWith('/admin/reports') }">
                    <Link href="/admin/reports" class="nav-link d-flex justify-content-between">
                    <span>
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-graph-up-arrow icon icon-xs me-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M0 0h1v15h15v1H0V0Zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5Z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">Laporan Hasil Ujian</span>
                    </span>
                    </Link>
                </li>

            </ul>
        </div>
    </nav>
</template>

<script>

//import Link
import { Link } from '@inertiajs/vue3';

export default {

    //register components
    components: {
        Link
    },

    data() {
        return {
            collapsed: localStorage.getItem('sidebarCollapsed') === 'true' || this.$page.props.sidebarCollapsed || false,
            isTransitioning: false,
            mouseTimer: null
        }
    },
    methods: {
        handleMouseEnter() {
            clearTimeout(this.mouseTimer);
            if (this.isTransitioning || !this.collapsed) return;
            
            this.isTransitioning = true;
            document.body.classList.remove('sidebar-collapsed');
            document.querySelector('#sidebarMenu').classList.remove('collapsed');
            
            setTimeout(() => {
                this.isTransitioning = false;
            }, 300);
        },
        handleMouseLeave() {
            if (!this.collapsed) return;
            
            clearTimeout(this.mouseTimer);
            this.mouseTimer = setTimeout(() => {
                if (this.isTransitioning) return;
                
                this.isTransitioning = true;
                document.body.classList.add('sidebar-collapsed');
                document.querySelector('#sidebarMenu').classList.add('collapsed');
                
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 300);
            }, 100);
        }
    },
    watch: {
        '$page.props.sidebarCollapsed'(newValue) {
            this.collapsed = newValue;
            localStorage.setItem('sidebarCollapsed', newValue);
            if (newValue) {
                document.body.classList.add('sidebar-collapsed');
                document.querySelector('#sidebarMenu').classList.add('collapsed');
            } else {
                document.body.classList.remove('sidebar-collapsed');
                document.querySelector('#sidebarMenu').classList.remove('collapsed');
            }
        }
    }
}
</script>

<style>
.sidebar {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    width: 250px;
    overflow: hidden;
    z-index: 1040;  /* Increased z-index to be above navbar */
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
}

.sidebar.collapsed {
    width: 70px !important;
    margin-left: 0 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.sidebar-text,
.user-card {
    opacity: 1;
    transition: opacity 0.2s ease-in-out;
}

.sidebar.collapsed .sidebar-text,
.sidebar.collapsed .user-card {
    opacity: 0;
    display: none !important;
    transition: opacity 0.2s ease-in-out;
}

.sidebar.collapsed .sidebar-icon {
    margin-right: 0 !important;
    justify-content: center;
    width: 100%;
}

.sidebar.collapsed .nav-link {
    padding: 0.5rem !important;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .sidebar {
        margin-left: -250px;
        width: 250px !important;
        transform: translateX(0);
        transition: transform 0.3s ease-in-out;
    }

    .sidebar.show {
        transform: translateX(250px);
        margin-left: -250px;
    }

    body.sidebar-mobile-open .navbar {
        transform: translateX(250px);
    }
}
</style>
