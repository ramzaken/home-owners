<template>
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $capitalizeFirstLetter($route.name) }}</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">{{ $capitalizeFirstLetter($route.name) }}</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                    </div>
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                    <!-- <li class="nav-item px-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0">
                            <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                        </a>
                    </li> -->
                    <li v-if="$route.name !== 'login' && $route.name !== 'register'" class="nav-item dropdown ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <font-awesome-icon icon="fa-solid fa-user-gear" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <router-link :to="{name: 'profile'}" class="dropdown-item">My Profile</router-link>
                            </li>
                            <li>
                                <a class="dropdown-item" @click="logout" href="#">Logout</a>
                            </li>
                        </ul>
                    </li>
                    <li v-else class="nav-item ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Sign In</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
        logout(e){
            this.$ajaxPost(this.$cookies.get('access_token'), {}, '/api/auth/logout', this.logoutSuccess, this.error) 
        },
        logoutSuccess(response){
            if (response) {
                this.$cookies.remove('access_token');
                this.$toast.success('logged out successfully!', {
                    position: 'top'
                })
                setTimeout(() => {
                    window.location.href = '/login'
                }, 1500)
            }
        },
        error(error){
            this.$error(error)
        },
        goToHome(e){
            this.$router.push({ path: '/' })
            e.preventDefault()
        }
    }
}
</script>