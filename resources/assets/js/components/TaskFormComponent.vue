<template>
  <div class="container">
    <div class="form-group">
      <label for="" class="control-label">I need to...</label>
      <input class="form-control" type="text" v-model="task.description" @input="validate('description')">
      <div class="text-danger" v-for="error of fields.description.errors">
        {{ error }}
      </div>
    </div>
    <div class="form-group">
      <label for="" class="control-label">By...</label>
      <vuejs-datepicker v-model="task.due_date" @input="validate('due_date')" :bootstrap-styling="true" format="yyyy-MM-dd"></vuejs-datepicker>
      <div class="text-danger" v-for="error of fields.due_date.errors">
        {{ error }}
      </div>
    </div>    
    <button class="btn btn-success" :disabled="!allowSubmit" @click="submit">Save</button>
    <router-link to="/" class="btn btn-default">Cancel</router-link>
  </div>
</template>

<script>
import messageService from '../MessageService';

  export default {
    data: function() {
      return { 
        fields: {
          description: {label : 'Description', errors: []},
          due_date: {label : 'Due Date', errors: []}
        },   
        task: {
          id: null,
          description: '',
          due_date: '',
        },
        messageService: messageService,
        errors: [],
        allowSubmit: false,
      };
    },
    mounted() {
      this.errors = [];
      if (this.$route.params.id) { // updating
        axios.get(`/api/task/${this.$route.params.id}`).then(response => {
          this.task.id = response.data.id;
          this.task.description = response.data.description;
          this.task.due_date = response.data.due_date;
        }).catch(error => {
          this.messageService.pushError('Unauthorized');
          this.$router.push('/')
        });
      }
    },
    methods: {
      validate(fieldname) {
        let field = this.fields[fieldname];
        this.fields[fieldname].errors = [];
        if (!this.task[fieldname]) {
          this.fields[fieldname].errors.push('Please enter a ' + field.label);
        }
        // update form allow submit state
        this.allowSubmit = Object.keys(this.fields).filter(field => this.fields[field].errors.length > 0).length < 1;
      },
      submit() {
        Object.keys(this.fields).forEach(field => {
          this.validate(field);
        })

        if (!this.allowSubmit) {
          return false;
        }

        if (this.task.id !== null) {
          axios.put(`/api/task/${this.task.id}`, this.task).then(response => {
            this.$router.push('/');
            this.messageService.pushMessage('Task updated successfully');
          }).catch(error => {
            this.messageService.pushError('Error creating task');
          })
        } else {
          axios.post('/api/task', this.task).then(response => {
            this.$router.push('/');
            this.messageService.pushMessage('Task created successfully');
          }).catch(error => {
            this.messageService.pushError(error);
          })
        }
      }
    }
  }
</script>

<style>

</style>