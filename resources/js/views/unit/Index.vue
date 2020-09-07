<template>
  <div class="container">
    <div class="d-flex bd-highlight mx-auto" style="max-width: 420px">
      <h1 class="bd-highlight mx-auto">
        {{ $t('unit.title') }}
      </h1>
    </div>

    <div class="card p-0 mt-2 mx-auto" style="max-width: 420px">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr class="table-secondary">
              <th scope="col" class="border-0">
                {{ $t('unit.name') }}
              </th>
              <th scope="col" class="border-0"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="unit in units" v-bind:key="unit.id">
              <td v-if="currentEditId != unit.id" class="align-middle">
                {{ unit.name }}
              </td>
              <td v-if="currentEditId != unit.id" class="align-middle text-right">
                <button
                  class="btn btn-primary mx-1"
                  :disabled="currentEditId == 0 ? false : true"
                  @click="edit(unit)"
                >
                  {{ $t('common.edit') }}
                </button>
              </td>
              <td v-else class="align-middle" colspan="2">
                <form class="form-inline" @submit.prevent="save(unit)" @reset.prevent="cancel(unit)">
                  <div class="form-group w-100">
                    <input 
                      v-model="unit.name"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errorsEdit.name}"
                    >
                    <button type="submit" class="btn btn-success ml-auto mr-1">
                      {{ $t('common.save') }}
                    </button>
                    <button type="reset" class="btn btn-danger mx-1">
                      {{ $t('common.reset') }}
                    </button>
                    <div v-for="error in errorsEdit.name" v-bind:key="error" class="form-row invalid-feedback">
                      {{ error }}
                    </div>
                  </div>
                </form>
              </td>
            </tr>
            <tr>
              <td class="align-middle" colspan="2">
                <form class="form-inline" @submit.prevent="create">
                  <div class="form-group w-100">
                    <input 
                      id="name"
                      v-model="name"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errorsCreate.name}"
                    >
                    <button type="submit" class="btn btn-success ml-auto mr-1">
                      {{ $t('common.add') }}
                    </button>
                    <div v-for="error in errorsCreate.name" v-bind:key="error" class="invalid-feedback">
                      {{ error }}
                    </div>
                  </div>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      units: [],
      name: "",
      currentEditId: 0,
      nameStash: "",
      errorsEdit: [],
      errorsCreate: []
    }
  },

  methods: {
    getUnits() {
      axios.get('/api/unit').then(res => {
        this.units = res.data;
      });
    },

    edit(unit) {
      this.currentEditId = unit.id;
      this.nameStash = unit.name;
    },

    save(unit) {
      axios.put('/api/unit/' + unit.id, unit)
        .then(res => {
          this.currentEditId = 0;
          this.nameStash = "";
          this.errorsEdit = [];
          this.getUnits();
        })
        .catch(ex => {
          this.errorsEdit = ex.response.data.errors;
        });
    },

    cancel(unit) {
      this.currentEditId = 0;
      unit.name = this.nameStash;
      this.errorsEdit = [];
    },

    create() {
      axios.post('/api/unit', {
        name : this.name
      })
      .then(res => {
        this.name = "";
        this.getUnits();
      })
      .catch(ex => {
        this.errorsCreate = ex.response.data.errors;
      });
    }
  },

  mounted() {
    this.getUnits();
  }
}
</script>