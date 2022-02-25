<template>
	<div class="row">
		<div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6">
			<form id="telco-request-form">
				<div class="row mb-3">
					<div class="col-12">
						<label class="bolder">Full Name <span class="required">*</span></label>
						<input type="text" name="full_name" class="form-control" placeholder="John Doe" v-model.trim="$v.full_name.$model">
						<div v-if="$v.full_name.$dirty">
							<div class="required" v-if="!$v.full_name.required">Field is required</div>
	  						<div class="required" v-if="!$v.full_name.minLength">Name must have at least {{$v.full_name.$params.minLength.min}} letters.</div>
	  					</div>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-4">
						<label class="bolder">Block <span class="required">*</span></label>
						<input type="number" name="block" class="form-control" v-model.trim="$v.block.$model">
						<div v-if="$v.block.$dirty">
							<div class="required" v-if="!$v.block.required">Field is required</div>
						</div>
					</div>
					<div class="col-4">
						<label class="bolder">Lot <span class="required">*</span></label>
						<input type="number" name="lot" class="form-control" v-model.trim="$v.lot.$model">
						<div v-if="$v.lot.$dirty">
							<div class="required" v-if="!$v.lot.required">Field is required</div>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-12">
						<label class="bolder">Signature <span class="required">*</span></label>
						<vueSignature 
							ref="signature" 
							:sigOption="option" 
							:w="'300px'" 
							:h="'200px'"
							class="mb-2"
						>
						</vueSignature>
						<button @click="clear" class="btn btn-sm btn-secondary">Clear</button>
						<button @click="undo" class="btn btn-sm btn-warning">Undo</button>
					</div>
				</div>
				<div class="row p-2">
					<button type="submit" class="btn btn-sm btn-success" @click.prevent="submitSignUp">Submit</button>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
import vueSignature from "vue-signature"
import { required, minLength } from 'vuelidate/lib/validators'

export default {
    data: function() {
        return {
            full_name: '',
			block: '',
			lot: '',
			option:{
				penColor:"#000000",
				backgroundColor:"rgb(255,255,255)"
			},
        }
    },
    validations: {
		full_name: {
			required,
			minLength: minLength(4)
		},
		block: {
			required
		},
		lot: {
			required
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
				setTimeout(() => {
					var formData = new FormData()
					formData.append('file', this.$refs.signature.save())
					formData.append('full_name', this.full_name)
					formData.append('block', this.block)
					formData.append('lot', this.lot)

					axios.post('/api/telco-request/submit', formData)
					.then((response) => {
						this.$toast.success('Your name has been listed.', {
							position: 'top'
						})

						this.$v.$touch()
            			this.$v.$reset()
            			this.$refs.signature.clear()
            			this.full_name 	=	''
            			this.block 		=	''
            			this.lot 		=	''
            			
					}).catch(error => {
						this.$toast.error(error, {
						    position: 'top'
						})
					});
				}, 500)
			}

			e.preventDefault()
        }
    }
}
</script>