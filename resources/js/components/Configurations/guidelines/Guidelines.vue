<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Guidelines</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="row m-2">
                            <div class="col-12">
                                <button class="btn btn-success pull-right" @click="create" v-show="!isCreating"><i class="material-icons opacity-10">add</i></button>
                                <button class="btn btn-secondary pull-right" @click="goBack" v-show="isCreating"><i class="material-icons opacity-10">arrow_back</i></button>
                            </div>                
                        </div>
                        <div class="row m-2">
                            <div class="col-12">
                                <guideline-create v-if="isCreating"></guideline-create>
                                <guideline-table v-else></guideline-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import GuidelineTable from './GuidelineTable'
import GuidelineCreate from './GuidelineCreate'

export default {
    data: function() {
        return {
            isCreating: false
        }
    },
    mounted()
    {

    },
    components: {
        'guideline-table': GuidelineTable,
        'guideline-create': GuidelineCreate
    },
    computed: {

    },
    methods: {
        create(e){
            this.isCreating = true
            e.preventDefault()
        },
        goBack(e){
            this.isCreating = false
            e.preventDefault()
        }
    }
}
</script>