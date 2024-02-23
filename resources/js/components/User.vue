<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component title="Users">
                    <template v-slot:content>
                        <table-component 
                            :titles="{
                                'id': {title: 'ID', type: 'text'},
                                'name': {title: 'Name', type: 'text'},
                                'email': {title: 'E-mail', type: 'text'},
                                'master_name': {title: 'Master User', type: 'text'},
                        }" 
                            :data="this.users.data"
                            :view="{ visible: true, dataToggle: 'modal', dataTarget: '#modalUserView'}"
                            :edit="{ visible: true, dataToggle: 'modal', dataTarget: '#modalUserUpdate'}"
                            :destroy="{ visible: true, dataToggle: 'modal', dataTarget: '#modalUserDelete'}"
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
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUser">Create</button>
                        </div>
                    </template>
                </card-component>

            </div>
        </div>
    </div>

    <modal-component id="modalUser" title="Create User">

        <template v-slot:alert>
            <alert-component type="success" :details="storeDetails" title="Success" v-if="storeStatus == 'Created'"></alert-component>
            <alert-component type="danger" :details="storeDetails" title="Error" v-if="storeStatus == 'Error'"></alert-component>
        </template>

        <template v-slot:content>
            <div class="form-group mb-2">
                <input-container-component 
                    id="storeUserName" 
                    title="Name"
                    helper-id="storeUserNameHelp"
                    helper-text="Required. Insert user name"
                >
                    <input type="text" class="form-control" id="storeUserName" placeholder="User name" aria-describedby="storeUserNameHelp" v-model="storeUserName" required>
                </input-container-component>
            </div>
            <div class="form-group mb-2">
                <input-container-component 
                    id="storeUserEmail" 
                    title="E-mail"
                    helper-id="storeUserEmailHelp"
                    helper-text="Required. Insert e-mail"
                >
                    <input type="text" class="form-control" id="storeUserEmail" placeholder="Description" aria-describedby="storeUserEmailHelp" v-model="storeUserEmail" required>
                </input-container-component>
            </div>
            <div class="form-group mb-2">
                <input-container-component 
                    id="storeUserPassword" 
                    title="Password"
                    helper-id="storeUserPasswordHelp"
                    helper-text="Required. Insert password"
                >
                    <input type="password" class="form-control" id="storeUserPassword" placeholder="Password" aria-describedby="storeUserPasswordHelp" v-model="storeUserPassword" required>
                </input-container-component>
            </div>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="store()">Save</button>
        </template>

    </modal-component>

    <modal-component id="modalUserView" title="View User">

        <template v-slot:alert>
        </template>

        <template v-slot:content>

            <input-container-component id="viewId" title="Id" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
            </input-container-component>

            <input-container-component id="viewName" title="Name" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.name" disabled>
            </input-container-component>

            <input-container-component id="viewEmail" title="E-mail" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.email" disabled>
            </input-container-component>

            <input-container-component id="viewMaster" title="Master" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.master" disabled>
            </input-container-component>

        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </template>

    </modal-component>

    <modal-component id="modalUserDelete" title="Delete User">

        <template v-slot:alert>
            <alert-component type="success" :details="$store.state.transaction" title="Success" v-if="$store.state.transaction.status == 'success'"></alert-component>
            <alert-component type="danger" :details="$store.state.transaction" title="Error" v-if="$store.state.transaction.status == 'error'"></alert-component>
        </template>

        <template v-slot:content v-if="$store.state.transaction.status != 'success'">
            <input-container-component id="viewId" title="Id" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
            </input-container-component>

            <input-container-component id="viewName" title="name" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.name" disabled>
            </input-container-component>

            <input-container-component id="viewEmail" title="E-mail" helper-id="" helper-text="">
                <input type="text" class="form-control" :value="$store.state.item.email" disabled>
            </input-container-component>

        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" @click="destroy()" v-if="$store.state.transaction.status != 'success'">Remove</button>
        </template>

    </modal-component>

    <modal-component id="modalUserUpdate" title="Update Task">

        <template v-slot:alert>
            <alert-component type="success" :details="$store.state.transaction" title="Success" v-if="$store.state.transaction.status == 'success'"></alert-component>
            <alert-component type="danger" :details="$store.state.transaction" title="Error" v-if="$store.state.transaction.status == 'error'"></alert-component>
        </template>

        <template v-slot:content>
            <div class="form-group mb-2">
                <input-container-component id="updateUserName" title="Name" helper-id="updateUserNameHelp" helper-text="Required. Insert User name">
                    <input type="text" class="form-control" id="updateUserName" placeholder="Task title" aria-describedby="updateUserNameHelp" v-model="$store.state.item.name" required>
                </input-container-component>
            </div>
            <div class="form-group mb-2">
                <input-container-component id="updateUserEmail" title="E-mail" helper-id="updateUserEmailHelp" helper-text="Required. Insert User email">
                    <input type="text" class="form-control" id="updateUserEmail" placeholder="Description" aria-describedby="updateUserEmailHelp" v-model="$store.state.item.email" required>
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
                url: 'http://localhost:9000/api/v1/users',
                storeUserName: '',
                storeUserEmail: '',
                storeUserPassword: '',
                storeStatus: '',
                storeDetails: {},
                users: { data: [] },
                tasksLinks: [],
                search: { id: '', title: '', status: ''}
            }
        },
        methods: {
            update() {
                let formData = new URLSearchParams({
                    'name': this.$store.state.item.name,
                    'email': this.$store.state.item.email,
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
                        this.$store.state.transaction.message = 'User ID ' + this.$store.state.item.id + ' updated!' ;

                        this.list();

                    })
                    .catch(errors => {
                        this.$store.state.transaction.status = 'error';
                        this.$store.state.transaction.message = errors.response.data.message;
                    });
            },
            destroy() {
                let confirmation = confirm('Remove User?')

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
                        this.users = response.data;
                        this.tasksLinks = response.data.meta.links;
                    })
                    .catch(errors => {
                    });
            },
            store() {
                let formData = new URLSearchParams({
                    'name': this.storeUserName,
                    'email': this.storeUserEmail,
                    'password': this.storeUserPassword,
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
                            message: 'User ID created: ' + response.data.data.id
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
            }
        },
        mounted() {
            this.list();
        }
    }
</script>
