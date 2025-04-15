<template>
    <Head>
        <title>Enrolled Participant - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <Link :href="`/admin/exam_sessions/${exam_session.id}`" class="btn btn-md btn-primary border-0 shadow" type="button">
                        <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
                    </Link>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input 
                                type="text" 
                                v-model="search" 
                                class="form-control border-0 shadow" 
                                placeholder="masukkan kata kunci..."
                            >
                            <span class="input-group-text border-0 shadow">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user-plus"></i> Enrolled Participan</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                    <thead class="thead-dark">
                                        <tr class="border-0">
                                            <th class="border-0 rounded-start" style="width:5%">
                                                <input type="checkbox" v-model="form.allSelected" @change="selectAll" />
                                            </th>
                                            <th class="border-0 text-center">Nama Partisipan</th>
                                            <th class="border-0 text-center">TREG - Area</th>
                                            <th class="border-0 text-center">Witel</th>
                                            <th class="border-0 text-center">Job Role</th>
                                        </tr>
                                    </thead>
                                    <div class="mt-3"></div>
                                    <tbody>
                                        <tr v-for="participant of participants" :key="participant.id">
                                            <td>
                                                <input type="checkbox" v-model="form.participant_id" :id="participant.id" :value="participant.id" number :checked="form.allSelected" />
                                            </td>
                                            <td>{{ participant.name }}</td>
                                            <td class="text-center">{{ participant.area.title }}</td>
                                            <td class="text-center">{{ participant.witel }}</td>
                                            <td class="text-center">{{ participant.role }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="errors.participant_id" class="alert alert-danger mt-2">
                                    {{ errors.participant_id }}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Simpan</button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import Heade and Link from Inertia
    import {
        Head,
        Link,
        router
    } from '@inertiajs/vue3';


    //import reactive from vue
    import {
      computed,
        reactive,
        ref
    } from 'vue';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
            exam: Object,
            exam_session: Object,
            participants: Array,
        },

        //inisialisasi composition API
        setup(props) {
            const search = ref('');
            
            const activeParticipants = computed(() => {
                const searchTerm = search.value.toLowerCase();
                return props.participants
                    .filter(participant => participant.status === 'Aktif')
                    .filter(participant => {
                        return participant.name.toLowerCase().includes(searchTerm) ||
                               participant.area.title.toLowerCase().includes(searchTerm) ||
                               participant.witel.toLowerCase().includes(searchTerm) ||
                               participant.role.toLowerCase().includes(searchTerm);
                    });
            });

            //define form with reactive
            const form = reactive({
                exam_id: props.exam.id,
                participant_id: [],
                allSelected: false,
            });

            //define method "selectAll"
            const selectAll = () => {
                if (form.allSelected) {
                    form.participant_id = activeParticipants.value.map(participant => participant.id);
                } else {
                    form.participant_id = [];
                }
            }

            //method "submit"
            const submit = () => {

                //send data to server
                router.post(`/admin/exam_sessions/${props.exam_session.id}/enrolled/store`, {
                    //data
                    exam_id: form.exam_id,
                    participant_id: form.participant_id,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Enrolled Participant Berhasil Disimpan!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });

            }

            //return
            return {
                form,
                selectAll,
                submit,
                search,
                participants: activeParticipants,
            };

        }

    }

</script>

<style>

</style>