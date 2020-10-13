<template>
    <div class="app-component">

        <task-edit-modal
            @close="close"
            @save="saveEdit"
            v-if="editTask"
            :editTask="editTask"
            :priorities="priorities"
            :statuses="statuses"
        ></task-edit-modal>

        <div v-if="msg.text" class="alert " :class="msg.class" role="alert">
            {{msg.text}}
            <button type="button" class="close"  @click="msg.text = ''" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="row">

            <h3 class="col-md-12">Добавление задачи</h3>
            <div class="col-md-3">
                <input type="text"
                       id="task"
                       placeholder="Название задачи"
                       v-model="addTasks.title"
                       class="form-control">
            </div>
            <div class="col-md-3">
                <select name="" id="select" v-model="addTasks.priority_id" class="form-control">
                    <option value="" disabled>Приоритет задачи</option>
                    <option v-for="priority in priorities" :value="priority.id">
                        {{priority.title}} приоритет
                    </option>
                </select>
            </div>

            <div class="col-md-3">
                <input-tag v-model="addTasks.tags" placeholder="Тэги"></input-tag>
            </div>

            <div class="col-md-3">
                <button @click="store()" class="btn btn-primary">Добавить</button>
            </div>
        </div>
        <div class="tasks-all">
            </br>
            <div class="row">
                <div class="col-md-3">
                    <h3>Название</h3>
                </div>
                <div class="col-md-2"><h2>Приоритет</h2></div>
                <div class="col-md-2"><h2>Статус</h2></div>
                <div class="col-md-3"><h2>Теги</h2></div>
                <div class="col-md-2"><h2>Действия</h2></div>
            </div>
            <task-component v-for="task in taskList"
                            :task="task"
                            :priorities="priorities"
                            :key="task.id"
                            @delete="remove"
                            @edit="edit"
            ></task-component>
        </div>
    </div>
</template>

<script>
    import Task from "./Task.vue";
    import InputTag from 'vue-input-tag';
    import TaskEdit from "./TaskEdit.vue";

    export default {
        components: {
            'task-component': Task,
            'input-tag': InputTag,
            'task-edit-modal': TaskEdit
        },
        props: [
            'priorities', 'statuses'
        ],
        data() {
            return {
                tasks: [],
                addTasks: {title: '', priority_id: 2, tags: [], status: 'В работе'},
                editTask: '',
                msg: {text: '', class: ''}
            }
        },

        methods: {
            getTasks() {
                window.axios.get('/api/tasks').then(({data}) => {
                    data.forEach(task => {
                        task.tags = JSON.parse(task.tags);
                        this.tasks.push(task)
                    });
                });
            },
            store() {
                if (!this.addTasks.title.length) {
                    this.setMsg('Поле название должно быть заполнено', false);
                    return;
                }
                window.axios.post('/api/tasks', this.addTasks).then(savedTask => {
                    savedTask.data.tags = JSON.parse(savedTask.data.tags);
                    this.tasks.push(savedTask.data);
                    this.addTasks.priority_id = 2;
                    this.addTasks.title = '';
                    this.addTasks.tags = [];
                    this.setMsg('Задача добавлена');
                })
            },
            remove(id) {
                window.axios.delete(`api/tasks/${id}`, this.addTasks).then(() => {
                    let index = this.tasks.findIndex(task => task.id === id);
                    this.tasks.splice(index, 1);
                    this.setMsg('Задача удалена');
                })
            },
            edit(id) {
                this.editTask = this.tasks.find(task => task.id === id);
            },
            saveEdit(task) {
                window.axios.patch(`/api/tasks/${task.id}`, task).then(savedTask => {
                    savedTask.data.tags = JSON.parse(savedTask.data.tags);
                    let index = this.tasks.findIndex(task => savedTask.data.id === task.id);
                    this.tasks[index] = savedTask.data;
                    this.tasks.push('');
                    this.tasks.splice(-1, 1);
                    this.editTask = '';
                    this.setMsg('Задача изменена');
                })
            },
            close() {
                this.editTask = '';
            },
            setMsg(text, success = true){
                let className = 'alert-danger';
                if (success) {
                    className = 'alert-success';
                }
                this.msg = {text: text, class: className};
            }
        },
        computed: {
            taskList() {
                return this.tasks.sort((d1, d2) => {
                    let index1 = d1.priority_id * 10;
                    let index2 = d2.priority_id * 10;

                    if (d1.status === 'Завершена') {
                        index1 -= 100;
                    }

                    if (d2.status === 'Завершена') {
                        index2 -= 100;
                    }

                    if (d1.id < d2.id) {
                        index2++;
                    } else {
                        index1++;
                    }

                    if (index1 < index2) {
                        return 1
                    }
                    return -1
                });
            }
        },
        created() {
            this.getTasks()
        }
    }
</script>

<style>

</style>
