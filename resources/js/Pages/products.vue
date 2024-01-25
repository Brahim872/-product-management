<template>
    <div id="main">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">List of products</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                    <a class="btn btn-primary" href="/products/create">Add Products </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <!--                            <thead>-->
                            <!--                            <tr>-->
                            <!--                                <th>name</th>-->
                            <!--                                <th>price</th>-->
                            <!--                            </tr>-->
                            <!--                            </thead>-->
                            <!--                            <tbody>-->
                            <!--                            <tr v-for="product in state.data" :key="product.id">-->
                            <!--                                <td>{{ product.name }}</td>-->
                            <!--                                <td>{{ product.price }}</td>-->
                            <!--                            </tr>-->
                            <!--                            </tbody>-->
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
</template>

<script setup>
    import {ref, onMounted} from 'vue';
    import axios from 'axios';
    import $ from 'jquery';
    import 'datatables.net';
    import Swal from 'sweetalert2';


    const data = ref({});
    const state = ref({
        data: null,
        loading: false,
        sortKey: '',
        sortOrder: 'asc',
    });
    const token = localStorage.getItem('token');
    const headers = {
        'Authorization': `Bearer ${token}`
    };


    const handleDelete = (id) => {

        axios.post('api/product-delete/' + id, {}, {
            headers
        }).then((res) => {
            console.log("suucve")
            $('#dataTable').DataTable().ajax.reload();
        }).catch((err) => {
            console.log(err)
        })
    };

    onMounted(() => {
        // Initialize DataTable manually after data is loaded

        $('#dataTable').DataTable({
            // responsive: true,
            paging: true,
            ordering: true,
            ajax: {
                url: '/api/products',
                dataSrc: 'products',
                error: function (xhr, error, thrown) {
                    console.log('DataTables error:', error);
                    console.log('XHR:', xhr);
                    console.log('Thrown:', thrown);
                },

            },

            columns: [
                {data: 'id', title: 'id'},
                {data: 'name', title: 'name'},
                {data: 'color', title: 'color'},
                {data: 'price', title: 'price'},
                {
                    data: 'discount', title: 'discount',
                    render: function (data, type, row) {

                        return (data > 0) ? data + '%' : '---';

                    },
                }
                ,
                {

                    title: 'Action',
                    render: function (data, type, row) {
                        return `
                                 <a href="/products-edit/?id=${row['id']}" class="">
                                  <i class="fas fa-fw fa-edit"></i>
                                 </a >
                             <a href="#" class="btnDelete text-danger" data-id="${row['id']}" @click="() => handleDelete(row['id'])">
                                <i class="fas fa-fw fa-trash-alt"></i>
                            </a >`;


                    }
                }
                ,
            ]
        });


        $(document).on('click', '.btnDelete', function (e) {
            // Prevent the default click behavior
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    handleDelete($(this).data('id'));
                }
            });

        });

    });

</script>

<style>
    @import 'datatables.net-dt';
</style>

<script>


    // export default {
    //     mounted() {
    //         // Initialize DataTable manually after data is loaded
    //         this.$nextTick(() => {
    //             $('#dataTable').DataTable();
    //         });
    //     },
    // };
</script>
