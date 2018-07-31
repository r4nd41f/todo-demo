<template>
  <div class="container">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" v-model="showCompleted" id="showCompleted">
      <label class="form-check-label" for="showCompleted">
        Show Completed
      </label>
    </div>
    <transition-group name="list" tag="ul" class="list-group">
      <li class="list-group-item d-flex justify-content-between align-items-center" v-for="task in tasks" v-bind:key="task.id">
        {{ task.description }}
        
        <div class="btn-group">
          <button v-on:click="completeTask(task.id)" v-bind:disabled="task.completed_date" class="btn btn-sm btn-success">
            <octicon name="check"></octicon>
          </button>          
          <router-link :to="'/update/' + task.id" class="btn btn-sm btn-primary float-right">
            <octicon name="pencil"></octicon>
          </router-link>
          <button v-on:click="deleteTask(task.id)" class="btn btn-sm btn-danger">
            <octicon name="trashcan"></octicon>
          </button>
        </div>
      </li>
    </transition-group>
    <li class="list-group-item">
      <router-link to="/add">Add a task</router-link>
    </li>
  </div>
</template>

<script>
  import moment from 'moment';
  import messageService from '../MessageService';
  export default {
    data: function() {
      return {
        tasks: [],
        showCompleted: false,
        messageService: messageService
      };
    },
    mounted() {
      this.getTasks();
    },
    watch: {
      showCompleted : function (val, oldVal) {
        this.getTasks();
      }
    },
    methods: {
      addTask(description) {
        axios.post('/api/task', {
          description: description,
          due_date: moment().add(1, 'days').format('Y-MM-DD HH:mm:ss')
        }).then((response) => {
          this.tasks.push(response.data)
          this.showForm = false;
        }).catch((error) => {
          this.messageService.pushMessage(error);
        })
      },
      completeTask(id) {
        axios.put(`/api/task/${id}`, { 
          completed_date: moment().format('Y-MM-DD HH:mm:ss')
        }).then((response) => {
          this.tasks = this.tasks.filter(task => task.id !== id)
        }).catch(error => {
          this.messageService.pushMessage(error);
        })
      },
      deleteTask(id) {
        axios.delete(`/api/task/${id}`).then((response) => {
          this.tasks = this.tasks.filter(task => task.id !== id)
        }).catch(error => {
          this.messageService.pushMessage(error);
        })
      },
      getTasks() {
        this.tasks = []; // all transition out before refreshing
        let url = `/api/taskToDo`;
        if (this.showCompleted) {
          url = `/api/task`;
        };
        axios.get(url).then((response) => {
          this.tasks = response.data;
        }).catch((error) => {
          this.messageService.pushMessage(error);
        });
      }
    }
  }
</script>

<style>

.list-item {
  display: inline-block;
  margin-right: 10px;
}
.list-enter-active, .list-leave-active {
  transition: all 0.8s;
}
.list-enter, .list-leave-to {
  opacity: 0;
  transform: translateX(1000px);
}
</style>