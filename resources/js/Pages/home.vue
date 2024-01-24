<script setup>
    import {ref} from 'vue';
    import SidbarComponent from "../Layouts/sidbarComponent.vue";
    import TopbarComponent from "../Layouts/topbarComponent.vue";
    import FooterComponent from "../Layouts/footerComponent.vue";

    const toggled = ref('');

    const logined = localStorage.getItem('token')
</script>

<template>
    <div id="main">
        <div id="wrapper">
                <SidbarComponent v-if="logined" :toggled="toggled"/>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <TopbarComponent  v-if="logined" @emitToggled="toggled=$event"/>

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <router-view></router-view>
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->
                <FooterComponent  v-if="logined" />


            </div>
            <!-- End of Content Wrapper -->
        </div>
    </div>
</template>


