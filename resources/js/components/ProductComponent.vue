<template>
  <div class="productComponent">
    <div class="container my-5">
      <div class="row d-flex justify-content-end my-3">
        <div class="col-md-5">
          <button class="btn btn-primary" @click="create">
            <i class="fas fa-plus-circle me-2"></i>
            Create
          </button>
        </div>
        <!--Search Product-->
        <div class="col-md-3">
          <form @submit.prevent="view">
            <div class="input-group">
              <input
                type="text"
                v-model="search"
                class="form-control"
                placeholder="Searh Product"
              />
              <button :form="form" class="btn btn-primary">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </div>
        <!--end Search-->
      </div>

      <div class="row">
        <!--Input Form-->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h4>{{ isEditMode ? "Edit" : "Create" }}</h4>
            </div>
            <div class="card-body">
              <form
                @submit.prevent="isEditMode ? update() : store()"
                @keydown="form.onKeydown($event)"
              >
                <div class="form-group my-3">
                  <label for="name">Name :</label>
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="form-control"
                  />
                  <HasError :form="form" field="name" />
                </div>
                <div class="form-group my-3">
                  <label for="price">Price :</label>
                  <input
                    id="price"
                    v-model="form.price"
                    type="number"
                    name="price"
                    class="form-control"
                  />
                  <HasError :form="form" field="price" />
                </div>
                <button class="btn btn-primary">
                  <i class="fas fa-save me-2"></i> Save
                </button>
              </form>
            </div>
          </div>
        </div>
        <!--End Input Form-->

        <!--Table-->
        <div class="col-md-8">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products.data" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}.00</td>
                <td>
                  <button class="btn btn-sm btn-success" @click="edit(product)">
                    <i class="fas fa-edit me-2"></i>Edit
                  </button>
                  <button
                    class="btn btn-sm btn-danger"
                    @click="deleteBtn(product.id)"
                  >
                    <i class="fas fa-trash-alt me-2"></i>Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="d-flex justify-content-start">
            <advanced-laravel-vue-paginate
              class="mt-2 shadow-sm"
              :data="products"
              @paginateTo="view"
            />
          </div>
        </div>
        <!--End Table-->
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { Form } from "vform";

export default {
  name: "ProductComponent",
  data() {
    return {
      isEditMode: false,
      products: {},
      search: "",
      form: new Form({
        id: "",
        name: "",
        price: "",
      }),
    };
  },

  methods: {
    view(page = 1) {
      axios
        .get(`/api/products?page=${page}&search=${this.search}`)
        .then((res) => (this.products = res.data))
        .catch((err) => console.log(err));
    },

    store() {
      this.form
        .post("/api/product/store")
        .then(() => {
          this.view();
          this.form.reset();
          Toast.fire({
            icon: "success",
            title: "Created new Product successfully",
          });
        })
        .catch((err) => console.log(err.message));
    },

    create() {
      this.isEditMode = false;
      this.form.reset();
    },

    edit(product) {
      this.isEditMode = true;
      this.form.fill({
        id: product.id,
        name: product.name,
        price: product.price,
      });
    },

    update() {
      this.form
        .put(`/api/product/${this.form.id}`)
        .then(() => {
          this.view();
          this.create();
          Toast.fire({
            icon: "success",
            title: "Updated successfully",
          });
        })
        .catch((err) => console.log(err.message));
    },

    deleteBtn(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(`/api/product/${id}`)
            .then(() => {
              this.view();
              Swal.fire(
                "Deleted!",
                "Your Product has been deleted.",
                "success"
              );
            })
            .catch((err) => console.log(err));
        }
      });
    },
  },

  created() {
    this.view();
  },
};
</script>

<style>
</style>
