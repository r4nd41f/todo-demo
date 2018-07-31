<template>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <a v-on:click="lastMonth" class="pull-left">Prev</a>
        <a v-on:click="nextMonth" class="pull-right">Next</a>        
      </div>
    </div>
    <div class="row">
      <h2>{{ date }}</h2>
    </div>
    <table class="table table-fixed">
      <thead>
        <tr>
          <td v-for="day of weekDays">
            {{ day }}
          </td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="week of weeks">
          <td v-for="day of week">
            {{ getDayOfMonth(day.date) }}
            <ul v-if="day.tasks.length > 0" class="task-list">
              <li>
                {{ day.tasks[0].description }}
              </li>
              <li>
                <router-link to='/'>more...</router-link>
              </li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
    import moment from 'moment'

    export default {
      data: () => ({
        date: moment().format('Y MMMM'),
        weeks: []
      }),
      computed: {
        weekDays: () => [0,1,2,3,4,5,6].map((elem, index) => moment().day(elem).format('ddd')),
      },
      mounted() {
        this.fetchMonth();
      },
      methods: {
        nextMonth() {
          this.date = moment(this.date).add('1', 'months').format('MMMM Y');
          this.fetchMonth();
        },
        lastMonth() {
          this.date = moment(this.date).subtract('1', 'months').format('MMMM Y');
          this.fetchMonth();
        },
        getDayOfMonth(date) {
          return moment(date).format('DD')
        },
        fetchMonth() {
          let url = `/api/calendar/${moment(this.date).format('Y')}/${moment(this.date).format('MM')}`; 
          axios.get(url).then((response) => { 
            this.weeks = response.data; 
          })
        }
      }
    }
</script>

<style lang="scss">
  .table {
    table-layout: fixed;
    tbody {
      tr {
        height: 110px;
      }
    }
  }
  .task-list {
    padding: 0;
    li {
      list-style: none;
    }
  }
</style>