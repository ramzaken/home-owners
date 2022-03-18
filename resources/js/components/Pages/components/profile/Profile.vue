<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>My Profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                <label class="bolder">First Name <span class="required">*</span></label>
                <input type="text" name="first_name" class="form-control" placeholder="John" v-model.trim="$v.first_name.$model" @change="updateUser">
                <div v-if="$v.first_name.$dirty">
                    <div class="required" v-if="!$v.first_name.required">Field is required</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                <label class="bolder">Middle Name <span class="required">*</span></label>
                <input type="text" name="middle_name" class="form-control" placeholder="Aramid" v-model.trim="$v.middle_name.$model" @change="updateUser">
                <div v-if="$v.middle_name.$dirty">
                    <div class="required" v-if="!$v.middle_name.required">Field is required</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                <label class="bolder">Last Name <span class="required">*</span></label>
                <input type="text" name="last_name" class="form-control" placeholder="Doe" v-model.trim="$v.last_name.$model" @change="updateUser">
                <div v-if="$v.last_name.$dirty">
                    <div class="required" v-if="!$v.last_name.required">Field is required</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                <label class="bolder">Email <span class="required">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="john.doe@mail.com" v-model.trim="$v.email.$model" @change="updateUser">
                <div v-if="$v.email.$dirty">
                    <div class="required" v-if="!$v.email.required">Field is required</div>
                    <div class="required" v-if="!$v.email.email">This must be an email.</div>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-2 col-lg-2 mb-3">
                <label class="bolder">Block <span class="required">*</span></label>
                <input type="number" name="block" class="form-control" v-model.trim="$v.block.$model" @change="updateLocation">
                <div v-if="$v.block.$dirty">
                    <div class="required" v-if="!$v.block.required">Field is required</div>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-2 col-lg-2 mb-3">
                <label class="bolder">Lot <span class="required">*</span></label>
                <input type="number" name="lot" class="form-control" v-model.trim="$v.lot.$model" @change="updateLocation">
                <div v-if="$v.lot.$dirty">
                    <div class="required" v-if="!$v.lot.required">Field is required</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                <label class="bolder">Contact # <span class="required">*</span></label>
                <input type="number" name="contact_number" class="form-control" v-model.trim="$v.contact_number.$model" @change="updateContact">
                <div v-if="$v.contact_number.$dirty">
                    <div class="required" v-if="!$v.contact_number.required">Field is required</div>
                    <div class="required" v-if="!$v.contact_number.minLength">Contact number must have at least {{$v.contact_number.$params.minLength.min}} 11 digits.</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-3">
                <label class="bolder">Birth Date <span class="required">*</span></label>
                <datepicker 
                    v-model="birth_date" 
                    name="uniquename" 
                    @input="updateUser"
                    bootstrap-styling="true"
                >
                </datepicker>
            </div>
        </div>
    </div>
</template>
<script>
import { required, minLength, email } from 'vuelidate/lib/validators'
import Datepicker from 'vuejs-datepicker';

export default {
    data: function() {
        return {
            id: '',
            first_name: '',
            middle_name: '',
            last_name: '',
            email: '',
            block: '',
            lot: '',
            contact_number: '',
            birth_date: ''
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
        checkUser(){
            this.$ajaxPost(this.$cookies.get('access_token'), {}, '/api/auth/user', this.checkUserSuccess, this.error)
        },
        checkUserSuccess(response){
            this.id             =   response.id
            this.first_name     =   response.first_name
            this.middle_name    =   response.middle_name
            this.last_name      =   response.last_name
            this.email          =   response.email
            this.birth_date     =   response.birth_date
            this.$ajaxPost(this.$cookies.get('access_token'), {id: response.id}, '/api/user/getUserLocation', this.getUserLocationSuccess, this.error) 
        },
        getUserLocationSuccess(response){
            this.block          =   response.block
            this.lot            =   response.lot 
            this.$ajaxPost(this.$cookies.get('access_token'), {id: response.id}, '/api/user/getUserContacts', this.getUserContactsSuccess, this.error) 
        },
        getUserContactsSuccess(response){
            this.contact_number =   response.contact_number
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