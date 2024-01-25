<template>
    <div id="main">
        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="p-5">
                                        <div class="">
                                            <h1 class="h4 text-gray-900 mb-4">Create new product</h1>
                                        </div>
                                        <form class="user">
                                            <div class="form-group">
                                                <label for="exampleInputcategory" class="ml-2 col-form-label p-0">category
                                                     *</label>
                                                <select name="category" class="form-control" id="exampleInputcategory" v-model="category">
                                                    <option value="">---</option>
                                                    <option value="category_one">category one</option>
                                                    <option value="category_two">category two</option>
                                                    <option value="category_three">category three</option>
                                                </select>
                                                <small v-if="errors.category" class="text-danger" id="errorCategory">
                                                    {{errors.category}}</small>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName" class="ml-2 col-form-label p-0">Name
                                                     *</label>
                                                <input type="text" class="form-control "
                                                       name="name"
                                                       id="exampleInputName" v-model="name"
                                                       aria-describedby="nameHelp"
                                                >
                                                <small v-if="errors.name" class="text-danger" id="errorEmail">
                                                    {{errors.name}}</small>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputSize" class="ml-2 col-form-label p-0">Size
                                                     *</label>
                                                <select name="size" class="form-control"  id="exampleInputSize" v-model="size">
                                                    <option value="">---</option>
                                                    <option value="s">s</option>
                                                    <option value="m">m</option>
                                                    <option value="l">l</option>
                                                    <option value="xl">xl</option>
                                                    <option value="xxl">xxl</option>
                                                </select>
                                                <small v-if="errors.size" class="text-danger" id="errorSize">
                                                    {{errors.size}}</small>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputColor" class="ml-2 col-form-label p-0">Color </label>

                                                <input type="text" class="form-control "
                                                       id="exampleInputColor" v-model="color"
                                                       aria-describedby="nameHelp">
                                                <small v-if="errors.color" class="text-danger" id="errorColor">
                                                    {{errors.color}}</small>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPrice" class="ml-2 col-form-label p-0">Price
                                                     *</label>

                                                <input type="number" class="form-control "
                                                       id="exampleInputPrice" v-model="price"
                                                       aria-describedby="nameHelp">
                                                <small v-if="errors.price" class="text-danger" id="errorPrice">
                                                    {{errors.price}}</small>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputDescription" class="ml-2 col-form-label p-0">Description</label>
                                                <textarea class="form-control "
                                                          id="exampleInputDescription" v-model="description"
                                                          aria-describedby="nameHelp"></textarea>
                                                <small v-if="errors.description" class="text-danger" id="errorDescription">
                                                    {{errors.description}}</small>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPromo" class="ml-2 col-form-label p-0">Discount </label>
                                                <input class="form-control "
                                                       type="number"
                                                       min="0"
                                                       max="100"
                                                          id="exampleInputPromo" v-model="discount"
                                                          aria-describedby="nameHelp">
                                                <small v-if="errors.discount" class="text-danger" id="errorDiscount">
                                                    {{errors.discount}}</small>

                                            </div>

                                            <a href="#" @click="addProduct()" class="btn btn-primary btn-user btn-block">
                                                Submit
                                            </a>
                                        </form>
                                        <!--                                        <div class="text-center">-->
                                        <!--                                            <a class="small" href="/auth/register">Create an Account!</a>-->
                                        <!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</template>


<script setup>

    import {ref} from 'vue';

    const name = ref('');
    const size = ref('');
    const color = ref('');
    const description = ref('');
    const price = ref('');
    const category = ref('');
    const discount = ref('');

    const password = ref('');
    const errors = ref({
        name:'',
        size:'',
        color:'',
        description:'',
        price:'',
        category:'',
        discount:'',
    });

    function addProduct() {
        const token = localStorage.getItem('token');
        const headers = {
            'Authorization': `Bearer ${token}`
        };

        axios.post('/api/product-create', {

            name: name.value,
            size: size.value,
            color: color.value,
            description: description.value,
            price: price.value,
            category: category.value,
            discount: discount.value,

        },{
            headers
        }).then((res) => {
            $.notify("success", 'success')
            window.location.href = "/products";
        }).catch((err) => {
            if (err.response.data.error) {
                $.notify(err.response.data.error, 'error')
            }
            const error = err.response.data.errors;

            errors.value.name = error.name ? error.name[0] : '';
            errors.value.size = error.size ? error.size[0] : '';
            errors.value.color = error.color ? error.color[0] : '';
            errors.value.description = error.description ? error.description[0] : '';
            errors.value.price = error.price ? error.price[0] : '';
            errors.value.category = error.category ? error.category[0] : '';
        })
    }

</script>


