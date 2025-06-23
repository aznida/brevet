<template>
    <Head>
        <title>Maintenance - Aplikasi Ujian Online</title>
    </Head>
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100">
                <div class="text-center text-md-center mb-4 mt-md-0">
                    <img src="/assets/images/favicon.png" alt="Brevetisasi DEFA Logo" class="brand-logo mb-3" style="height: 80px;">
                    <h3 class="mt-2" style="margin:0px">Sistem Sedang Dalam Pemeliharaan</h3>
                    <div class="mt-3">
                        <span class="text-muted">Mohon maaf atas ketidaknyamanan ini. Kami sedang melakukan pemeliharaan sistem untuk meningkatkan layanan kami.</span>
                    </div>
                </div>
                
                <div class="maintenance-icon text-center my-5">
                    <i class="fa fa-cogs fa-5x text-primary"></i>
                </div>
                
                <div class="text-center mb-3">
                    <h5>Sistem akan kembali online segera</h5>
                    <p class="text-muted">Tim kami sedang bekerja untuk menyelesaikan pemeliharaan ini secepat mungkin.</p>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    <a href="/" class="btn btn-primary px-4">
                        <i class="fa fa-refresh me-2"></i> Coba Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from '@inertiajs/vue3';

export default {
    components: {
        Head
    }
}
</script>

<style scoped>
.maintenance-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}
</style>