<template>
    <Head title="Pengumuman" />
    <Participant>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div v-if="announcements.length === 0" class="alert alert-warning">
                      📢 Belum ada pengumuman.
                    </div>
                    <div v-for="announcement in announcements" :key="announcement.id" class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white d-flex align-items-center">
                           📢   
                            <h5 class="card-title mb-0" style="margin-left:6px">{{ announcement.title }}</h5>
                        </div>
                        <div class="card-body">
                            <div v-html="announcement.content"></div>
                            <div class="d-flex justify-content-end mt-5">
                                <i><span class="text-muted small">Diposting pada: {{ new Date(announcement.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) }}</span></i>
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

//define props
const props = defineProps({
    announcements: Array
});
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
/* Tambahkan ke file CSS atau bagian <style> di Participant/Pengumuman/Index.vue */
.card-body p[data-alert="warning"] {
    background-color: #fff3cd;
    border: 1px solid #ffecb5;
    color: #856404;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

/* Tambahkan style serupa untuk tipe alert lainnya */
</style>