<template>
    <div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" scope="col" v-for="t, key in titles" :key="key">{{ t.title }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, key in filtredData" :key="key">
                    <td class="text-center" v-for="value, keyValue in obj" :key="keyValue">
                        {{ value ?? '-' }}
                    </td>
                    <td class="d-flex gap-2">
                        <button v-if="view.visible" class="btn btn-outline-primary btn-sm" :data-bs-toggle="view.dataToggle" :data-bs-target="view.dataTarget" @click="setStore(obj)">View</button>
                        <button v-if="edit.visible" class="btn btn-outline-success btn-sm" :data-bs-toggle="edit.dataToggle" :data-bs-target="edit.dataTarget" @click="setStore(obj)">Edit</button>
                        <button v-if="destroy.visible" class="btn btn-outline-danger btn-sm" :data-bs-toggle="destroy.dataToggle" :data-bs-target="destroy.dataTarget" @click="setStore(obj)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['data','titles','view','edit','destroy'],
        methods: {
            setStore(obj) {
                this.$store.state.transaction.status = '';
                this.$store.state.transaction.message = '';
                this.$store.state.item = obj;
            }
        },
        computed: {
            filtredData() {
                let fields = Object.keys(this.titles)
                let filtredData = []
                this.data.map((item, key) => {
                    let filtredItem = {}
                    fields.forEach(field => {
                        filtredItem[field] = item[field]
                    })
                    filtredData.push(filtredItem)
                })

                return filtredData
            }
        }
    }
</script>
