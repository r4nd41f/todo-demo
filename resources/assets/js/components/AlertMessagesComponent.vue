<template>
  <transition name="fade">    
    <div class="alert alert-danger" v-for="error in messageService.errors" v-on:click="dismissError">
      {{ error }}
    </div>
    <div class="alert alert-success" v-for="message in messageService.messages" v-on:click="dismissMessage">
      {{ message }}
    </div>
  </transition>
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