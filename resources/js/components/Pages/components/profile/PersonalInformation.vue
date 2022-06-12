<template>
    <div class="col-12 col-xl-6">
        <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                        <h6 class="mb-0">Basic Information</h6>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="javascript:;">
                        <!-- <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i> -->
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <div class="row">
                            <div class="col-4">
                                <strong class="text-dark text-sm">First Name:</strong> &nbsp;
                                <input type="text" name="first_name" class="form-control" placeholder="John" v-model.trim="$v.first_name.$model" @change="updateUser">
                                <div v-if="$v.first_name.$dirty">
                                    <div class="required" v-if="!$v.first_name.required">Field is required</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <strong class="text-dark text-sm">Middle Name:</strong> &nbsp;
                                <input type="text" name="middle_name" class="form-control" placeholder="Aramid" v-model.trim="$v.middle_name.$model" @change="updateUser">
                                <div v-if="$v.middle_name.$dirty">
                                    <div class="required" v-if="!$v.middle_name.required">Field is required</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <strong class="text-dark text-sm">Last Name:</strong> &nbsp;
                                <input type="text" name="last_name" class="form-control" placeholder="Doe" v-model.trim="$v.last_name.$model" @change="updateUser">
                                <div v-if="$v.last_name.$dirty">
                                    <div class="required" v-if="!$v.last_name.required">Field is required</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <div class="row">
                            <div class="col-4">
                                <strong class="text-dark text-sm">Birth Date:</strong> &nbsp;
                                <datepicker 
                                    v-model="birth_date" 
                                    name="uniquename" 
                                    @selected="updateUser"
                                    :bootstrap-styling="true"
                                    :typeable="true"
                                >
                                </datepicker>
                            </div>
                            <div class="col-6">
                                <strong class="text-dark text-sm">Email:</strong> &nbsp;
                                <input type="email" name="email" class="form-control" placeholder="john.doe@mail.com" v-model.trim="$v.email.$model" @change="updateUser">
                                <div v-if="$v.email.$dirty">
                                    <div class="required" v-if="!$v.email.required">Field is required</div>
                                    <div class="required" v-if="!$v.email.email">This must be an email.</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import { required, minLength, email } from 'vuelidate/lib/validators'
import Datepicker from 'vuejs-datepicker';

export default {
    props: [ 'id', 'first_name', 'middle_name', 'last_name', 'birth_date', 'email' ],
    data: function() {
        return {

        }
    },
    validations: {
        first_name: {
            required,
        },
        middle_name: {
            required,
        },
        last_name: {
            required,
        },
        email: {
            required,
            email
        },
    },
    mounted()
    {

    },
    components: {
        Datepicker
    },
    computed: {

    },
    methods: {
        error(error){
            this.$error(error)
        },
        updateUser(e){
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.$toast.error('Please fill up the missing fields.', {
                    position: 'top'
                })
            } else {
                const formData      =   {
                                            id: this.id,
                                            first_name: this.first_name,
                                            middle_name: this.middle_name,
                                            last_name: this.last_name,
                                            email: this.email,
                                            birth_date: JSON.stringify(this.birth_date)
                                        }
                this.$ajaxPost(this.$cookies.get('access_token'), formData, '/api/user/updateUser', this.success, this.error) 
            }
            e.preventDefault()
        },
        success(response){
            this.$toast.success(response, {
                position: 'top'
            })
        }
    }
}
</script>