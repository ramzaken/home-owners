<template>
    <form @submit="saveForm">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-dynamic">
                    <span class="input-group-text" id="basic-addon1"></span>
                    <input type="text" class="form-control" placeholder="Title" aria-label="Title" v-model="$v.title.$model" @input="copyToSlug">
                </div>
                <div v-if="$v.title.$dirty">
                    <div class="required" v-if="!$v.title.required">Field is required</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-dynamic">
                    <span class="input-group-text" id="basic-addon1"></span>
                    <input type="text" class="form-control" readonly placeholder="Slug" aria-label="Slug" v-model="slug">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label>Blurb</label>
                <vue-editor 
                    v-model="$v.blurb.$model" 
                />
                <div v-if="$v.blurb.$dirty">
                    <div class="required" v-if="!$v.blurb.required">Field is required</div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label>Content</label>
                <vue-editor 
                    @image-added="handleImageAdded"
                    useCustomImageHandler
                    v-model="content" 
                />
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <button class="btn btn-icon btn-3 btn-success pull-right" type="submit">
                    <span class="btn-inner--icon"><i class="material-icons">save</i></span>
                    <span class="btn-inner--text">SAVE</span>
                </button>
            </div>
        </div>
    </form>
</template>
<script>
import { VueEditor } from "vue2-editor";
import { required, minLength } from 'vuelidate/lib/validators'

export default {
    data: function() {
        return {
            isCreating: false,
            title: "",
            slug: "",
            blurb: "",
            content: "",
        }
    },
    mounted()
    {

    },
    validations: {
        title: {
            required,
        },
        blurb: {
            required
        },
    },
    components: {
		VueEditor 
    },
    computed: {

    },
    methods: {
        error(error){
            this.$error(error)
        },
        create(e){
            this.isCreating = true
            e.preventDefault()
        },
        goBack(e){
            this.isCreating = false
            e.preventDefault()
        },
        copyToSlug(e){
            this.slug   =   this.$v.title.$model.replace(/\s+/g, '-').toLowerCase();
            e.preventDefault()
        },
        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append("image", file);
            this.$ajaxPostUpload(this.$cookies.get('access_token'), formData, '/api/configurations/guidelines/imageAdded', this.imageAddedSuccess, this.imageAddedError)
        },
        saveForm(e){
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.$toast.error('Please fill up the missing fields.', {
                    position: 'top'
                })
            } else {
                var formData    =   {
                                        'title': this.title,
                                        'slug': this.slug,
                                        'blurb': JSON.parse(this.blurb),
                                        'content': JSON.parse(this.content)
                                    }

                this.$ajaxPost(this.$cookies.get('access_token'), formData, '/api/configurations/guidelines/create', this.createSuccess, this.error)
            }
            e.preventDefault()
        },
        imageAddedSuccess(response){
            const url = response; // Get url from response
            Editor.insertEmbed(cursorLocation, "image", url);
            resetUploader();
        },
        imageAddedError(response){
            console.log(response);
        },
        createSuccess(response){
            this.$toast.success(response, {
                position: 'top'
            })
        }
    }
}
</script>