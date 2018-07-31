<template>
  <div class="container">
    <div class="form-group">
      <label for="" class="control-label">I need to...</label>
      <input class="form-control" type="text" v-model="task.description" v-on:keyup="validate">
      <div class="text-danger" v-if="getErrors('description')">
        {{ getErrors('description').message }}
      </div>
    </div>
    <div class="form-group">
      <label for="" class="control-label">By...</label>
      <datetime input-class="form-control" v-model="task.due_date" v-on:input="validate"></datetime>
      <div class="text-danger" v-if="getErrors('due_date')">
        {{ getErrors('due_date').message }}
      </div>
    </div>    
    <button class="btn btn-success" role="button" v-on:click="submit">Save</button>
    <router-link to="/" class="btn btn-default">Cancel</router-link>
  </div>
</template>

<script>
import messageService from '../MessageService';

  export default {
    data: function() {
      return {    
        task: {
          id: null,
          description: '',
          due_date: ''    
        },
        messageService: messageService,
        errors: [],
        valid: false,
      };
    },
    mounted() {
      this.errors = [];
      if (this.$route.params.id) {
        axios.get(`/api/task/${this.$route.params.id}`).then(response => {
          this.task = {
            description: response.data.description,
            id: response.data.id,
            due_date: response.data.due_date
          }
        }).catch(error => {
          this.messageService.pushError('Unauthorized');
          this.$router.push('/')
        });
      }
    },
    methods: {
      getErrors(field) {
        return this.errors.find(error => error.field === field) || null;
      },
      validate() {
        this.errors = [];
        if (!this.task.description) {
          this.errors.push({field: 'description', message: 'Please enter a description'});
        }
        if (!this.task.due_date) {
          this.errors.push({field: 'due_date', message: 'Please enter a due date'});
        }
        return this.errors.length === 0;
      },
      submit() {
        if (!this.validate()) {
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
            this.messageService.pushError(error)
          })
        }
      }
    }
  }
</script>

<style>

</style>