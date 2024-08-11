<style scoped>
    .bread-spacing{
        padding: 10px 10px 0px 10px;
    }
    .title-text{
        color: #0E723E;
        font-weight: 600;
    }

    .icon{
        padding: 0px 10px 0px 10px;
    }

    .main-text{
        font-weight: 600;
    }

</style>

<template>
    <div class="bread-spacing">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="main-text">{{ parent_title }}</div>
                    <div class="icon"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                    <div class="title-text">{{ current_title }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default{
    props:{
        parent_title: String,
        current_title: String,        
    },
    data() {
        return {
           
        };
    },
    methods:{
        
    }

}
</script>