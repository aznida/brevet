<template>
    <Head>
        <title>Profile - Aplikasi Ujian Online</title>
    </Head>
    <div class="profile-container">
        <div class="profile-card">
            <!-- Header Profil yang Disederhanakan -->
            <div class="profile-header">
                <div class="profile-avatar-container">
                    <img  
                    src="/assets/images/profil-user.png" 
                        class="profile-avatar"
                        alt="Profile Picture"
                    >
                </div>
                <div class="profile-info">
                    <h3 class="profile-name">{{ auth.participant.name }}</h3>
                    <p class="profile-area text-black">{{ auth.participant.area ? auth.participant.area.title : 'Area tidak tersedia' }}</p>
                    <div class="profile-status">
                        <span :class="['status-badge', auth.participant.status === 'Aktif' ? 'status-active' : 'status-inactive']">
                            {{ auth.participant.status }}
                        </span>
                        <span style="margin-left:5px" :class="['status-badge', auth.participant.role === 'Teknisi' ? 'status-active' : 'status-inactive']">
                         {{ auth.participant.role }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Informasi Profil yang Disederhanakan -->
            <div class="profile-body">
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <h4 class="info-label">NIK</h4>
                            <p class="info-value">{{ auth.participant.nik }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h4 class="info-label">Email</h4>
                            <p class="info-value">{{ auth.participant.email }}</p>
                        </div>
                    </div>
                    
                    <!-- <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4 class="info-label">No. HP</h4>
                            <p class="info-value">{{ auth.participant.hp }}</p>
                        </div>
                    </div> -->
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-content">
                            <h4 class="info-label">Witel</h4>
                            <p class="info-value">{{ auth.participant.witel }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Aksi yang Disederhanakan -->
                <div class="profile-actions">
                    <Link
                        href="/participant/profile/edit"
                        class="action-button edit-button"
                    >
                        <i class="fas fa-edit"></i> Edit
                    </Link>
                    
                    <Link
                        href="/logout"
                        method="POST"
                        as="button"
                        class="action-button btn-danger"
                    >
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/technology/teh004.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z" fill="currentColor"/>
                                    <path d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z" fill="currentColor"/>
                                    </svg>
                                    </span>
                                    <!--end::Svg Icon--> Logout
                    </Link>
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

<style scoped>
.profile-container {
    /* padding: 1rem; */
    max-width: 100%;
    margin: 0 auto;
}

.profile-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.profile-header {
    position: relative;
    padding: 1.5rem 1rem;
    background: #f5f8fc;
    /* background: linear-gradient(135deg, #1a2234 0%, #111827 100%); */
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
}

.profile-avatar-container {
    margin-bottom: 1rem;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.profile-info {
    text-align: center;
}

.profile-name {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    /* color: white; */
}

.profile-area {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.profile-status {
    /* margin-bottom: 0.5rem; */
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-block;
}

.status-active {
    background-color: #e3fcef;
    color: #00a876;
}

.status-inactive {
    background-color: #fee2e2;
    color: #ef4444;
}

.profile-body {
    padding: 1rem;
}

.info-section {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    border-radius: 8px;
    background-color: #f5f8fc;
    border-left: 3px solid #1a2234;
}

.info-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background-color: rgba(26, 34, 52, 0.1);
    color: #1a2234;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    font-size: 1rem;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0.15rem;
    font-weight: 600;
}

.info-value {
    font-size: 0.9rem;
    color: #1e293b;
    font-weight: 500;
    margin: 0;
    word-break: break-word;
}

.profile-actions {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.75rem;
}

.action-button {
    padding: 0.6rem 0;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.edit-button {
    background-color: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.edit-button:hover {
    background-color: #e2e8f0;
}

.logout-button {
    background-color: #f8fafc;
    color: #ea4646;
    border: 1px solid #fee2e2;
}

.logout-button:hover {
    background-color: #fee2e2;
}

/* Responsive styles */
@media (min-width: 640px) {
    .profile-container {
        padding: 1.5rem;
        max-width: 540px;
    }
    
    .profile-header {
        padding: 2rem 1rem;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
    }
    
    .profile-body {
        padding: 1.5rem;
    }
    
    .info-section {
        gap: 1rem;
    }
    
    .action-button {
        padding: 0.75rem 0;
    }
}
</style>
