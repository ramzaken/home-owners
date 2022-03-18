<template>
	<div class="container">
		<div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                        <router-link :to="{ name: 'register' }" v-slot="{ href, navigate }">
                            <li class="breadcrumb-item">
                                <a :href="href" @click="navigate">Register</a>
                            </li>
                        </router-link>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="center">Home Owner's Association Login</h3>
            </div>
        </div>
		<div class="row">
			<div class="offset-lg-2 col-lg-8 offset-md-2 col-md-8">
				<form id="login-form">
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
					<div class="row p-2">
						<button type="submit" class="btn btn-sm btn-success" @click.prevent="submitSignUp">Login</button>
					</div>
				</form>
			</div>
		</div>
    </div>
</template>
<script>
import { required, minLength, email } from 'vuelidate/lib/validators'

export default {
    data: function() {
        return {
            name: '',
            password: ''
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
        submitSignUp(e){
        	this.$v.$touch()
			if (this.$v.$invalid) {
				this.$toast.error('Please fill up the missing fields.', {
				    position: 'top'
				})
			} else {
				const formData 	= 	{
										name: this.name,
										password: this.password
									}
				this.$ajaxPost(this.$cookies.get('access_token'), formData, '/api/auth/login', this.success, this.error)					
			}
			e.preventDefault()
        },
        success(response){
			this.$cookies.set('access_token', response.auth.original.access_token, '30D', '/')

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