<template>
    <Head>
        <title>Profile - Aplikasi Ujian Online</title>
    </Head>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img 
                            :src="`https://ui-avatars.com/api/?name=${auth.participant.name}&background=4e73df&color=ffffff&size=100`"
                            class="rounded-circle mb-3"
                            alt="Profile Picture"
                            width="100"
                        >
                        <h4 class="fw-bold">{{ auth.participant.name }}</h4>
                        <p class="text-muted">{{ auth.participant.area.title }}</p>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                            <tbody>
                                <tr>
                                    <td class="fw-bold" width="30%">NIK</td>
                                    <td>{{ auth.participant.nik }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email</td>
                                    <td>{{ auth.participant.email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">No. HP</td>
                                    <td>{{ auth.participant.hp }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Witel</td>
                                    <td>{{ auth.participant.witel }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>
                                        <span :class="['badge', auth.participant.status === 'Aktif' ? 'bg-success' : 'bg-danger']">
                                            {{ auth.participant.status }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-4">
                        <Link
                            href="/logout"
                            method="POST"
                            as="button"
                            class="btn btn-danger"
                        >
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutParticipant from '../../../Layouts/Participant.vue';
import { Head, Link } from '@inertiajs/vue3';

export default {
    layout: LayoutParticipant,
    components: {
        Head,
        Link
    },
    props: {
        auth: Object
    }
}
</script>