<template>
    <Head title="Pengumuman" />
    <Participant>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white d-flex align-items-center">
                            <span class="svg-icon svg-icon-white svg-icon-2hx me-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor"/>
                                    <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor"/>
                                </svg>
                            </span>
                            <h5 class="card-title mb-0">Pengumuman Penting</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <span class="svg-icon svg-icon-warning svg-icon-2hx me-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor"/>
                                        <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor"/>
                                    </svg>
                                </span>
                                <div>
                                    <strong>Perhatian!</strong> Ujian akan dimulai 4 hari lagi, <b>tgl 16-30 Juni 2025</b>.
                                </div>
                            </div>
                            <p class="mb-0 mt-3">
                                Pastikan Anda telah mempersiapkan diri dengan baik untuk menghadapi ujian yang akan datang. Berikut beberapa hal yang perlu diperhatikan:
                            </p>
                            <ul class="mt-2">
                                <li>Pelajari kembali materi-materi yang telah diberikan <b><a href="https://drive.google.com/file/d/1SMfQJEKEE1-tKiiUOWUDJg9lsItNJzVd/view" style="color:red ">Link Materi</a></b></li>
                                <li>Pastikan perangkat yang akan digunakan untuk ujian berfungsi dengan baik</li>
                                <li>Siapkan koneksi internet yang stabil</li>
                                <li>Istirahat yang cukup sebelum hari ujian</li>
                                <li>Resecedule jadwal ujian jika terjadi perubahan <b><a href="https://docs.google.com/forms/d/e/1FAIpQLSdRnU9KOBE6OlSfhVNnHxxwzpR1rHRrKHIlaok0uL3x6C8zLg/viewform" style="color:red">Isi Form</a></b></li>
                                <!-- <li>Gunakan aplikasi Brempi Android untuk memudahkan ujian. <a href="https://brempi.com/assets/app/brempi.1.0.apk">Download Aplikasi</a></li> -->
                                <div class="text-center mt-3">
                                    <p class="text-muted mb-1">Download Aplikasi Mobile:</p>
                                    <div class="d-flex justify-content-center">
                                        <a href="/assets/app/brempi.1.0.apk" class="text-decoration-none">
                                            <img src="/assets/images/android.png" alt="Get it on Android" height="50">
                                        </a>
                                    </div>
                                </div>


                            </ul>
                            <div class="d-flex justify-content-end mt-5">
                                <i><span class="text-muted small">Diposting pada: {{ new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) }}</span></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Participant>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Participant from '@/Layouts/Participant.vue';
</script>

<style scoped>
.card {
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.card-header {
    padding: 1rem;
}

.alert {
    border-radius: 6px;
}

.svg-icon-warning {
    color: #ffc107;
}

.svg-icon-white {
    color: white;
}
</style>