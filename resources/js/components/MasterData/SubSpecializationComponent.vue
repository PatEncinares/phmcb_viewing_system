<template>
    <div>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 style="font-size: 30px; font-weight: bold; margin: 0;">Sub Specializations</h3>
                        <button class="btn btn-primary" style="font-size: 13px; font-weight: 600;" v-on:click="createRecord()">+ Add Sub Specialization</button>
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
                            <h3 style="font-size: 20px; font-weight: bold; margin: 0;" v-if="isEdit">Update Sub Specialization</h3>
                            <h3 style="font-size: 20px; font-weight: bold; margin: 0;" v-else>New Sub Specialization</h3>
                            <button class="close" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-12">
                                <label>Specialization</label>
                                <select class="form-control" v-model="dataValues.specialization_id">
                                    <option disabled selected>Select Specialization</option>
                                    <option v-for="item in specializations" :value="item.id">{{ item.name }}</option>
                                </select>
                                <span style="font-size: 12px; color: red;" :error="errors" v-if="errors.name">{{ errors.name[0] }}</span>
                            </div>
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
                columns : ['id', 'specialization_name' ,'name', 'actions'],
                options : {
                    headings : {
                        id : 'ID',
                        specialization_name : 'Specialization',
                        name : 'Name',
                        actions : 'Action',
                    },
                },
    
                isEdit : false,
                specializations : [],
            }
        },
        methods : {
            sweetAlert(title, text, type) {
                this.$fire({
                    title: title,
                    text: text,
                    type: type,
                    timer: 3000
                });
            },
    
            showRecords() {
                axios.get('subspecialization/getrecords').then( response => {
                    this.dataTable = response.data.data;
                    this.specializations = response.data.specializations;
                });
            },
    
            createRecord(){
                this.isEdit = false;
                this.dataValues = {
                    specialization_id : '',
                    name : '',
                };
                $('#create-modal').modal('show');
            },
    
            store() {
                axios.post('subspecialization/store', this.dataValues).then(response => {
                    this.sweetAlert("Success", response.data.message, "success");
                    $('#create-modal').modal('hide');
                    this.showRecords();
                }).catch(errors => {
                    this.errors = errors.response.data.errors;
                    // this.sweetAlert("Failed", "There was an error saving the specialization.", "error");
                });
                   
            },
    
            editData(id) {
                this.isEdit = true;
                $('#create-modal').modal('show');
                axios.get('subspecialization/edit/' + id).then( response => {
                    this.dataValues = response.data.data;
                });
            },
    
            destroyData(id) {
                this.$confirm("Are you sure you want to delete this data?", 'Delete?', 'question').then(() => {
                    axios.get('subspecialization/destroy/' + id).then(response => {
                        if (response.status === 200) {
                            this.sweetAlert("Success", response.data.message, "success");
                        }
                        this.showRecords();
                    }).catch(errors => {
                        if (errors.response.data.message.length > 0) {
                            this.sweetAlert("Failed", errors.response.data.message, "error");
                        }
                    });
                });
            },
        },
    
        mounted() {
            this.showRecords();
        }
    }
    </script>
    