
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>
<script>
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from 'axios';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, SelectorIcon, PaperClipIcon } from '@heroicons/vue/solid'
import { resetTracking } from '@vue/reactivity';
import Swal from 'sweetalert2'
import router from "../../router";
import Navbar from "../Estructura/Navbar.vue";

import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'

const open = ref(false)
//const opencoments = ref(false)
const crearproducto = ref(false)

const people = [
    {
        id: 1,
        name: 'Cafeina'
    },
    {
        id: 2,
        name: 'Panes'
    },
    {
        id: 3,
        name: 'Especiales'
    }
]

const selected = ref(people[0])
export default {
    //props: ['temas'],

    data() {
        return {
            productos: {},
            productospublic: {},
            pro_nombre: '',
            pro_referencia: '',
            pro_categoria: '',
            pro_precio: '',
            pro_peso: '',
            pro_stock: '',

        }

    },
    mounted() {
        this.productosFunci()
        this.productospublicFunci.call()

    },

    beforeDestroy() {
    },

    methods: {
        abrirmodalherramientas() {
            crearproducto.value = true;
            // this.iconcerrar = 1;
        },
        cerrarherramientas() {
            open.value = false;
            this.iconcerrar = 0;
        },
        productosFunci() {
            axios.get('/productosapi')
                .then((response) => {
                    this.productos = response.data[0];

                    //console.log(selected.value[0]);
                })
        },
        productospublicFunci() {
            axios.get('/productosapipublic')
                .then((response) => {
                    this.productospublic = response.data[0];

                    //console.log(this.productospublic[0])
                })
        },
        eliminarproducto(id) {

            Swal.fire({
                title: '¿Está seguro de eliminar este producto?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                confirmButtonColor: '#6EE7B7',
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                let midis = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                let data = new FormData();
                data.append('id', id);
                if (result.isConfirmed) {
                    axios.post('/eliminarproducto', data, config)
                        .then((res) => {
                            midis.success = res.data.success;
                            midis.ejecucion = res.data.ejecucion;
                            console.log(midis.success);
                            console.log(midis.ejecucion);
                            if (midis.ejecucion == true) {
                                Swal.fire("Exito", "Eliminado correctamente", "success");
                            }
                        })
                    this.productosFunci()

                }
            })

        },
        created() {
            this.productosFunci()
            this.productospublicFunci.call()

        },
        submitpost(e) {
            e.preventDefault();
            let midis = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('pro_nombre', this.pro_nombre);
            data.append('pro_referencia', this.pro_referencia);
            data.append('pro_precio', this.pro_precio);
            data.append('pro_peso', this.pro_peso);
            data.append('pro_stock', this.pro_stock);
            data.append('pro_categoria', this.selected.name);
            axios.post('/crearproducto', data, config)
                .then(function (res) {
                    midis.success = res.data.success;
                    midis.ejecucion = res.data.ejecucion;
                    console.log(midis.success);
                    console.log(midis.ejecucion);
                    if (midis.ejecucion == true) {
                        crearproducto.value = false;
                        Swal.fire("Exito", "Guardado correctamente", "success");
                    } else {
                        Swal.fire("Lo sentimos", "No se guardaron datos", "error");

                    }

                })
                .catch(function (err) {
                    midis.output = err;
                    console.log(midis.output);
                });
            this.productosFunci.call()
            this.pro_nombre = '';
            this.pro_referencia = '';
            this.pro_precio = '';
            this.pro_peso = '';
            this.pro_stock = '';
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
    <title>Productos</title>
    <div class="inicio">


        <Navbar />

        <div class="m-8 grid gap-4 content-center">
            <div class="mt-8">
                <button type="button" @click="crearproducto = true" class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 
        focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-base px-6 py-3.5 text-center 
        dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">Crear Producto</button>

            </div>
        </div>

        <div class="m-8 grid gap-4 content-center my-44 ">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Productos</h5>

            <div class="overflow-x-auto relative shadow-md">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Producto
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Referencia
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Categoria
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Precio
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Cantidad
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in productos" :key="producto.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ producto.pro_nombre }}
                            </th>
                            <td class="py-4 px-6">
                                {{ producto.pro_referencia }}
                            </td>
                            <td class="py-4 px-6">
                                {{ producto.pro_categoria }}
                            </td>
                            <td class="py-4 px-6">
                                {{ producto.pro_precio }}
                            </td>
                            <td class="py-4 px-6">
                                {{ producto.pro_stock }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex">
                                    <Link :href="'/editarproducto/' + producto.id">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    </Link>
                                    <button @click="eliminarproducto(producto.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>



        <TransitionRoot as="template" :show="crearproducto">
            <Dialog as="div" class="relative z-10" @close="crearproducto = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                    enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="grid justify-items-center fixed z-10 inset-0 overflow-y-auto">
                    <div
                        class="flex items-end sm:items-center  justify-center max-w-5xl min-h-full p-4 text-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">


                            <DialogPanel
                                className="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all">
                                <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div className="sm:flex sm:items-start">
                                        <div className="mt-12 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <DialogTitle as="h3"
                                                className="text-lg mt-3 leading-6 font-medium text-gray-900">
                                                Crear productos
                                            </DialogTitle>
                                            <div className="mt-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-4 py-3 sm:px-6">
                                    <div className="md:grid md:grid-cols-2 md:gap-6">
                                        <div className="mt-5 md:mt-0 md:col-span-2">
                                            <form @submit="submitpost">
                                                <div className="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                        <div className="flex gap-6">


                                                            <div className="w-full">
                                                                <label htmlFor="email"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Categoria
                                                                </label>

                                                                <Listbox as="div" v-model="selected">
                                                                    <div class="mt-1 relative">
                                                                        <ListboxButton
                                                                            class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                            <span class="flex items-center">
                                                                                <!--<img :src="selected.avatar" alt=""
                                                                                    class="flex-shrink-0 h-6 w-6 rounded-full" />-->
                                                                                <span class="ml-3 block truncate">{{
                                                                                        selected.name
                                                                                }}</span>
                                                                            </span>
                                                                            <span
                                                                                class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                                                                <SelectorIcon
                                                                                    class="h-5 w-5 text-gray-400"
                                                                                    aria-hidden="true" />
                                                                            </span>
                                                                        </ListboxButton>

                                                                        <transition
                                                                            leave-active-class="transition ease-in duration-100"
                                                                            leave-from-class="opacity-100"
                                                                            leave-to-class="opacity-0">
                                                                            <ListboxOptions
                                                                                class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                                                                <ListboxOption as="template"
                                                                                    v-for="person in people"
                                                                                    :key="person.id" :value="person"
                                                                                    v-slot="{ active, selected }">
                                                                                    <li
                                                                                        :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                                                                                        <div class="flex items-center">
                                                                                            <!--<img :src="person.avatar"
                                                                                                alt=""
                                                                                                class="flex-shrink-0 h-6 w-6 rounded-full" />-->
                                                                                            <span
                                                                                                :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                                                                                                {{ person.name }}
                                                                                            </span>
                                                                                        </div>

                                                                                        <span v-if="selected"
                                                                                            :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                                                            <CheckIcon class="h-5 w-5"
                                                                                                aria-hidden="true" />
                                                                                        </span>
                                                                                    </li>
                                                                                </ListboxOption>
                                                                            </ListboxOptions>
                                                                        </transition>
                                                                    </div>
                                                                </Listbox>
                                                            </div>
                                                            <div className="w-full">
                                                                <label htmlFor="titulo"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nombre</label>
                                                                <input type="text" id="titulo" v-model="pro_nombre"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    placeholder="" required />
                                                            </div>
                                                        </div>
                                                        <!--***********************  MES  *************************** -->
                                                        <div className="flex gap-6">

                                                            <div className="w-full">
                                                                <label htmlFor="pos_color"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Referencia</label>
                                                                <input type="text" v-model="pro_referencia"
                                                                    id="pos_color"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    required />
                                                            </div>


                                                            <div className="w-full">
                                                                <label htmlFor="pos_color"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Precio</label>
                                                                <input type="number" v-model="pro_precio" id="pos_color"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    required />
                                                            </div>
                                                        </div>
                                                        <div className="flex gap-6">

                                                            <div className="w-full">
                                                                <label htmlFor="pos_color"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Peso
                                                                    (gr)</label>
                                                                <input type="number" v-model="pro_peso" id="pos_color"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    required />
                                                            </div>
                                                            <div className="w-full">
                                                                <label htmlFor="pos_color"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cantidad</label>
                                                                <input type="number" v-model="pro_stock" id="pos_color"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                                                        <button type="submit"
                                                            className="mt-3 w-1/3 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-emerald-400 hover:bg-indigo-700">
                                                            Guardar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div className="bg-gray-50 px-4 py-3 sm:px-6">

                                    </div>
                                </div>
                            </DialogPanel>


                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<style>
#titulos {
    grid-template-columns: repeat(8, minmax(0, 1fr));
}

@media(max-width: 1024px) {
    #titulos {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .megusta,
    .comentarios,
    .compartir {
        display: none;
        width: 0;
    }

    .emoji {
        display: none;
    }

    .namepublic {
        font-size: 12px;
    }

    .datepublic {
        font-size: 12px;
    }

    .despublic {
        font-size: 14px;
    }

    .titlepublic {
        font-size: 14px;
    }
}

@media(min-width: 1024px) {
    .img-public {
        width: 734px;
    }

    .contentxpublic {
        width: 768px;
    }
}

@media(max-width: 700px) {
    #titulos {
        overflow: auto;
        display: flex;
        flex-wrap: nowrap;
        grid: none !important;
    }
}

.btn-flotante {
    font-size: 16px;
    /* Cambiar el tamaño de la tipografia */
    text-transform: uppercase;
    /* Texto en mayusculas */
    font-weight: bold;
    /* Fuente en negrita o bold */
    color: #ffffff;
    /* Color del texto */
    letter-spacing: 2px;
    /* Espacio entre letras */
    padding: 18px 30px;
    /* Relleno del boton */
    position: fixed;
    bottom: 40px;
    right: 40px;
    transition: all 300ms ease 0ms;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    z-index: 99;
}

.btn-flotante:hover {
    background-color: #2c2fa5;
    /* Color de fondo al pasar el cursor */
    box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
    transform: translateY(-7px);
}

@media only screen and (max-width: 600px) {
    .btn-flotante {
        font-size: 14px;
        padding: 12px 20px;
        bottom: 20px;
        right: 20px;
    }

    .cardpost {
        padding: .5rem;
    }
}

body {
    overflow: hidden;
}

#contenidoinicio {
    margin-bottom: 50em;
}

.container-snap::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.container-snap {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}

.inicio {
    overflow: auto;
    height: 100vh;
}

#image-container {
    overflow: auto;
    height: 200px;
    width: auto;
}

.file {
    height: 50%;
    width: 100%;
}

@media only screen and (max-width: 1024px) {
    .herramientas {
        overflow: auto;
        height: 200px;
    }
}

@media only screen and (max-width: 294px) {
    .cardpost {
        width: 90%;
        margin: 6px;
    }

    .emoji {
        display: none;
    }

    .chat {
        margin: 0;
    }

    .megusta,
    .comentarios,
    .compartir {
        display: none;
        width: 0;
    }
}

/* custom scrollbar */
::-webkit-scrollbar {
    width: 20px;
}

::-webkit-scrollbar-track {
    background-color: transparent;
}

::-webkit-scrollbar-thumb {
    background-color: #d6dee1;
    border-radius: 20px;
    border: 6px solid transparent;
    background-clip: content-box;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #a8bbbf;
}
</style>
