<style scoped>

    .form-spacing{
        padding: 0px 10px 0px 10px;
    }
    .search-bar{
        margin: auto;
    }

    .search{
        background: #F5F5F5;
        border: none;
        margin: auto;
        border-radius: 5px;
        padding: 6px 4px 6px 30px;
    }

    .search-icon{
        position: absolute;
        left:29px;
        top: 30px;
    }

    .btn-print{
        border: none;
        background-color: #ffff;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        width:80px;
        height: 35px;
    }

    .inner-print{
        margin: auto;
        padding: 20px;
    }

    .btn-create{
        background: #0007B4;
        width:120px;
        height: 35px;
        color: #fff;
        border-radius: 5px;
        border: none;
    }

    .btn-refresh{
        width:120px;
        height: 35px;
        color: #fff;
        border-radius: 5px;
        border: none;
    }

    .btn-tos{
        background: #0007B4;
        width:100%;
        height: 35px;
        color: #fff;
        border-radius: 5px;
        border: none;
    }

    .btn-padding{
        padding-left: 20px;
    }
    .dropdwn-padding{
        padding-left: 20px;
    }

    .refresh-data{
        margin: auto;
    }

    .year{
        background: #F5F5F5;
        border: none;
        margin: auto;
        border-radius: 5px;
        padding: 6px 4px 6px 6px;
    }

    .year-refresh{
        background: #0007B4;
        width:100%;
        color: #fff;
        border-radius: 5px;
        border: none;
        padding: 5px 20px 5px 20px;
    }

    .search-pad{
        padding-left: 15px;
    }

    .refresh-pad{
        padding-left: 5px;
        margin: auto;
    }


</style>


<template>
    <div>
        <div class="form-spacing">
            <div class="card" v-if="withUserControl">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="search-bar" v-if="search_bar">
                                <div>
                                    <i class="fa fa-search search-icon" aria-hidden="true"></i>
                                    <input class="search" type="text" @keyup="onSearch($event)" placeholder="Search...">
                                </div>
                                
                                <!-- @blur -->
                            </div>  
                            <div class="refresh-data m-auto" v-if="refresh_data">
                                <div class="d-flex justify-content-around">
                                    <div class="refresh-pad">
                                         <slot name="year"></slot>
                                    </div>
                                    <div class="refresh-pad">
                                        <slot name="dropdown">
                                        </slot>
                                    </div>
                                    <div class="refresh-pad"><button class="btn btn-success btn-refresh"  @click="onRefresh">REFRESH</button></div>
                                    <!-- <div class="search-pad">@keyup.enter="onRefresh($event)"
                                        <button class="year-refresh" v-on:click="addClicked">REFRESH</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <!-- <div><button class="btn-print" v-on:click="excel">Export</button></div> -->
                            <!-- <div><button class="btn-print" v-on:click="print">Print<i class="fa fa-print" style="padding-left: 5px;" aria-hidden="true"></i></button></div>     -->
                            <div class="btn-padding" v-if="btn_create"><button class="btn-create" v-on:click="addClicked"><i class="fa fa-plus" aria-hidden="true"></i> Create New </button></div> 
                            <!-- <div class="btn-padding" v-if="btn_refresh"><button class="btn-create" v-on:click="addClicked"> REFRESH </button></div>  -->
                            <!-- <div class="btn-padding" v-if="btn_tos"><button class="btn-tos" v-on:click="addClicked"> GET TYPE OF STRUCTURES </button></div>  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-spacing">
            <div class="card">
                <div class="card-body">
                    <v-client-table :data="data" :columns="columns" :options="options" v-if="withTable">
                        <template slot="action" slot-scope="props">
                            <div class="text-center m-auto" style="width: 200px;">
                                <!-- <button class="btn btn-overlay" v-on:click="showButtonClicked(props)" v-if="indexClicked !== props.index - 1"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button> -->
                                <button class="btn btn-primary" v-on:click="viewClicked(props)"><i class="fa fa-edit mr-2" aria-hidden="true"></i>Edit</button>
                                <button v-if="btn_del" class="btn btn-danger" v-on:click="deleteClicked(props)"><i class="fa fa-trash mr-2" aria-hidden="true"></i>Delete</button>
                            </div>
                        </template> 
                    </v-client-table>
                <slot name="formBody" v-else></slot>
            </div>
        </div>
    </div>
</div>
</template>

<script>

    export default{
        props:{
            title: {
                type: String,
                default : ()=>'Form-Title'
            },
            data: {
                type: Array,
                default : ()=>[]
            },
            columns: {
                type: Array,
                default : ()=>[]
            },
            options: {
                type: Object,
                default : ()=>{
                    return {message:'Hello'}
                }
            },
            withUserControl: {
                type: Boolean,
                default : ()=>true
            },
            withTable: {
                type: Boolean,
                default : ()=>true
            },
            refresh_data : {
                type: Boolean,
                default : ()=>false
            },
            btn_refresh : {
                type: Boolean,
                default : ()=>false
            },
            btn_tos : {
                type: Boolean,
                default : ()=>false
            },
            btn_create : {
                type: Boolean,
                default : ()=>true
            },
            btn_del : {
                type: Boolean,
                default : ()=>true
            },
            search_bar : {
                type: Boolean,
                default : ()=>true
            }
            // create : true,
            // search : true,
            // search_year : false,
        },
        data(){ 
            return {
                indexClicked:  '',
            }
        },
        methods: {
            onRefresh(){
                this.$emit('searchRefresh', true);
            },
            onSearch(e){
                this.$emit('searchResult', e.target.value);
            },
            addClicked() {
                this.$emit('addClicked', true);
            },
            viewClicked(props) {
                this.$emit('viewClicked', { data: props.row });
            },
            deleteClicked(props) {
                this.$emit('deleteClicked', { data: props.row });
            },
            showButtonClicked(props) {
                this.indexClicked = props.index - 1;
            },
            print() {
                this.$emit('print', true);
            },
            excel() {
                this.$emit('export', true);
            },

        },
    };
  </script>
