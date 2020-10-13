<template>
    <div class="task">
        <hr>
        <div class="row">
            <div class="col-md-3">
                <h3>{{ task.title }}</h3>
            </div>
            <div class="col-md-2">{{ priorities[task.priority_id].title }}</div>
            <div class="col-md-2">{{ task.status }}</div>
            <div class="col-md-3">
                <span
                    v-for="teg in task.tags"
                    style="
                    font-weight: bold;
                    display: inline-block;
                    margin-right: 10px;"
                    v-if="task.tags.length">{{ teg }}
                </span>
            </div>
            <div class="col-md-2">
                <p style="text-align: right">
                    <button
                        class="btn"
                        @click="edit()"
                    ><span class="oi oi-pencil btn btn-warning"></span>
                    </button>
                    <button
                        class="btn btn-danger oi oi-trash"
                        @click="remove()"
                    >
                    </button>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'task', 'priorities'
        ],
        data() {
            return {}
        },
        methods: {
            remove() {
                this.$emit('delete', this.task.id)
            },
            edit() {
                this.$emit('edit', this.task.id)
            }
        }
    }
</script>

<style>

</style>
