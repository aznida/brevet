<template>
    <footer class="footer bg-white shadow-sm" style="top: 10px;">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center px-3 ms-sidebar">
                <span class="text-gray-700 text-truncate">Copyright © {{ new Date().getFullYear() }} Brevet Teams, All rights reserved.</span>
                <span class="text-primary text-nowrap">Buatan anak bangsa dengan <span class="text-danger">❤️</span></span>
            </div>
        </div>
    </footer>
</template>

<style scoped> 
.footer {
    border-radius: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    background-color: white !important;
    border-top: 1px solid #e9ecef;
    font-size: 14px;
    position: relative !important;
    bottom: 0 !important;
    z-index: 1019 !important;
    transition: transform 0.3s ease-in-out !important;
    height: 48px !important;
    display: flex !important;
    align-items: center !important;
}

/* Add this to your parent container (App.vue or layout file) */
:deep(#app), :deep(body) {
    min-height: 100vh;
    position: relative;
    padding-bottom: 48px;
}
.container-fluid {
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
}

.ms-sidebar {
    margin-left: 250px !important;
    transition: margin-left 0.3s ease-in-out !important;
    width: calc(100% - 250px) !important;
}

.sidebar-collapsed .ms-sidebar {
    margin-left: 70px !important;
    width: calc(100% - 70px) !important;
}

@media (max-width: 768px) {
    .ms-sidebar {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .footer .d-flex {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 4px;
        padding-top: 4px !important;
        padding-bottom: 4px !important;
    }

    .footer {
        height: auto !important;
    }
}
</style>