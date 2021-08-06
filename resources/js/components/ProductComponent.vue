<template>
  <div class="container my-5">
    <!-- navbar -->
    <nav class="navbar navbar-light bg-white mb-5 shadow-sm">
      <a href="/" class="navbar-brand">Store</a>
    </nav>
    <!-- create btn -->
    <div class="row justify-content-end mb-2">
      <div class="col-4">
        <button
          type="submit"
          class="btn btn-outline-success btn-sm"
          @click="create"
        >
          <i class="fas fa-plus-circle"></i> Create
        </button>
      </div>
      <div class="col-4">
        <form @submit.prevent="view">
          <div class="input-group">
            <input
              v-model="search"
              type="text"
              class="form-control"
              placeholder="search"
            />

            <div class="input-group-append">
              <button type="submit" class="btn btn-outline-success btn-sm">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- content -->
    <div class="row border">
      <div class="col-4 mt-3">
        <div class="card">
          <h4 class="card-header bg-white">
            {{ isEditMode ? "Edit" : "Create" }}
          </h4>
          <div class="card-body">
            <form @submit.prevent="isEditMode ? update() : store()">
              <div class="form-group">
                <label>Name:</label>
                <input
                  v-model="product.name"
                  type="text"
                  class="form-control"
                />
                <div
                  v-if="product.errors.has('name')"
                  v-html="product.errors.get('name')"
                />
              </div>
              <div class="form-group">
                <label>Price:</label>
                <input
                  v-model="product.price"
                  type="number"
                  class="form-control"
                />
                <div
                  v-if="product.errors.has('price')"
                  v-html="product.errors.get('price')"
                />
              </div>
              <button class="btn btn-outline-success btn-sm" type="submit">
                <i class="fas fa-save"></i> Save
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-8 mt-3">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>NAME</th>
              <th>PRICE</th>
              <th>ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products.data" :key="product.id">
              <td>{{ product.id }}</td>
              <td>{{ product.name }}</td>
              <td>{{ product.price }}</td>
              <td>
                <button
                  type="submit"
                  class="btn btn-outline-success btn-sm"
                  @click="edit(product)"
                >
                  <i class="fas fa-edit mr-1"></i>Edit
                </button>
                <button
                  type="submit"
                  class="btn btn-outline-danger btn-sm"
                  @click="destroy(product.id)"
                >
                  <i class="fas fa-trash-alt mr-1"></i>Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <pagination :data="products" @pagination-change-page="view">
          <span slot="prev-nav">&lt; Previous</span>
          <span slot="next-nav">Next &gt;</span>
        </pagination>
      </div>
    </div>
  </div>
</template>

<script>
import { Form } from "vform";

export default {
  name: "ProductComponent",
  data() {
    return {
      isEditMode: false,
      search: "",
      products: {},
      product: new Form({
        id: "",
        name: "",
        price: "",
      }),
    };
  },
  methods: {
    view(page = 1) {
      this.$Progress.start();
      axios
        .get(`/api/product?page=${page}&search=${this.search}`)
        .then((response) => {
          this.products = response.data;
          this.$Progress.finish();
        })
        .catch(error => {
          this.$Progress.fail();
        });
    },

    create() {
      this.isEditMode = false;
      this.product.id = "";
      this.product.name = "";
      this.product.price = "";
    },

    store() {
      this.product.post("/api/product").then((response) => {
        this.view();
        this.product.reset();
         Toast.fire({
              icon: "success",
              title: "Product created successfully",
            });
      });
    },

    edit(product) {
      this.isEditMode = true;
      this.product.id = product.id;
      this.product.name = product.name;
      this.product.price = product.price;
    },

    update() {
      this.product.put(`/api/product/${this.product.id}`).then((response) => {
        this.view();
        this.product.reset();
         Toast.fire({
              icon: "success",
              title: "Product updated successfully",
            });
      });
    },

    destroy(id) {
      Swal.fire({
        title: "Delete Product?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00C851",
        cancelButtonColor: "#d9534f",
        confirmButtonText: "Delete",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`/api/product/${id}`).then((response) => {
            this.view();
            // Swal.fire({
            //   title: "Deleted",
            //   icon: "success",
            // });
            Toast.fire({
              icon: "success",
              title: "Product deleted successfully",
            });
          });
        }
      });
    },
  },
  created() {
    this.view();
  },
};
</script>