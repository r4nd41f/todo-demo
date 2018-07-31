// message service
export default {
  messages: [],
  errors: [],
  pushMessage: function (message) {
    this.messages.push(message);
  },
  pushError: function (error) {
    this.errors.push(error);
  }
}