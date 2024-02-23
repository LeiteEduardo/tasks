<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component title="Search Task">
                    <template v-slot:content>
                        <div class="row">
                            
                            <div class="col-lg-4 mb-3">
                                <input-container-component 
                                    id="taskId" 
                                    title="ID"
                                    helper-id="taskIdHelp"
                                    helper-text="Optional. Insert Task ID"
                                >
                                    <input type="number" class="form-control" id="taskId" placeholder="Task ID" aria-describedby="taskIdHelp" v-model="search.id">
                                </input-container-component>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <input-container-component 
                                    id="task" 
                                    title="Task"
                                    helper-id="taskHelp"
                                    helper-text="Optional. Insert Task title"
                                >
                                    <input type="text" class="form-control" id="task" placeholder="Task title" aria-describedby="taskHelp" v-model="search.title">
                                </input-container-component>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <input-container-component 
                                    id="taskStatus" 
                                    title="Status"
                                    helper-id="taskStatusHelp"
                                    helper-text="Optional. Select Task status"
                                >
                                <select class="form-select" id="taskStatus" aria-label="Default select example" aria-describedby="taskStatusHelp" v-model="search.status">
                                    <option value="Not Started">Not Started</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm" @click="searching()">Search</button>
                    </template>
                </card-component>

                <card-component title="Tasks">
                    <template v-slot:content>
                        <table-component 
                            :titles="{
                                'id': {title: 'ID', type: 'text'},
                                'title': {title: 'Title', type: 'text'},
                                'description': {title: 'Description', type: 'text'},
                                'status': {title: 'Status', type: 'text'},
                                'start_date': {title: 'Start Date', type: 'date'},
                                'end_date': {title: 'End Date', type: 'date'},
                                'finish_date': {title: 'Finish Data', type: 'date'},
                                'responsible': {title: 'Responsible', type: 'text'}
                        }" 
                            :data="this.tasks.data"
                            :view="{ visible: true, dataToggle: 'modal', dataTarget: '#modalTaskView'}"
                            :edit="{ visible: true, dataToggle: 'modal', dataTarget: '#modalTaskUpdate'}"
                            :destroy="{ visible: true, dataToggle: 'modal', dataTarget: '#modalTaskDelete'}"
                        ></table-component>
                    </template>
                    <template v-slot:footer>
                        <div class="d-flex justify-content-between">
                            <paginate-component>
                                <li 
                                    v-for="l, key in tasksLinks" 
                                    :key="key" 
                                    :class="l.active ? 'page-item active' : 'page-item'" 
                                    @click="paginate(l)"
                                >
                                    <a class="page-link" href="#" v-html="l.label"></a>
                                </li>
                            </paginate-component>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTask">Create</button>
                        </div>
                    </template>
                </card-component>

            </div>
        </div>
    </div>

    <modal-component id="modalTask" title="Create Task">

        <template v-slot:alert>
            <alert-component type="success" :details="storeDetails" title="Success" v-if="storeStatus == 'Created'"></alert-component>
            <alert-component type="danger" :details="storeDetails" title="Error" v-if="storeStatus == 'Error'"></alert-component>
        </template>

        <template v-slot:content>
            <div class="form-group mb-2">
                <input-container-component 
                    id="storeTask" 
                    title="Task"
                    helper-id="storeTaskHelp"
                    helper-text="Required. Insert Task name"
                >
                    <input type="text" class="form-control" id="storeTask" placeholder="Task name" aria-describedby="storeTaskHelp" v-model="storeTask" required>
                </input-container-component>
            </div>
            <div class="form-group mb-2">
                <input-container-component 
                    id="storeTaskDesc" 
                    title="Description"
                    helper-id="storeTaskDescHelp"
                    helper-text="Required. Insert Task description"
                >
                    <input type="text" class="form-control" id="storeTaskDesc" placeholder="Description" aria-describedby="storeTaskDescHelp" v-model="storeTaskDesc" required>
                </input-container-component>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <input-container-component 
                        id="storeStartDate" 
                        title="Start Date"
                        helper-id="storeStartDateHelp"
                        helper-text="Required. Insert Task start date"
                    >
                        <input type="date" class="form-control" id="storeStartDate" placeholder="Start Date" aria-describedby="storeStartDateHelp" v-model="storeStartDate" required>
                    </input-container-component>
                </div>
                <div class="form-group col-6">
                    <input-container-component 
                        id="storeEndDate" 
                        title="End Date"
                        helper-id="storeEndDateHelp"
                        helper-text="Required. Insert Task end date"
                    >
                        <input type="date" class="form-control" id="storeEndDate" placeholder="End Date" aria-describedby="storeEndDateHelp" v-model="storeEndDate" required>
                    </input-container-component>
                </div>
            </div>
            <div class="form-group mb-3">
                <input-container-component 
                    id="taskResponsible" 
                    title="Responsible"
                    helper-id="taskResponsibleHelp"
                    helper-text="Optional. Insert Task Responsible"
                >
                    <select class="form-select" id="taskResponsible" aria-label="Default select example" aria-describedby="taskResponsibleHelp" v-model="storeResponsible">
                        <option v-for="obj in users" :value="obj.id">{{ obj.name}}</option>
                    </select>
                </input-container-component>
            </div>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="store()">Save</button>
        </template>

    </modal-component>

    <modal-component id="modalTaskView" title="View Task">

        <template v-slot:alert>
        </template>

        <template v-slot:content>

            <input-container-component id="viewId" title="Id" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
            </input-container-component>

            <input-container-component id="viewTitle" title="Title" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.title" disabled>
            </input-container-component>

            <input-container-component id="viewDesc" title="Description" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.description" disabled>
            </input-container-component>

            <input-container-component id="viewStatus" title="Status" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.status" disabled>
            </input-container-component>

            <input-container-component id="viewResponsible" title="Responsible" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.responsible" disabled>
            </input-container-component>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </template>

    </modal-component>

    <modal-component id="modalTaskDelete" title="Delete Task">

        <template v-slot:alert>
            <alert-component type="success" :details="$store.state.transaction" title="Success" v-if="$store.state.transaction.status == 'success'"></alert-component>
            <alert-component type="danger" :details="$store.state.transaction" title="Error" v-if="$store.state.transaction.status == 'error'"></alert-component>
        </template>

        <template v-slot:content v-if="$store.state.transaction.status != 'success'">
            <input-container-component id="viewId" title="Id" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
            </input-container-component>

            <input-container-component id="viewTitle" title="Title" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.title" disabled>
            </input-container-component>

            <input-container-component id="viewDesc" title="Description" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.description" disabled>
            </input-container-component>

            <input-container-component id="viewResponsible" title="Responsible" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.responsible" disabled>
            </input-container-component>

        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" @click="destroy()" v-if="$store.state.transaction.status != 'success'">Remove</button>
        </template>

    </modal-component>

    <modal-component id="modalTaskUpdate" title="Update Task">

        <template v-slot:alert>
            <alert-component type="success" :details="$store.state.transaction" title="Success" v-if="$store.state.transaction.status == 'success'"></alert-component>
            <alert-component type="danger" :details="$store.state.transaction" title="Error" v-if="$store.state.transaction.status == 'error'"></alert-component>
        </template>

        <template v-slot:content>
            <div class="form-group mb-2">
                <input-container-component 
                    id="updateTask" 
                    title="Task"
                    helper-id="updateTaskHelp"
                    helper-text="Required. Insert Task name"
                >
                    <input type="text" class="form-control" id="updateTask" placeholder="Task title" aria-describedby="updateTaskHelp" v-model="$store.state.item.title" required>
                </input-container-component>
            </div>
            <div class="form-group mb-2">
                <input-container-component 
                    id="updateTaskDesc" 
                    title="Description"
                    helper-id="updateTaskDescHelp"
                    helper-text="Required. Insert Task description"
                >
                    <input type="text" class="form-control" id="updateTaskDesc" placeholder="Description" aria-describedby="updateTaskDescHelp" v-model="$store.state.item.description" required>
                </input-container-component>
            </div>
            <div class="form-group mb-2">
                <input-container-component 
                    id="updateTaskStatus" 
                    title="Status"
                    helper-id="updateTaskStatusHelp"
                    helper-text="Required. Select Task Status"
                >
                    <select class="form-select" id="updateTaskStatus" aria-label="Default select example" aria-describedby="updateTaskStatusHelp" v-model="$store.state.item.status" required>
                        <option value="Not Started" :selected="$store.state.item.status == 'Not Started'">Not Started</option>
                        <option value="In Progress" :selected="$store.state.item.status == 'In Progress'">In Progress</option>
                        <option value="Completed" :selected="$store.state.item.status == 'Completed'">Completed</option>
                    </select>
                </input-container-component>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <input-container-component 
                        id="updateStartDate" 
                        title="Start Date"
                        helper-id="updateStartDateHelp"
                        helper-text="Required. Insert Task start date"
                    >
                        <input type="date" class="form-control" id="updateStartDate" placeholder="Start Date" aria-describedby="updateStartDateHelp" v-model="$store.state.item.start_date" required>
                    </input-container-component>
                </div>
                <div class="form-group col-6">
                    <input-container-component 
                        id="updateEndDate" 
                        title="End Date"
                        helper-id="updateEndDateHelp"
                        helper-text="Required. Insert Task end date"
                    >
                        <input type="date" class="form-control" id="updateEndDate" placeholder="End Date" aria-describedby="updateEndDateHelp" v-model="$store.state.item.end_date" required>
                    </input-container-component>
                </div>
            </div>
            <div class="form-group mb-3">
                <input-container-component id="viewResponsible" title="Responsible" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.responsible" disabled>
            </input-container-component>
            </div>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="update()">Save</button>
        </template>

    </modal-component>
</template>

<script>
import axios from 'axios';

    export default{
        computed: {
            token() {
                let token = document.cookie.split(';').find(indice => {
                    return indice.includes('token=');
                })

                token = token.split('=')[1];
                token = 'Bearer ' + token;

                return token;
            }
        },
        data() {
            return {
                url: 'http://localhost:9000/api/v1/tasks',
                storeTask: '',
                storeTaskDesc: '',
                storeStartDate: '',
                storeEndDate: '',
                storeResponsible: '',
                storeStatus: '',
                storeDetails: {},
                tasks: { data: [] },
                users: { data: [] },
                tasksLinks: [],
                search: { id: '', title: '', status: ''}
            }
        },
        methods: {
            update() {
                let formData = new URLSearchParams({
                    'title': this.$store.state.item.title,
                    'description': this.$store.state.item.description,
                    'status': this.$store.state.item.status,
                    'start_date': this.$store.state.item.start_date,
                    'end_date': this.$store.state.item.end_date,
                    'finish_date': this.$store.state.item.status == 'Completed' ? new Date().toISOString().slice(0, 10) : ''
                });

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                console.log(formData);

                let url = this.url + '/' + this.$store.state.item.id;

                axios.put(url, formData, config)
                    .then(response => {
                        console.log(response);
                        this.$store.state.transaction.status = 'success';
                        this.$store.state.transaction.message = 'Task ID ' + this.$store.state.item.id + ' updated!' ;

                        this.list();

                    })
                    .catch(errors => {
                        this.$store.state.transaction.status = 'error';
                        this.$store.state.transaction.message = errors.response.data.message;
                    });
            },
            destroy() {
                let confirmation = confirm('Remove Task?')

                if (!confirmation) {
                    return false;
                }

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                let url = this.url + '/' + this.$store.state.item.id;

                axios.delete(url, config)
                    .then(response => {
                        this.$store.state.transaction.status = 'success';
                        this.$store.state.transaction.message = response.data.message;

                        this.list();
                    })
                    .catch(errors => {

                        this.$store.state.transaction.status = 'error';
                        this.$store.state.transaction.message = errors.response.data.message;
                    });

            },
            searching() {
                
                let filter = '';
                for(let key in this.search) {
                    if ( this.search[key] ) {
                        if (filter != '') {
                            filter += '&';
                        }
    
                        filter += key + '=' + this.search[key]
                    }
                }
                
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }
                let url = this.url + '?' + filter;
                axios.get(url, config)
                    .then(response => {
                        this.tasks = response.data;
                        this.tasksLinks = response.data.meta.links;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
                
            },  
            paginate(l) {
                if (l.url) {
                    this.url = l.url;
                    this.list();
                }
            },
            list() {
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.get(this.url, config)
                    .then(response => {
                        this.tasks = response.data;
                        this.tasksLinks = response.data.meta.links;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            store() {
                let formData = new URLSearchParams({
                    'title': this.storeTask,
                    'description': this.storeTaskDesc,
                    'start_date': this.storeStartDate,
                    'end_date': this.storeEndDate,
                    'responsible_id': this.storeResponsible,
                });

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(this.url, formData, config)
                    .then(response => {
                        this.storeStatus = 'Created';
                        this.storeDetails = {
                            message: 'Task ID created: ' + response.data.data.id
                        };
                        this.list();
                        console.log(response);
                    })
                    .catch(errors => {
                        this.storeStatus = 'Error';
                        this.storeDetails = {
                            message: errors.response.data.message
                        };
                    });
            },
            getAllUsers() {
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                let url = 'http://localhost:9000/api/v1/users'

                axios.get(url, config)
                    .then(response => {
                        this.users = response.data.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            }
        },
        mounted() {
            this.list();
            this.getAllUsers();
        }
    }
</script>
