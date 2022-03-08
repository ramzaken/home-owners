<template>
	<div class="container">
		<div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <router-link :to="{ name: 'login' }" v-slot="{ href, navigate }">
                            <li class="breadcrumb-item">
                                <a :href="href" @click="navigate">Login</a>
                            </li>
                        </router-link>
                        <li class="breadcrumb-item active" aria-current="page">Register</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="center">Home Owner's Association Registration</h3>
            </div>
        </div>
		<div class="row">
			<div class="offset-lg-2 col-lg-8 offset-md-2 col-md-8">
				<form id="telco-request-form">
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
							<label class="bolder">First Name <span class="required">*</span></label>
							<input type="text" name="first_name" class="form-control" placeholder="John" v-model.trim="$v.first_name.$model">
							<div v-if="$v.first_name.$dirty">
								<div class="required" v-if="!$v.first_name.required">Field is required</div>
		  					</div>
						</div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
							<label class="bolder">Middle Name <span class="required">*</span></label>
							<input type="text" name="middle_name" class="form-control" placeholder="Aramid" v-model.trim="$v.middle_name.$model">
							<div v-if="$v.middle_name.$dirty">
								<div class="required" v-if="!$v.middle_name.required">Field is required</div>
		  					</div>
						</div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
							<label class="bolder">Last Name <span class="required">*</span></label>
							<input type="text" name="last_name" class="form-control" placeholder="Doe" v-model.trim="$v.last_name.$model">
							<div v-if="$v.last_name.$dirty">
								<div class="required" v-if="!$v.last_name.required">Field is required</div>
		  					</div>
						</div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
							<label class="bolder">Email <span class="required">*</span></label>
							<input type="email" name="email" class="form-control" placeholder="john.doe@mail.com" v-model.trim="$v.email.$model">
							<div v-if="$v.email.$dirty">
								<div class="required" v-if="!$v.email.required">Field is required</div>
								<div class="required" v-if="!$v.email.email">This must be an email.</div>
		  					</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
							<label class="bolder">Username <span class="required">*</span></label>
							<input type="text" name="name" class="form-control" placeholder="john.doe" v-model.trim="$v.name.$model">
							<div v-if="$v.name.$dirty">
								<div class="required" v-if="!$v.name.required">Field is required</div>
	  							<div class="required" v-if="!$v.name.minLength">Username must have at least {{$v.name.$params.minLength.min}} characters.</div>
		  					</div>
						</div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3">
							<label class="bolder">Password <span class="required">*</span></label>
							<input type="password" name="password" class="form-control" placeholder="******" v-model.trim="$v.password.$model">
							<div v-if="$v.password.$dirty">
								<div class="required" v-if="!$v.password.required">Field is required</div>
	  							<div class="required" v-if="!$v.password.minLength">Password must have at least {{$v.password.$params.minLength.min}} characters.</div>
		  					</div>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-6 col-sm-6 col-md-3 col-lg-3 mb-3">
							<label class="bolder">Block <span class="required">*</span></label>
							<input type="number" name="block" class="form-control" v-model.trim="$v.block.$model">
							<div v-if="$v.block.$dirty">
								<div class="required" v-if="!$v.block.required">Field is required</div>
							</div>
						</div>
						<div class="col-6 col-sm-6 col-md-3 col-lg-3 mb-3">
							<label class="bolder">Lot <span class="required">*</span></label>
							<input type="number" name="lot" class="form-control" v-model.trim="$v.lot.$model">
							<div v-if="$v.lot.$dirty">
								<div class="required" v-if="!$v.lot.required">Field is required</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-3">
							<label class="bolder">Contact # <span class="required">*</span></label>
							<input type="number" name="contact_number" class="form-control" v-model.trim="$v.contact_number.$model">
							<div v-if="$v.contact_number.$dirty">
								<div class="required" v-if="!$v.contact_number.required">Field is required</div>
	  							<div class="required" v-if="!$v.contact_number.minLength">Contact number must have at least {{$v.contact_number.$params.minLength.min}} 11 digits.</div>
							</div>
						</div>
					</div>
					<div class="row p-2">
						<button type="submit" class="btn btn-sm btn-success" @click.prevent="submitSignUp">Submit</button>
					</div>
				</form>
			</div>
		</div>
    </div>
</template>
<script>
import vueSignature from "vue-signature"
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
    	vueSignature
    },
    computed: {

    },
    methods: {
		clear(e){
			this.$refs.signature.clear()
			e.preventDefault()
		},
		undo(e){
			this.$refs.signature.undo()
			e.preventDefault()
		},
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
			this.$cookies.set('access_token', response.auth.access_token, '30D', '/')

			setTimeout(() => {
				window.location.href = '/'
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