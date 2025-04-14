<template>
    <div class="participant-layout">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container position-relative">
                <Link class="navbar-brand me-lg-3" href="/participant/dashboard">                
                    <span class="brand-text">BREVETISASI DEFA</span>
                </Link>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    </ul>
                    <form class="d-flex" v-if="$page.props.auth.participant">
                        <Link href="/logout" method="POST" class="btn btn-light shadow" as="button">LOGOUT</Link>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container content-wrapper">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.participant-layout {
    padding-top: 80px;
}

.navbar {
    padding: 1rem 0;
    background-color: #1a2234 !important;
}

.content-wrapper {
    padding-top: 2rem;
    padding-bottom: 2rem;
    min-height: calc(100vh - 80px);
}

.brand-text {
    color: white;
    font-size: 24px;
    font-weight: bold;
    letter-spacing: 0.5px;
}

.btn-light {
    background: white;
    color: #1a2234;
    font-weight: 600;
    padding: 0.5rem 1.5rem;
}
</style>

<script>

    //import Link
    import { Link } from '@inertiajs/vue3';

    export default {

        //register components
        components: {
            Link
        },

    }

</script>

<style>

</style>