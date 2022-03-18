<template>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <router-link :to="{ name: 'home' }" v-slot="{ href, navigate }">
                            <li class="breadcrumb-item">
                                <a :href="href" @click="navigate">Home</a>
                            </li>
                        </router-link>
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <profile></profile>
        </div>
    </div>
</template>
<script>
import Profile from './components/profile/Profile'
export default {
    data: function() {
        return {

        }
    },
    mounted()
    {

    },
    components: {
        'profile': Profile
    },
    computed: {

    },
    methods: {
        
    }
}
</script>