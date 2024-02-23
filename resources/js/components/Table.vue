<template>
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
                        <button v-if="view" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalTaskView">View</button>
                        <button v-if="edit" class="btn btn-outline-success btn-sm">Edit</button>
                        <button v-if="delete" class="btn btn-outline-danger btn-sm">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
</template>

<script>
    export default {
        props: ['data','titles','view','edit','delete'],
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
