<template>
  <div class="container">
  <transition-group name="fade">
    <div class="alert alert-danger" v-for="(error, index) in messageService.errors" :key="index" @click="dismissError">
      {{ error }}
    </div>
  </transition-group>
  <transition-group name="fade">
    <div class="alert alert-success" v-for="(message, index) in messageService.messages" :key="index" @click="dismissMessage">
      {{ message }}
    </div>
  </transition-group>
  </div>
</template>

<script>
    import messageService from '../MessageService'

    export default {
        data: () => ({
            messageService: messageService
        }),
        methods: {
          dismissMessage() {
            this.messageService.messages.pop();
          },
          dismissError() {
            this.messageService.errors.pop();
          }
        }
    }
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>