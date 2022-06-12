<template>
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="#" @click="goToHome">
                <img src="/img/icons/pagsibol.jpg" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">HOA</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link :to="{name: 'home'}" v-slot="{ href, isExactActive, navigate }">
                        <a :class="[isExactActive && 'active bg-gradient-primary'] +' nav-link text-white'" :href="href" @click="navigate">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">dashboard</i>
                            </div>
                            <span class="nav-link-text ms-1">Dashboard</span>
                        </a>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'announcements'}" v-slot="{ href, isExactActive, navigate }">
                        <a :class="[isExactActive && 'active bg-gradient-primary'] +' nav-link text-white'" :href="href" @click="navigate">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">announcement</i>
                            </div>
                            <span class="nav-link-text ms-1">Announcements</span>
                        </a>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'guidelines'}" v-slot="{ href, isExactActive, navigate }">
                        <a :class="[isExactActive && 'active bg-gradient-primary'] +' nav-link text-white'" :href="href" @click="navigate">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">rule</i>
                            </div>
                            <span class="nav-link-text ms-1">Guidelines</span>
                        </a>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'forms'}" class="nav-link text-white">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">feed</i>
                        </div>
                        <span class="nav-link-text ms-1">Forms</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">settings</i>
                        </div>
                        <span class="nav-link-text ms-1">Configurations</span>
                    </a>
                    <ul class="navbar-nav collapse" id="collapseExample">
                        <li class="nav-item nav-child">
                            <router-link :to="{name: 'announcement_configuration'}" v-slot="{ href, isExactActive, navigate }">
                                <a :class="[isExactActive && 'active bg-gradient-primary'] +' nav-link text-white'" :href="href" @click="navigate">
                                    <span class="nav-link-text ms-1">Announcements</span>
                                </a>
                            </router-link>
                        </li>
                        <li class="nav-item nav-child">
                            <router-link :to="{name: 'guideline_configuration'}" v-slot="{ href, isExactActive, navigate }">
                                <a :class="[isExactActive && 'active bg-gradient-primary'] +' nav-link text-white'" :href="href" @click="navigate">
                                    <span class="nav-link-text ms-1">Guidelines</span>
                                </a>
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <div class="mx-3">
                <a class="btn bg-gradient-primary mt-4 w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Logout</a>
            </div>
        </div>
    </aside>
</template>
<script>
export default {
    data: function() {
        return {

        }
    },
    mounted()
    {

    },
    components: {

    },
    computed: {

    },
    methods: {
        goToHome(e){
            this.$router.push({ name: 'home'})
            e.preventDefault()
        }
    }
}
</script>