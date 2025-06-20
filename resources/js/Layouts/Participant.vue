<template>
    <div class="participant-layout">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container position-relative">
                <Link class="navbar-brand me-lg-3" href="/participant/dashboard">
                    <img src="/assets/images/logo.png" alt="Brevetisasi DEFA Logo" class="brand-logo">
                </Link>
                <div v-if="$page.props.auth.participant" class="d-flex align-items-center gap-3 d-none d-lg-flex">
                    <Link 
                        href="/participant/dashboard" 
                        class="nav-link d-flex align-items-center gap-2"
                        :class="{ 'active': $page.url.startsWith('/participant/dashboard') }"
                    >
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="currentColor"/>
                        <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="currentColor"/>
                        <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="currentColor"/>
                        <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="currentColor"/>
                        </svg>
                    </span>
                        <span>Home</span>
                    </Link>
                    <Link 
                        href="/participant/results" 
                        class="nav-link d-flex align-items-center gap-2"
                        :class="{ 'active': $page.url.startsWith('/participant/results') }"
                    >
                      <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/graphs/gra012.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M8.4 14L15.6 8.79999L20 9.90002V6L16 4L9 11L5 12V14H8.4Z" fill="currentColor"/>
                            <path d="M21 18H20V12L16 11L9 16H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                        <span>Result</span>
                    </Link>
                    <Link 
                        href="/participant/history" 
                        class="nav-link d-flex align-items-center gap-2"
                        :class="{ 'active': $page.url.startsWith('/participant/history') }"
                    >
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"/>
                            <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                        <span>History</span>
                    </Link>
                    <Link 
                        href="/participant/pengumuman" 
                        class="nav-link d-flex align-items-center gap-2"
                        :class="{ 'active': $page.url.startsWith('/participant/pengumuman') }"
                    >
                       <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen007.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor"/>
                        <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor"/>
                        </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <span>Notice</span>
                        <span v-if="notificationCount > 0" class="position-absolute top-0 start-100 translate-middle badge bg-danger notification-badge-desktop">
                            {{ notificationCount }}
                        </span>
                    </Link>
                     
                    
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <div class="nav-link d-flex align-items-center gap-2" 
                             data-bs-toggle="dropdown" 
                             aria-expanded="false">
                            <div class="avatar-wrapper">
                                <img 
                                    src="/assets/images/profil-user.png" 
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
                                            src="/assets/images/profil-user.png" 
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
                                   <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/communication/com013.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                    </svg>
                                    </span>
                                    <!--end::Svg Icon--> Update Profil
                                </Link>
                            </li>
                            <li>
                                <button @click="confirmLogout" class="dropdown-item text-danger d-flex align-items-center">
                                   <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/technology/teh004.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z" fill="currentColor"/>
                                    <path d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z" fill="currentColor"/>
                                    </svg>
                                    </span>
                                    <!--end::Svg Icon--> Log out
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container content-wrapper">
            <slot />
        </div>

        <!-- Mobile Navigation -->
        <div v-if="$page.props.auth.participant" class="mobile-nav d-lg-none">
            <Link 
                href="/participant/dashboard" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/dashboard') }"
            >
            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="currentColor"/>
                        <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="currentColor"/>
                        <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="currentColor"/>
                        <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="currentColor"/>
                        </svg>
                    </span>
                <span>Home</span>
            </Link> 
            <Link 
                href="/participant/history" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/history') }"
            >
                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/abstract/abs027.svg-->
                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"/>
                            <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                <span>History</span>
            </Link>
             <Link 
                href="/participant/results" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/results') }"
            >
                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/graphs/gra012.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" d="M8.4 14L15.6 8.79999L20 9.90002V6L16 4L9 11L5 12V14H8.4Z" fill="currentColor"/>
                    <path d="M21 18H20V12L16 11L9 16H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="currentColor"/>
                    </svg>
                    </span>
                    <!--end::Svg Icon-->
                <span>Result</span>
            </Link>
            <Link 
                href="/participant/pengumuman" 
                class="mobile-nav-item"
                :class="{ 'active': $page.url.startsWith('/participant/pengumuman') }"
            >
               <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen007.svg-->
                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor"/>
                <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor"/>
                </svg>
                </span>
                <!--end::Svg Icon-->
                <span>Notice</span>
                <span v-if="notificationCount > 0" class="mobile-notification-badge">{{ notificationCount }}</span>
            </Link>
            <Link 
                href="/participant/profile" 
                class="mobile-nav-item"
            >
                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/technology/teh004.svg-->
                <!-- <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z" fill="currentColor"/>
                                    <path d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z" fill="currentColor"/>
                                    </svg>
                                    </span> -->
                                    <!--end::Svg Icon-->
                                    <!-- <span>Logout</span> -->
                                     <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/communication/com013.svg-->
                                     <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                    </svg>
                                                    </span>
                                                    <!--end::Svg Icon--> 
                                                    <span>Profile</span>
            </Link>
        </div>

        <!-- Custom Logout Modal -->
        <div v-if="showLogoutModal" class="custom-modal-overlay" @click="closeModal">
            <div class="custom-modal" @click.stop>
                <div class="custom-modal-header">
                    <h5>Confirm Logout</h5>
                    <button class="close-button" @click="closeModal">&times;</button>
                </div>
                <div class="custom-modal-body">
                    Apakah kamu yakin akan keluar?
                </div>
                <div class="custom-modal-footer">
                    <button class="btn-secondary" @click="closeModal">Cancel</button>
                    <Link 
                        href="/logout" 
                        method="post" 
                        as="button" 
                        class="btn-danger"
                        @click="closeModal"
                    >Logout</Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const showLogoutModal = ref(false)
const page = usePage()

// Mendapatkan jumlah pengumuman dari shared props jika tersedia
const notificationCount = computed(() => {
    // Cek apakah ada data announcements di shared props
    if (page.props.announcements) {
        return page.props.announcements.length
    }
    return 0
})

const confirmLogout = () => {
    showLogoutModal.value = true
}

const closeModal = () => {
    showLogoutModal.value = false
}
</script>

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
    color: #fe566ee0; 
    /* background-color: rgba(14, 165, 233, 0.1);  */
    box-shadow: 0 2px 8px rgba(14, 165, 233, 0.08); /* Subtle shadow untuk efek depth */
}
.mobile-nav-item:hover {
    color: #1a2234;
    background-color: rgba(26, 34, 52, 0.05);
    border-radius: 8px;
}
.notification-badge-desktop {
    border-radius: 10px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    font-weight: bold;
    background-color: #fe566ee0 !important;
}
/* Mobile Notification Badge */
.mobile-notification-badge {
    position: absolute;
    top: 0;
    right: 25%;
    transform: translateX(5px);
    background-color: #fe566ee0;
    color: white;
    font-size: 10px;
    font-weight: bold;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.mobile-nav-item.active {
    color: #fe566ee0; /* Warna biru modern */
    /* background-color: rgba(14, 165, 233, 0.1);  */
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

.custom-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.custom-modal {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.custom-modal-header {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.custom-modal-body {
    padding: 1rem;
}

.custom-modal-footer {
    padding: 1rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.close-button {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    color: #666;
}

.btn-secondary {
    padding: 0.5rem 1rem;
    background-color: #6b7280;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-danger {
    padding: 0.5rem 1rem;
    background-color: #dc2626;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-secondary:hover {
    background-color: #4b5563;
}

.btn-danger:hover {
    background-color: #b91c1c;
}
</style>

