<template>
    <div class="container form-padding">
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <router-link :to="{ name: 'home' }" v-slot="{ href, navigate }">
                            <li class="breadcrumb-item">
                                <a :href="href" @click="navigate">Home</a>
                            </li>
                        </router-link>
                        <router-link :to="{ name: 'forms' }" v-slot="{ href, navigate }">
                            <li class="breadcrumb-item">
                                <a :href="href" @click="navigate">Forms</a>
                            </li>
                        </router-link>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="center">Request for Telecommunication Services Form</h3>
            </div>
        </div>
        <div v-if="!sign_up">
            <div class="row mb-4">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-primary pull-right" @click="signUp">Sign Up</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm table-hoverable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Block and Lot</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(request, r) in telco_requests" :key="r">
                                <td>{{ r + 1 }}</td>
                                <td>{{ request.full_name }}</td>
                                <td>Block {{ request.block }} Lot {{ request.lot }}</td>
                                <td><button class="btn btn-sm btn-secondary">EDIT</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <signup v-else></signup>
    </div>
</template>
<script>
import SignUp from './components/telco-requests/SignUp'
export default {
    data: function() {
        return {
            sign_up: false,
            telco_requests: []
        }
    },
    mounted()
    {
        this.getTelcoRequests()
    },
    components: {
        'signup': SignUp
    },
    computed: {

    },
    methods: {
        signUp(e){
            this.sign_up    =   true
            e.preventDefault()
        },
        getTelcoRequests(){
            this.$ajaxPost(this.$cookies.get('access_token'), {}, '/api/telco-request/getTelcoRequests', this.success, this.error)
        },
        success(response){
            this.telco_requests     =   response
        },
        error(error){
            this.$toast.error(error, {
                position: 'top'
            })
        }
    }
}
</script>