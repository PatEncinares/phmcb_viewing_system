style scoped>
    #appendTable {
        display: none;
    }
</style>
<template>
    <div>
        <breadcrumb-component parent_title="Master Data" current_title="Rooms"></breadcrumb-component>

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
                            <select class="form-control" name="" id="" v-model="dataValues.doctor_detail_id">
                                <option disabled selected>Select Doctor</option>
                                <option v-for="item in doctors" :value="item.id"> {{ item.full_name }}</option>
                            </select>
                                <div class="text-danger" v-if="errors.doctor_detail_id">{{ errors.doctor_detail_id[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">Building</label>
                            <select class="form-control" name="" id="" v-model="dataValues.building_name">
                                <option disabled selected>Select Building</option>
                                <option value="MAB1">MAB1</option>
                                <option value="MAB2">MAB2</option>
                                <option value="JONELTA">JONELTA</option>
                                <option value="Hospital Main">Hospital Main</option>
                            </select>
                                <div class="text-danger" v-if="errors.building_name">{{ errors.building_name[0] }}</div>
                    </div>

                    <div class="col-12">
                        <label for="">Room</label>
                            <input type="text" class="form-control" v-model="dataValues.room_number">
                                <div class="text-danger" v-if="errors.room_number">{{ errors.room_number[0] }}</div>
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
            columns : ['id', 'full_name', 'building_name', 'room_number', 'action'],
            options : {
                headings : {
                    id : '#',
                    full_name : 'Doctor',
                    building_name : 'Building',
                    room_number : 'Room #',
                    action : 'Actions',
                },

                filterable: false,
                sortable: ['id'],
            },
            doctors : [],
            modalId: 'modal-rooms',
            modalTitle: 'Add Room',
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
                building_name : '',
                room_number : '',
            };
        },

        loadRecords() {
            axios.get('room/getrecords').then( response => {
                this.dataTable = response.data.data;
                this.doctors = response.data.doctors;

                console.log(response.data.doctors);
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
            axios.post('room/store', this.dataValues)
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
            this.modalTitle = 'Edit Room';
            this.isEdit = true;
            axios.get('room/edit/' + props.data.id).then( response => {
                this.dataValues = response.data.data;
                $('#' + this.modalId).modal('show');
            });
        },


        destroyData(props) {
            this.$confirm("Are you sure you want to delete this data?", 'Delete?', 'question').then(() => {
                axios.get('room/destroy/' + props.data.id).then(response => {
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