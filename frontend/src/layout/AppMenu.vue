<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' }]
    },
    {
        label: 'Surat Resmi',
        items: [
            {
                label: 'Kedinasan',
                icon: 'pi pi-fw pi-briefcase',
                items: [
                    {
                        label: 'Surat Perintah',
                        icon: 'pi pi-fw pi-database',
                        items: [
                            { label: 'Data Surat', icon: 'pi pi-fw pi-file-edit', to: '/suratperintah' },
                            { label: 'Data Formatt', icon: 'pi pi-fw pi-file-edit', to: '/formatt-suratperintah' },
                        ]
                    },
                ]
            },
        ]
    },
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
