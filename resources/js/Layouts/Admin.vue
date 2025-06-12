<template>
    <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
        <a class="navbar-brand me-lg-5" href="/">
            <img class="navbar-brand-dark" src="/assets/images/logo.png" alt="Logo" style="height: 40px;"/> 
        </a>
        <div class="d-flex align-items-center">
            <!-- Ubah tombol toggle untuk memanggil fungsi toggleSidebar di Navbar.vue -->
            <button class="navbar-toggler d-lg-none" type="button" @click="toggleMobileSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <Sidebar ref="sidebar" />

    <main class="content">
        <Navbar ref="navbar" />
        
        <div class="content-wrapper">
            <!-- Wrap slot in a div to better control rendering -->
            <slot v-if="$slots.default"></slot>
        </div>
    </main>
    
    <!-- Footer at the bottom -->
    <Footer />
</template>

<script>
    //import navbar
    import Navbar from "../Components/Navbar.vue";

    //import sidebar
    import Sidebar from '../Components/Sidebar.vue';
    import Footer from "../Components/Footer.vue";

    export default {
        //register components
        components: {
            Navbar,
            Sidebar,
            Footer,
        },
        methods: {
            // Tambahkan method untuk toggle sidebar di mobile
            toggleMobileSidebar() {
                // Akses method toggleSidebar di komponen Navbar
                this.$refs.navbar.toggleSidebar();
            }
        }
    }
</script>

<style>
.content {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.content-wrapper {
    flex: 1;
    transition: transform 0.3s ease-in-out;
}

/* CSS Global untuk sidebar dan navbar mobile */
#app {
    overflow-x: hidden;
    position: relative;
    min-height: 100vh;
}

body.sidebar-mobile-open {
    overflow: hidden;
}

/* Overlay untuk mobile sidebar */
body.sidebar-mobile-open::after {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1030;
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
    pointer-events: auto;
}

@media (max-width: 768px) {
    main, .content-wrapper {
        transition: transform 0.3s ease-in-out !important;
    }
    
    body.sidebar-mobile-open main,
    body.sidebar-mobile-open .content-wrapper {
        transform: translateX(250px) !important;
    }
    
    /* Tambahkan ini untuk memastikan transisi kembali berjalan mulus */
    main, .content-wrapper {
        transform: translateX(0) !important;
    }
}
</style>