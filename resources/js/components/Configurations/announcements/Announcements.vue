<template>
    <div class="container-fluid py-4">
        <announcement-table></announcement-table>
    </div>
</template>
<script>
import AnnouncementTable from './AnnouncementTable'
export default {
    data: function() {
        return {

        }
    },
    mounted()
    {

    },
    components: {
        'announcement-table': AnnouncementTable
    },
    computed: {

    },
    methods: {
        
    }
}
</script>