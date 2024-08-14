style scoped>
    #appendTable {
        display: none;
    }
</style>
<template>
    <div>
        <breadcrumb-component current_title="Doctor Health Maintenance Organization"></breadcrumb-component>

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
                        <label for="">Doctor</label>
                            <v-select 
                                :options="doctors" 
                                :reduce="item => item.id" 
                                label="full_name" 
                                v-model="dataValues.doctor_detail_id"
                                placeholder="Select Doctor"
                            ></v-select>
                                <div class="text-danger" v-if="errors.doctor_detail_id">{{ errors.doctor_detail_id[0] }}</div>
                    </div>


                    <div class="col-12">
                        <label for="">HMO's</label>
                            <div class="form-control" v-for="item in master_data_hmos" :key="item.id">
                                <label>
                                <input type="checkbox" 
                                :value="item.id" 
                                v-model="dataValues.selectedHmos">
                                {{ item.name }}
                                </label>
                            </div>
                                <div class="text-danger" v-if="errors.selectedHmos">{{ errors.selectedHmos[0] }}</div>
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
import FormComponent from "./partials/FormComponent";
import ModalComponent from "./partials/ModalComponent";
export default {
    data() {
        return {
            errors : [],
            dataValues : [

            ],   
            dataTable : [],
            columns : ['full_name',  'hmos', 'action'],
            options : {
                headings : {
                    full_name : 'Doctor',
                    hmos : 'HMOs',
                    action : 'Actions',
                },

                filterable: false,
                sortable: ['id'],
            },
            doctors : [],
            master_data_hmos : [],
            modalId: 'modal-hmo',
            modalTitle: 'Add Doctor HMO',
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
                selectedHmos : [],
            };
        },

        loadRecords() {
            axios.get('doctor_hmo/getrecords').then( response => {
                this.dataTable = response.data.data;
                this.doctors = response.data.doctors;
                this.master_data_hmos = response.data.master_data_hmos;
            });
        },


        createData() {
            this.clearForm();
            this.isEdit = false;
            $('#' + this.modalId).modal('show');
        },

        storeData() {
            axios.post('doctor_hmo/store', this.dataValues)
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
            this.modalTitle = 'Edit Doctor HMO';
            this.isEdit = true;
            axios.get('doctor_hmo/edit/' + props.data.doctor_detail_id).then( response => {
                this.dataValues = response.data.data;
                this.dataValues.selectedHmos = response.data.data.hmos;
                $('#' + this.modalId).modal('show');
            });
        },


        destroyData(props) {
            this.$confirm("Are you sure you want to delete this data?", 'Delete?', 'question').then(() => {
                axios.get('doctor_hmo/destroy/' + props.data.doctor_detail_id).then(response => {
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
        },

    },

   

    mounted() {
        this.loadRecords();
    }

}
</script>