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
              <td scope="col" class="border-0">
                {{ $t('unit.name') }}
              </td>
              <td scope="col" class="border-0"></td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="unit in units" v-bind:key="unit.id">
              <td class="align-middle" v-if="currentEditId != unit.id">
                {{ unit.name }}
              </td>
              <td class="align-middle text-right" v-if="currentEditId != unit.id">
                <button class="btn btn-primary mx-1" @click="edit(unit)" :disabled="currentEditId == 0 ? false : true">
                  {{ $t('common.edit') }}
                </button>
              </td>
              <td class="align-middle" colspan="2" v-else>
                <form class="form-inline" @submit.prevent="save(unit)" @reset.prevent="cancel(unit)">
                  <div class="form-group w-100">
                    <input class="form-control" type="text" v-model="unit.name" :class="{'is-invalid': errorsEdit.name}">
                    <button class="btn btn-success ml-auto mr-1" type="submit">
                      {{ $t('common.save') }}
                    </button>
                    <button class="btn btn-danger mx-1" type="reset">
                      {{ $t('common.reset') }}
                    </button>
                    <div class="form-row invalid-feedback" v-for="error in errorsEdit.name" v-bind:key="error">
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
                    <input id="name" class="form-control" type="text" v-model="name" :class="{'is-invalid': errorsCreate.name}">
                    <button class="btn btn-success ml-auto mr-1" type="submit">
                      {{ $t('common.add') }}
                    </button>
                    <div class="invalid-feedback" v-for="error in errorsCreate.name" v-bind:key="error">
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