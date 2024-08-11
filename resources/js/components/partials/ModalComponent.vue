<template>
    <div class="modal" :id="id">
        <div :class="'modal-dialog' + size">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-start align-items-center mb-3">
                        <h5 class="m-0">{{ title }}</h5>
                        <slot name="modalEditButton"></slot>
                    </div>
                    <slot name="modalBody"></slot>
                </div>
                <div class="modal-footer">
                    <slot name="modalFooter"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props: {
        id : String,
        title : String,
        size : String,
    }

}
</script>

<style scoped>

</style>
