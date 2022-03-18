<template>
        <div>
            <aside-component></aside-component>
            <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
                <navbar-component></navbar-component>
                <div class="container-fluid py-4">
                    <router-view></router-view>
                </div>
            </main>
        </div>
</template>
<script>
import Aside from './Pages/aside/Aside.vue'
import NavBar from './Pages/navbar/NavBar.vue'
export default {
    data: function() {
        return {

        }
    },
    mounted()
    {

    },
    components: {
        'aside-component' : Aside,
        'navbar-component' : NavBar
    },
    computed: {

    },
    methods: {

    }
}
</script>