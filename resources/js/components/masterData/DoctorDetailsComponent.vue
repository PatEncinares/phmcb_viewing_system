style scoped>
    #appendTable {
        display: none;
    }
</style>
<template>
    <div>
        <breadcrumb-component parent_title="Master Data" current_title="Doctors"></breadcrumb-component>

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
                        <label for="">Last Name</label>
                            <input type="text" class="form-control" v-model="dataValues.last_name">
                                <div class="text-danger" v-if="errors.last_name">{{ errors.last_name[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">First Name</label>
                            <input type="text" class="form-control" v-model="dataValues.first_name">
                                <div class="text-danger" v-if="errors.first_name">{{ errors.first_name[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">Middle Name</label>
                            <input type="text" class="form-control" v-model="dataValues.middle_name">
                                <div class="text-danger" v-if="errors.middle_name">{{ errors.middle_name[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">Secretary Contact #</label>
                            <input type="number" class="form-control" v-model="dataValues.secretary_contact_number">
                                <div class="text-danger" v-if="errors.secretary_contact_number">{{ errors.secretary_contact_number[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">Status</label>
                            <select class="form-control" v-model="dataValues.status">
                                <option disabled selected>Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="On-Leave">On-Leave</option>
                            </select>
                                <div class="text-danger" v-if="errors.secretary_contact_number">{{ errors.secretary_contact_number[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">Schedule</label>
                        <textarea class="form-control" name="" id="" placeholder="Write your schedule here.." v-model="dataValues.schedule"></textarea>
                    </div>

                    <div class="col-12">
                        <label for="">remarks</label>
                        <textarea class="form-control" name="" id="" placeholder="Write your remarks here.." v-model="dataValues.remarks"></textarea>
                    </div>


                    <!-- <div class="col-12">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" class="form-control" @change="handleFileUpload">
                        <div class="text-danger" v-if="errors.profile_image">{{ errors.profile_image[0] }}</div>
                    </div> -->

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
            columns : ['id', 'full_name', 'secretary_contact_number', 'status', 'schedule', 'remarks', 'action'],
            options : {
                headings : {
                    id : '#',
                    full_name : 'Name',
                    secretary_contact_number : 'Secretary Contact #',
                    status : 'Status',
                    schedule : 'Schedule',
                    remarks : 'Remarks',
                    action : 'Actions',
                },

                filterable: false,
                sortable: ['id'],
            },
            modalId: 'modal-doctor',
            modalTitle: 'Add Doctor',
            modalSize: '',
            fieldDisabled: true,
            isEdit: false,
            // imageArr : [],
            image_file : '',
            image_file_name : '',
            file_type : '',
            doctor_id : null,
            
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
                last_name: '',
                first_name: '',
                middle_name: '',
                secretary_contact_number: '',
                status: '',
                schedule : '',
                remarks : '',
                // profile_image: ''
            };
            this.doctor_id = null;
        },

        loadRecords() {
            axios.get('doctordetails/getrecords').then( response => {
                this.dataTable = response.data.data;
            });
        },


        createData() {
            this.clearForm();
            this.isEdit = false;
            $('#' + this.modalId).modal('show');
        },

        handleFileUpload(e) {
        //   this.imageArr.push({
        //     image_file : e.target.files[0],
        //     image_file_name : e.target.files[0].name,
        //     file_type : e.target.files[0].type,
        //   });
          this.image_file = e.target.files[0];  
          this.image_file_name = e.target.files[0].name;
          this.file_type = e.target.files[0].type;
          console.log(this.image_file);
          
        },

        storeData() {
            const formData = new FormData();
            const headerConfig = {
                headers : {
                    'Content-Type': 'multipart/form-data'
                }
             }

           if (this.isEdit) {
                formData.append('id', this.doctor_id);
           }
            
            formData.append('last_name', this.dataValues.last_name);
            formData.append('first_name', this.dataValues.first_name);
            formData.append('middle_name', this.dataValues.middle_name);
            formData.append('secretary_contact_number', this.dataValues.secretary_contact_number);
            formData.append('status', this.dataValues.status);
            formData.append('schedule', this.dataValues.schedule);
            formData.append('remarks', this.dataValues.remarks);
            // formData.append('image_file', this.image_file);
            // formData.append('image_file_name', this.image_file_name);
            // formData.append('file_type', this.file_type);
            
            // for (let pair of formData.entries()) {
            //     console.log(pair[0], pair[1]);
            // }


            axios.post('doctordetails/store', formData, headerConfig)
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
            this.modalTitle = 'Edit Doctor';
            this.isEdit = true;
            axios.get('doctordetails/edit/' + props.data.id).then( response => {
                this.dataValues = response.data.data;
                this.doctor_id = props.data.id;
                $('#' + this.modalId).modal('show');
            })
        },


        destroyData(props) {
            this.$confirm("Are you sure you want to delete this data?", 'Delete?', 'question').then(() => {
                axios.get('doctordetails/destroy/' + props.data.id).then(response => {
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