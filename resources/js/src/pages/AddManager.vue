<script setup>
import {computed, ref} from 'vue';
import {actionTypes, getterTypes} from '@/store/modules/managers.js';
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import BotsForm from "@/Components/BotsForm.vue";
import router from "@/router/router.js";
import Loader from "@/Components/UI/Loader.vue";
import {useHandleEvent} from "@/Composables/useHandleEvent.js";
import {manager_rows} from "@/ComponentConfigs/Form/Manager/manager_rows.js";

const store = useStore();
const route = useRoute();
const localManagerData = ref({});
const isSubmitting = computed(() => store.getters[getterTypes.isSubmitting]);

const { handleEvent } = useHandleEvent({
    localData: localManagerData,
    actions: { submit: createManager }
});

function createManager() {
    store.dispatch(actionTypes.createManager, localManagerData.value).then((id) => {
        router.push(`/showManagers/${id}`);
    });
}

</script>

<template>
    <loader v-if="isSubmitting"/>

    <div :class="{'loading': isSubmitting}" class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    Add a Manager
                </div>
                <bots-form
                    :data="localManagerData"
                    :rows="manager_rows"
                    @handle="handleEvent"/>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.loading {
    opacity: 0.5;
    pointer-events: none;
}
</style>
