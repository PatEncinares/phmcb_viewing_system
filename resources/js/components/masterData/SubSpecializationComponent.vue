style scoped>
    #appendTable {
        display: none;
    }
</style>
<template>
    <div>
        <breadcrumb-component parent_title="Master Data" current_title="Sub Specializations"></breadcrumb-component>

        <FormComponent 
            :data="dataTable" 
            :columns="columns" 
            :options="options" 
            :withTable="true" 
            :withUserControl="true"
            @addClicked="createData" 
            @viewClicked="editData"
            @deleteClicked="destroyData" 
        >
        </FormComponent>

        <ModalComponent :id="modalId" :title="modalTitle" :size="modalSize">
            <!-- <template slot="modalEditButton">
                <button class="btn btn-view" v-if="!isAdd" v-on:click="editData">
                    <i class="fas fa-edit"></i>
                </button>
            </template> -->
            <template slot="modalBody">
                <div class="row">
                    <div class="col-12">
                        <label for="">Specialization</label>
                            <select class="form-control" name="" id="" v-model="dataValues.specialization_id">
                                <option disabled selected>Select Specialization</option>
                                <option v-for="item in specializations" :value="item.id"> {{ item.name }}</option>
                            </select>
                                <div class="text-danger" v-if="errors.specialization_id">{{ errors.specialization_id[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">Name</label>
                        <input type="text" class="form-control" v-model="dataValues.name">
                                <div class="text-danger" v-if="errors.name">{{ errors.name[0] }}</div>
                    </div>
                </div>
            </template>
            <template slot="modalFooter">
                <div class="text-right">
                    <button class="btn btn-primary" v-on:click="storeData">Save Data</button>
                    <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </template>
        </ModalComponent>

        <div id="appendTable"></div>
    </div>
</template>
<script>
import axios from 'axios';
import FormComponent from "../partials/FormComponent";
import ModalComponent from "../partials/ModalComponent";
export default {
    data() {
        return {
            errors : [],
            dataValues : [

            ],   
            dataTable : [],
            columns : ['id', 'specialization_name', 'name', 'action'],
            options : {
                headings : {
                    id : '#',
                    specialization_name : 'Specialization',
                    name : 'Sub Specialization Name',
                    action : 'Actions',
                },

                filterable: false,
                sortable: ['id'],
            },
            specializations : [],
            modalId: 'modal-sub-specialization',
            modalTitle: 'Add Sub Specialization',
            modalSize: '',
            fieldDisabled: true,
            isEdit: false,
            
            
        }
    },

    components : {
        FormComponent,
        ModalComponent
    },

    methods : {
        sweetAlert(title, text, type) {
            this.$fire({
                title : title,
                text : text,
                type : type,
                timer : 3000
            });
        },

        clearForm() {
            this.dataValues = {
                doctor_detail_id : '',
                name : '',
            };
        },

        loadRecords() {
            axios.get('subspecialization/getrecords').then( response => {
                this.dataTable = response.data.data;
                this.specializations = response.data.specializations;

                console.log(response.data.doctors);
            });
        },


        createData() {
            this.clearForm();
            this.isEdit = false;
            $('#' + this.modalId).modal('show');
        },

        storeData() {
            axios.post('subspecialization/store', this.dataValues)
            .then(response => {
                this.sweetAlert('Success', response.data.message, 'success');
                $('#' + this.modalId).modal('hide');
                this.loadRecords();
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        editData(props) {
            this.modalTitle = 'Edit Sub Specialization';
            this.isEdit = true;
            axios.get('subspecialization/edit/' + props.data.id).then( response => {
                this.dataValues = response.data.data;
                $('#' + this.modalId).modal('show');
            });
        },


        destroyData(props) {
            this.$confirm("Are you sure you want to delete this data?", 'Delete?', 'question').then(() => {
                axios.get('subspecialization/destroy/' + props.data.id).then(response => {
                    if (response.status === 200) {
                        this.sweetAlert("Success", response.data.message, "success");
                    }
                    this.loadRecords();
                }).catch(errors => {
                    if (errors.response.data.message.length > 0) {
                        this.sweetAlert("Failed", errors.response.data.message, "error");
                    }
                });
            });
        }





    },

   

    mounted() {
        this.loadRecords();
    }

}
</script>