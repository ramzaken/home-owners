<template>
    <div class="col-12 col-xl-6">
        <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                        <h6 class="mb-0">Contact Information</h6>
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
                                <strong class="text-dark text-sm">Block:</strong> &nbsp;
                                <input type="number" name="block" class="form-control" v-model.trim="$v.block.$model" @change="updateLocation">
                                <div v-if="$v.block.$dirty">
                                    <div class="required" v-if="!$v.block.required">Field is required</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <strong class="text-dark text-sm">Lot:</strong> &nbsp;
                                <input type="number" name="lot" class="form-control" v-model.trim="$v.lot.$model" @change="updateLocation">
                                <div v-if="$v.lot.$dirty">
                                    <div class="required" v-if="!$v.lot.required">Field is required</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark text-sm">Contact #:</strong> &nbsp;
                        <input type="number" name="contact_number" class="form-control" v-model.trim="$v.contact_number.$model" @change="updateContact">
                        <div v-if="$v.contact_number.$dirty">
                            <div class="required" v-if="!$v.contact_number.required">Field is required</div>
                            <div class="required" v-if="!$v.contact_number.minLength">Contact number must have at least {{$v.contact_number.$params.minLength.min}} 11 digits.</div>
                        </div>
                    </li>

                    <li class="list-group-item border-0 ps-0 pb-0">
                        <strong class="text-dark text-sm">Social:</strong> &nbsp;
                        <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-instagram fa-lg"></i>
                        </a>
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
    props: [ 'id', 'block', 'lot', 'contact_number' ],
    data: function() {
        return {
        }
    },
    validations: {
        block: {
            required
        },
        lot: {
            required
        },
        contact_number: {
            required,
            minLength: minLength(11)
        },
    },
    mounted()
    {
        this.checkUser();
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
        updateLocation(e){
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.$toast.error('Please fill up the missing fields.', {
                    position: 'top'
                })
            } else {
                const formData      =   {
                                            id: this.id,
                                            block: this.block,
                                            lot: this.lot
                                        }
                this.$ajaxPost(this.$cookies.get('access_token'), formData, '/api/user/updateUserLocation', this.success, this.error) 
            }
            e.preventDefault()
        },
        updateContact(e){
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.$toast.error('Please fill up the missing fields.', {
                    position: 'top'
                })
            } else {
                const formData      =   {
                                            id: this.id,
                                            contact_number: this.contact_number,
                                        }
                this.$ajaxPost(this.$cookies.get('access_token'), formData, '/api/user/updateUserContacts', this.success, this.error) 
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