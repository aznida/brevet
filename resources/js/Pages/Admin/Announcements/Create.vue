<template>
    <Head>
        <title>Tambah Pengumuman - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/announcements" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-bell"></i> Tambah Pengumuman</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Pengumuman</label>
                                        <input type="text" class="form-control" v-model="form.title" placeholder="Judul Pengumuman">
                                        <div v-if="errors.title" class="alert alert-danger mt-2">
                                            {{ errors.title }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Isi Pengumuman</label>
                                        <editor
                                            v-model="form.content"
                                            :init="{
                                                // Ubah base_url menjadi path absolut
                                                base_url: '/assets/tinymce/js/tinymce',
                                                // Atau alternatif lain
                                                // base_url: '/assets/tinymce/js',
                                                plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                height: 400,
                                                menubar: true,
                                                branding: false,
                                                statusbar: false
                                            }"
                                            :cloud-channel="undefined"
                                        />
                                        <div v-if="errors.content" class="alert alert-danger mt-2">
                                            {{ errors.content }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" v-model="form.is_active">
                                            <option :value="true">Aktif</option>
                                            <option :value="false">Tidak Aktif</option>
                                        </select>
                                        <div v-if="errors.is_active" class="alert alert-danger mt-2">
                                            {{ errors.is_active }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2"><i class="fa fa-save"></i> Simpan</button>
                                    <button type="reset" class="btn btn-md btn-warning border-0 shadow"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
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
import { Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
// Import TinyMCE Vue Component
import Editor from '@tinymce/tinymce-vue';

export default {
    //layout
    layout: LayoutAdmin,

    //components
    components: {
        Head,
        Link,
        Editor
    },

    //props
    props: {
        errors: Object
    },

    //data function
    data() {
        return {
            form: {
                title: '',
                content: '',
                is_active: true
            }
        }
    },
    
    // Tambahkan mounted hook
    mounted() {
        // Pastikan TinyMCE dimuat dengan benar
        if (window.tinymce) {
            console.log("TinyMCE tersedia");
        } else {
            console.error("TinyMCE tidak tersedia");
            // Muat ulang script TinyMCE jika diperlukan
            const script = document.createElement('script');
            script.src = '/assets/tinymce/js/tinymce/tinymce.min.js';
            script.onload = () => {
                console.log("TinyMCE berhasil dimuat ulang");
            };
            document.head.appendChild(script);
        }
    },

    //methods
    methods: {
        submit() {
            router.post('/admin/announcements', this.form, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Pengumuman Berhasil Disimpan.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });
        }
    }
}
</script>

<style>
/* Tambahkan ke file CSS atau bagian <style> di Participant/Pengumuman/Index.vue */
.alert-warning,
.alert-info,
.alert-danger,
.alert-success {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-warning {
    background-color: #fff3cd;
    border: 1px solid #ffecb5;
    color: #856404;
}

.alert-info {
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}
</style>

// Di bagian import
import { QuillEditor, Quill } from '@vueup/vue-quill';

// Sebelum export default
const CustomButton = function(quill, options) {
    const button = document.createElement('button');
    button.innerHTML = options.buttonHTML || "&lt;&gt;";
    button.title = options.buttonTitle || "Edit HTML";
    button.className = "ql-html-edit";
    
    button.addEventListener('click', function() {
        const html = quill.root.innerHTML;
        const newHTML = prompt(options.msg || "Edit HTML:", html);
        if (newHTML !== null) {
            quill.root.innerHTML = newHTML;
        }
    });
    
    return button;
};

// Registrasi custom module
Quill.register('modules/customHTMLEdit', function(quill, options) {
    const toolbar = quill.getModule('toolbar');
    if (toolbar) {
        toolbar.addHandler('html-edit', function() {
            const html = quill.root.innerHTML;
            const newHTML = prompt(options.msg || "Edit HTML:", html);
            if (newHTML !== null) {
                quill.root.innerHTML = newHTML;
            }
        });
    }
});

// Kemudian dalam data()
editorModules: {
    toolbar: {
        handlers: {
            'html-edit': function() {}
        }
    },
    customHTMLEdit: {
        buttonHTML: "&lt;&gt;",
        buttonTitle: "Edit HTML",
        msg: "Edit HTML content:"
    }
}

// Dan tambahkan 'html-edit' ke toolbar options
:toolbar="[
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    [{ 'font': [] }],
    [{ 'size': ['small', false, 'large', 'huge'] }],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],
    [{ 'indent': '-1'}, { 'indent': '+1' }],
    [{ 'direction': 'rtl' }],
    [{ 'color': [] }, { 'background': [] }],
    [{ 'align': [] }],
    ['link', 'image', 'video', 'formula'],
    ['clean'],
    ['code-view']
]"