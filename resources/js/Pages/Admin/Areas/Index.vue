<template>
    <Head>
        <title>TREG - Area - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3 col-12 mb-2">
                        <Link href="/admin/areas/create" class="btn btn-md btn-primary border-0 shadow w-100" type="button"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</Link>
                    </div>
                    <div class="col-md-9 col-12 mb-2">
                        <form @submit.prevent="handleSearch">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 shadow" v-model="search" placeholder="masukkan kata kunci dan enter...">
                                <span class="input-group-text border-0 shadow">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">TREG - Area Ujian</th>
                                        <th class="border-0">Kota</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(area, index) in areas.data" :key="index">
                                        <td class="fw-bold text-center">{{ ++index + (areas.current_page - 1) * areas.per_page }}</td>
                                        <td>{{ area.title }}</td>
                                        <td>{{ area.kota }}</td>
                                        <td class="text-center">
                                            <Link :href="`/admin/areas/${area.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button"><i class="fa fa-pencil-alt"></i></Link>
                                            <button @click.prevent="destroy(area.id)" class="btn btn-sm btn-danger border-0"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="areas.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

    //import Heade and Link from Inertia
    import {
        Head,
        Link,
        router
    } from '@inertiajs/vue3';

    //import ref from vue
    import {
        ref
    } from 'vue';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {
        //layout
        layout: LayoutAdmin,

        //register component
        components: {
            Head,
            Link,
            Pagination
        },

        //props
        props: {
            areas: Object,
        },

        //inisialisasi composition API
        setup() {

            //define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));

            //define method search
            const handleSearch = () => {
                router.get('/admin/areas', {

                    //send params "q" with value from state "search"
                    q: search.value,
                });
            }

            //define method destroy
            const destroy = (id) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        router.delete(`/admin/areas/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Area Ujian Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                })
            }


            //return
            return {
                search,
                handleSearch,
                destroy,
            }

        }
    }

</script>

<style>

</style>