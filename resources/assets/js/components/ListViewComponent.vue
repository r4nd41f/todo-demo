<template>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item" v-for="task in tasks">
                <span>{{ task.description }}</span> <a v-on:click="$emit('task-complete', task.id)">Done</a>
            </li>
        </ul>     
    </div>
</template>

<script>
    export default {
        props: ['tasks'],
    }
</script>

<style>
</style>