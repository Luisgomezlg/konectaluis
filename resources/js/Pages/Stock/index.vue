
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>
<script>
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from 'axios';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, SelectorIcon, PaperClipIcon } from '@heroicons/vue/solid'
import Swal from 'sweetalert2'
import router from "../../router";
import Navbar from "../Estructura/Navbar.vue";

export default {
    props: ['stocks'],

    data() {
        return {
            stocksprop: {},

        }

    },
    mounted() {
        this.ventasFunci()
    },

    beforeDestroy() {
    },

    methods: {
        created() {
            this.ventasFunci()
        },
        ventasFunci() {
            this.stocksprop = this.stocks;
        },
    }

}

</script>

<style scoped>
.upload-images {
    width: 100px !important;
    height: 100px !important;
}

.tool-bar-img {
    font-size: 12px;
}
</style>

<template class="">
    <div class="inicio">

        <title>Stock</title>
        <Navbar />

        <div class="m-8 grid gap-4 content-center my-44 ">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Productos en stock</h5>

            <div class="overflow-x-auto relative shadow-md">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Producto
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Cantidad
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Fecha
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="stock in stocksprop" :key="stock.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ stock.sto_producto }}
                            </th>
                            <td class="py-4 px-6">
                                {{ stock.sto_cantidad }}
                            </td>
                            <td class="py-4 px-6">
                                {{ stock.sto_fecha }}
                            </td>
                        </tr>
                        <div>

                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
