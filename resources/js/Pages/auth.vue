<script setup>
    import {ref} from 'vue';
</script>

<template>
    <div id="main">
        <div id="wrapper">
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <router-view></router-view>
                    </div>
                    <!-- /.container-fluid -->

                </div>


            </div>
            <!-- End of Content Wrapper -->
        </div>
    </div>
</template>


