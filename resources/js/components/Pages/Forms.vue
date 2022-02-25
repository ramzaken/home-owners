<template>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <router-link :to="{ name: 'home' }" v-slot="{ href, navigate }">
                            <li class="breadcrumb-item">
                                <a :href="href" @click="navigate">Home</a>
                            </li>
                        </router-link>
                        <li class="breadcrumb-item active" aria-current="page">Forms</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="my-4">
                    <h5>
                        <router-link :to="{name: 'telco_request'}" class="nav-link">Request for Telco</router-link>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</template>