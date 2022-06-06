<template>
  <div class="productComponent">
    <div class="container my-5">
      <div class="row d-flex justify-content-end my-3">
        <div class="col-md-5">
          <button class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Create
          </button>
        </div>
        <div class="col-md-3">
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              placeholder="Searh Product"
            />
            <button class="btn btn-primary">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="row">
        <!--Input Form-->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h4>Create</h4>
            </div>
            <div class="card-body">
              <form @submit.prevent="store">
                <div class="form-group my-3">
                  <label for="name">Name :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    v-model="product.name"
                  />
                </div>
                <div class="form-group my-3">
                  <label for="price">Price :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="price"
                    v-model="product.price"
                  />
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
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
                <td>
                  <button class="btn btn-sm btn-success">
                    <i class="fas fa-edit me-2"></i>Edit
                  </button>
                  <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash-alt me-2"></i>Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--End Table-->
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ProductComponent",
  data() {
    return {
      products: [],
      product: {
        name: "",
        price: "",
      },
    };
  },

  methods: {
    view() {
      axios
        .get("/api/products")
        .then((res) => (this.products = res.data))
        .catch((err) => console.log(err));
    },

    store() {
      axios
        .post("/api/product/store", this.product)
        .then(() => {
          this.view();
          this.product = { name: "", price: "" };
        })
        .catch();
    },
  },

  created() {
    this.view();
  },
};
</script>

<style>
</style>
