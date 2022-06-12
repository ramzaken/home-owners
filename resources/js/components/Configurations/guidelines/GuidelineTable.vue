<template>
    <div class="table-responsive p-0">
        <vue-good-table
            mode="remote"
            :sort-options="{
                enabled: true,
                multipleColumns: true,
                initialSortBy: [
                    {field: 'created_at', type: 'desc'},
                ]
            }"
            @on-page-change="onPageChange"
            @on-sort-change="onSortChange"
            @on-column-filter="onColumnFilter"
            @on-per-page-change="onPerPageChange"
            :totalRows="totalRecords"
            :isLoading.sync="isLoading"
            :pagination-options="{
                enabled: true,
            }"
            :columns="columns"
            :rows="rows"
            styleClass="vgt-table table align-items-center mb-0"
            theme="polar-bear" > 
            <template slot="table-row" slot-scope="props">
                <button class="btn primary" @click="onEdit(props.row.id, $event)"><i class="material-icons">edit</i></button>
            </template>
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'id'">
                    <button class="btn primary" @click="onEdit(props.row.id, $event)"><i class="material-icons">edit</i></button>
                </span>
                <span v-else>
                    {{props.formattedRow[props.column.field]}}
                </span>
            </template> 
        </vue-good-table>
    </div>
</template>
<script>
import { VueGoodTable } from 'vue-good-table';
export default {
    data: function() {
        return {
            isCreating: false,
            isLoading: false,
            columns: [
                {
                    label: 'Title',
                    field: 'title',
                },
                {
                    label: 'Blurb',
                    field: 'blurb',
                },
                {
                    label: 'Content',
                    field: 'content',
                },
                {
                    label: 'Status',
                    field: 'status',
                    type: 'number',
                },
                {
                    label: 'Created At',
                    field: 'created_at',
                    type: 'date',
                    dateInputFormat: 'yyyy-MM-dd',
                    dateOutputFormat: 'MMM do yy',
                },
                {
                    label: 'Actions',
                    field: 'id',
                    sortable: false,
                }   
            ],
            rows: [],
            totalRecords: 0,
            serverParams: {
                columnFilters: {
                },
                sort: [
                    {
                        field: '',
                        type: ''
                    }
                ],
                page: 1, 
                perPage: 10
            }
        }
    },
    mounted()
    {
        this.getGuidelines()
    },
    components: {
        VueGoodTable
    },
    computed: {

    },
    methods: {
        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps)
        },
        onPageChange(params) {
            this.updateParams({page: params.currentPage})
            this.getGuidelines()
        },
        onPerPageChange(params) {
            this.updateParams({perPage: params.currentPerPage})
            this.getGuidelines()
        },
        onSortChange(params) {
            this.updateParams({
                sort: [{
                    field: params[0].field,
                    type: params[0].type,
                }],
            });
            this.getGuidelines()
        },
        onColumnFilter(params) {
            this.updateParams(params)
            this.getGuidelines()
        },
        getGuidelines() {
            this.$ajaxPost(this.$cookies.get('access_token'), this.serverParams, '/api/configurations/guidelines/getGuidelines', this.getGuidelinesSuccess, this.error)
        },
        getGuidelinesSuccess(response){
            this.totalRecords = response.totalRecords
            this.rows = response.rows
        },
        error(error){
            this.$error(error)
        },
        onEdit(index, e){
            e.preventDefault()
        }
    }
}
</script>