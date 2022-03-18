<template>
	<section>
	    <div class="page-header min-vh-100">
	        <div class="container">
	            <div class="row">
	                <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
	                    <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('/img/pagsibol.webp'); background-repeat: no-repeat; background-size: contain;">
	                    </div>
	                </div>
	                <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
	                    <div class="card card-plain">
	                        <div class="card-header">
	                            <h4 class="font-weight-bolder">HOA Registration</h4>
	                        </div>
	                        <div class="card-body">
	                            <form role="form">
	                                <div class="input-group input-group-outline mb-3">
	                                	<label class="form-label">First Name <span class="required">*</span></label>
										<input type="text" name="first_name" class="form-control"  v-model.trim="$v.first_name.$model">
										<div v-if="$v.first_name.$dirty">
											<div class="required ms-2" v-if="!$v.first_name.required">Field is required</div>
					  					</div>
	                                </div>
	                                <div class="input-group input-group-outline mb-3">
										<label class="form-label">Middle Name <span class="required">*</span></label>
										<input type="text" name="middle_name" class="form-control"  v-model.trim="$v.middle_name.$model">
										<div v-if="$v.middle_name.$dirty">
											<div class="required ms-2" v-if="!$v.middle_name.required">Field is required</div>
					  					</div>
	                                </div>
	                                <div class="input-group input-group-outline mb-3">
										<label class="form-label">Last Name <span class="required">*</span></label>
										<input type="text" name="last_name" class="form-control"  v-model.trim="$v.last_name.$model">
										<div v-if="$v.last_name.$dirty">
											<div class="required ms-2" v-if="!$v.last_name.required">Field is required</div>
					  					</div>
	                                </div>
	                                <div class="input-group input-group-outline mb-3">
										<label class="form-label">Email <span class="required">*</span></label>
										<input type="email" name="email" class="form-control" v-model.trim="$v.email.$model">
										<div v-if="$v.email.$dirty">
											<div class="required ms-2" v-if="!$v.email.required">Field is required</div>
											<div class="required ms-2" v-if="!$v.email.email">This must be an email.</div>
					  					</div>
	                                </div>
	                                <div class="input-group input-group-outline mb-3">
	                                	<label class="form-label">Username <span class="required">*</span></label>
										<input type="text" name="name" class="form-control" v-model.trim="$v.name.$model">
										<div v-if="$v.name.$dirty">
											<div class="required ms-2" v-if="!$v.name.required">Field is required</div>
				  							<div class="required ms-2" v-if="!$v.name.minLength">Username must have at least {{$v.name.$params.minLength.min}} characters.</div>
					  					</div>
	                                </div>
	                                <div class="input-group input-group-outline mb-3">
										<label class="form-label">Password <span class="required">*</span></label>
										<input type="password" name="password" class="form-control" v-model.trim="$v.password.$model">
										<div v-if="$v.password.$dirty">
											<div class="required ms-2" v-if="!$v.password.required">Field is required</div>
				  							<div class="required ms-2" v-if="!$v.password.minLength">Password must have at least {{$v.password.$params.minLength.min}} characters.</div>
					  					</div>
	                                </div>
	                                <div class="input-group input-group-outline mb-3">
										<label class="form-label">Block <span class="required">*</span></label>
										<input type="number" name="block" class="form-control" v-model.trim="$v.block.$model">
										<div v-if="$v.block.$dirty">
											<div class="required ms-2" v-if="!$v.block.required">Field is required</div>
										</div>
									</div>
			                        <div class="input-group input-group-outline mb-3">
										<label class="form-label">Lot <span class="required">*</span></label>
										<input type="number" name="lot" class="form-control" v-model.trim="$v.lot.$model">
										<div v-if="$v.lot.$dirty">
											<div class="required ms-2" v-if="!$v.lot.required">Field is required</div>
										</div>
	                                </div>
	                                <div class="input-group input-group-outline mb-3">
			                            <label class="form-label">Contact Number <span class="required">*</span></label>
										<input type="number" name="contact_number" class="form-control" v-model.trim="$v.contact_number.$model">
										<div v-if="$v.contact_number.$dirty">
											<div class="required ms-2" v-if="!$v.contact_number.required">Field is required</div>
				  							<div class="required ms-2" v-if="!$v.contact_number.minLength">Contact number must have at least {{$v.contact_number.$params.minLength.min}} 11 digits.</div>
										</div>
	                                </div>
	                                <div class="form-check form-check-info text-start ps-0">
	                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
	                                    <label class="form-check-label" for="flexCheckDefault">
	                                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
	                                    </label>
	                                </div>
	                                <div class="text-center">
	                                    <button type="button" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" @click.prevent="submitSignUp">Sign Up</button>
	                                </div>
	                            </form>
	                        </div>
	                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
	                            <p class="mb-2 text-sm mx-auto">
	                                Already have an account?
	                                <a href="../pages/sign-in.html" class="text-primary text-gradient font-weight-bold">Sign in</a>
	                            </p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
</template>
<script>
import { required, minLength, email } from 'vuelidate/lib/validators'

export default {
    data: function() {
        return {
            name: '',
            password: '',
            first_name: '',
            middle_name: '',
            last_name: '',
            email: '',
			block: '',
			lot: '',
			contact_number: ''
        }
    },
    validations: {
    	name: {
			required,
			minLength: minLength(4)
		},
		password: {
			required,
			minLength: minLength(6)
		},
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

    },
    components: {

    },
    computed: {

    },
    methods: {
        submitSignUp(e){
        	this.$v.$touch()
			if (this.$v.$invalid) {
				this.$toast.error('Please fill up the missing fields.', {
				    position: 'top'
				})
			} else {
				const formData 	= 	{
										name: this.name,
										password: this.password,
										first_name: this.first_name,
							            middle_name: this.middle_name,
							            last_name: this.last_name,
							            email: this.email,
										block: this.block,
										lot: this.lot,
										contact_number: this.contact_number
									}
				this.$ajaxPost(this.$cookies.get('access_token'), formData, '/api/auth/register', this.success, this.error)					
			}
			e.preventDefault()
        },
        success(response){
			this.$cookies.set('access_token', response.auth.original.access_token, '30D', '/')

			setTimeout(() => {
				window.location.href = '/profile'
			}, 1500)
        },
        error(error){
			this.$toast.error(error, {
			    position: 'top'
			})
        }
    }
}
</script>