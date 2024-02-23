<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component title="Search Task">
                    <template v-slot:content>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <input-container-component 
                                    id="task" 
                                    title="Task"
                                    helper-id="taskHelp"
                                    helper-text="Optional. Insert Task title"
                                >
                                    <input type="text" class="form-control" id="task" placeholder="Task title" aria-describedby="taskHelp" v-model="search.title">
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
                                'finish_date': {title: 'Finish Data', type: 'date'}
                        }" 
                            :data="this.tasks.data"
                            :view="true"
                            :edit="true"
                            :delete="true"
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
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="store()">Save</button>
        </template>

    </modal-component>

    <modal-component id="modalTaskView" title="View Task">

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
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                storeStatus: '',
                storeDetails: {},
                tasks: { data: [] },
                tasksLinks: [],
                search: { title: ''}
            }
        },
        methods: {
            searching() {
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }
                let url = this.url + '/title/' + this.search[`title`];
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
                        
                        console.log(response);
                    })
                    .catch(errors => {
                        this.storeStatus = 'Error';
                        this.storeDetails = {
                            message: errors.response.data.message
                        };
                    });
            }
        },
        mounted() {
            this.list();
        }
    }
</script>
