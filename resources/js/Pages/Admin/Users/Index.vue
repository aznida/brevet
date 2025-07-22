<template>
    <Head>
        <title>Users - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12"> 
                <div class="row">
                    <div class="col-md-5 col-12 mb-2">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-2">
                                <Link href="/admin/users/create" class="btn btn-md btn-primary border-0 shadow w-100"
                                    type="button"><i class="fa fa-plus-circle"></i>
                                Tambah</Link>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-12 mb-2">
                        <div class="row">
                            <div class="col-md-8 col-12 mb-2">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            v-model="search"
                                            class="form-control border-0 shadow" 
                                            placeholder="masukkan kata kunci dan enter..."
                                        >
                                        <span class="input-group-text border-0 shadow">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">Email</th>
                                        <th class="border-0">Role</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(user, index) in users.data" :key="index">
                                        <td class="fw-bold text-center">
                                            {{ ++index + (users.current_page - 1) * users.per_page }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td class="text-center">
                                            <span v-if="user.role === 'super admin'" class="badge bg-danger">Super Admin</span>
                                            <span v-else-if="user.role === 'local admin'" class="badge bg-primary">Local Admin</span>
                                            <span v-else-if="user.role === 'mitra'" class="badge bg-success">Mitra</span>
                                            <span v-else class="badge bg-secondary">{{ user.role }}</span>
                                        </td>
                                        <td class="text-center">
                                            <Link :href="`/admin/users/${user.id}/edit`" class="btn btn-sm btn-primary border-0 shadow me-2" type="button">
                                                <i class="fa fa-pencil-alt"></i>
                                            </Link>
                                            <button @click="deleteUser(user.id)" class="btn btn-sm btn-danger border-0 shadow" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="users.links" />
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
    
    //import Head and Link from Inertia
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
            users: Object,
        },
        
        //inisialisasi composition API
        setup() {
            
            //define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));
            
            //define method search
            const handleSearch = () => {
                router.get('/admin/users', {
                    
                    //send params "q" with value from state "search"
                    q: search.value,
                });
            }
            
            //define method destroy
            const deleteUser = (id) => {
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
                        
                        router.delete(`/admin/users/${id}`);
                        
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'User Berhasil Dihapus!.',
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
                deleteUser,
            }
        }
    }
</script>