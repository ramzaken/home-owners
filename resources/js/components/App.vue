<template>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <router-link :to="{name: 'home'}" class="navbar-brand">Home Owners Association</router-link>
                    <button 
                        class="navbar-toggler" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" 
                        aria-expanded="false" 
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <router-link :to="{name: 'forms'}" class="nav-link">Forms</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="py-4">
                <router-view></router-view>
            </div>
        </div>
</template>
<script>
export default {
    data: function() {
        return {
            name: '',
        }
    },
    mounted()
    {
        this.checkUser();
    },
    components: {
    },
    computed: {

    },
    methods: {
        checkUser(){
            this.$ajaxPost(this.$cookies.get('access_token'), {}, '/api/auth/user', this.success, this.error)
        },
        success(response){
            this.telco_requests     =   response.data
        },
        error(error){
            this.$toast.error(error, {
                position: 'top'
            })
        }
    }
}
</script>