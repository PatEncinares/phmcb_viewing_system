<template>
<div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 style="font-size: 30px; font-weight: bold; margin: 0;">Specializations</h3>
                    <button class="btn btn-primary" style="font-size: 13px; font-weight: 600;" v-on:click="createRecord()">+ Add Specialization</button>
                </div>
                
                <div class="mt-5">
                    <v-client-table :data="dataTable" :columns="columns" :options="options">
                        <template slot="actions" slot-scope="props">
                            <button class="btn btn-success" v-on:click="editData(props.row.id)">Edit</button>
                            <button class="btn btn-danger" v-on:click="destroyData(props.row.id)">Delete</button>
                        </template>
                    </v-client-table>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal" id="create-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="body p-3">
                    <div class="d-flex justify-content-between align-items-center border-bottom p-3">
                        <h3 style="font-size: 20px; font-weight: bold; margin: 0;" v-if="isEdit">Update Specialization</h3>
                        <h3 style="font-size: 20px; font-weight: bold; margin: 0;" v-else>New Specialization</h3>
                        <button class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-12">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="dataValues.name">
                            <span style="font-size: 12px; color: red;" :error="errors" v-if="errors.name">{{ errors.name[0] }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end border-top p-3">
                        <button class="btn btn-warning" style="font-size: 13px; font-weight: 600" v-on:click="store()">Save</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            errors : [],
            dataValues : [],
            dataTable : [],
            columns : ['id', 'name', 'actions'],
            options : {
                headings : {
                    id : 'ID',
                    name : 'Name',
                    actions : 'Action',
                },
            },

            isEdit : false,
        }
    },
    methods : {

        showRecords() {
            axios.get('specialization/getrecords').then( response => {
                this.dataTable = response.data.data;
            });
        },

        createRecord(){
            this.isEdit = false;
            this.dataValues = {
                name : '',
            };
            $('#create-modal').modal('show');
        },

        store() {
            axios.post('specialization/store', this.dataValues).then( response =>{
                this.$fire({
                            title: "Success",
                            text: response.data.message,
                            type: "success",
                            timer: 3000
                        });
                        $('#create-modal').modal('hide');
                        this.showRecords();
            });
        },

        editData(id) {
            this.isEdit = true;
            $('#create-modal').modal('show');
            axios.get('specialization/edit/' + id).then( response => {
                this.dataValues = response.data.data;
            });
        },

        destroyData(id) {
            this.$confirm("Are you sure you want to Delete this Data?", 'Delete?', 'question').then(() => {
                    axios.get('specialization/destroy/' + id).then(response => {
                        if(response.status === 200) {
                            this.$fire({
                                title: "Success",
                                text: response.data.message,
                                type: "success",
                                timer: 3000
                            });
                        }
                        this.showRecords();
                    })
                    .catch(errors => {
                        if(errors.response.data.message.length > 0) {
                            this.$fire({
                                title: "Failed",
                                text: errors.response.data.message,
                                type: "error",
                                timer: 3000
                            });
                        }
                    })
                });


            
        },
    },

    mounted() {
        this.showRecords();
    }
}
</script>
