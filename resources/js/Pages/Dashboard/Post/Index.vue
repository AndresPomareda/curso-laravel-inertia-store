<template>
    <!--
    <o-modal v-model:active="confirmDeleteActive">
        <p class="p-4">Modal: Are you sure you want to delete the record?</p>
        <div class="flex flex-row-reverse gap-2 bg-gray-100 p-3">
            <o-button variant="danger" @click="deletePost">Delete</o-button>
            <o-button @click="confirmDeleteActive = false">Cancel</o-button>
        </div>
    </o-modal>
    -->
    <confirmation-modal :show="confirmDeleteActive">
        <template v-slot:title> Confirmation </template>

        <template v-slot:content>
            <p class="p-4">Confirmacion: Esta Ud. Seguro de Eliminar este Registro ?</p></template>

        <template v-slot:footer>
            <o-button variant="danger" @click="deletePost">Borrado</o-button>
            <div class="mr-3"></div>
            <o-button @click="confirmDeleteActive = false">Cancelar</o-button>
        </template>
    </confirmation-modal>

    <app-layout>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <Link class="link-button-default my-3" :href="route('post.create')">Create</Link>

                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <jet-label value="Date From" />
                        <jet-label value="Date To" />

                        <jet-input class="w-full" v-model="from" placeholder="Date From" type="date" />
                        <jet-input class="w-full" v-model="to" placeholder="Date To" type="date" />

                        <jet-input class="w-full" autofocus v-debounce.500ms="customSearch" :debounce-events="['keyup']"
                        v-model="search" placeholder="Search..." />

                        <select @change="customSearch" class="rounded-md w-full border-gray-300" v-model="posted">
                            <option :value="null">Posted</option>
                            <option value="not">No</option>
                            <option value="yes">Yes</option>
                        </select>

                        <select @change="customSearch" class="rounded-md w-full border-gray-300" v-model="type">
                            <option :value="null">Type</option>
                            <option value="advert">Advert</option>
                            <option value="post">Post</option>
                            <option value="course">Course</option>
                            <option value="movie">Movie</option>
                        </select>

                        <select @change="customSearch" class="rounded-md w-full border-gray-300" v-model="category_id">
                            <option :value="null">Category</option>
                            <option v-for="c in categories" :value="c.id" :key="c.id">
                                {{ c.title }}
                            </option>
                        </select>
                        <div>
                            <jet-button class="w-full" @click="customSearch"> Filter </jet-button></div>
                        <div>
                            <jet-button @click="cleanSearch"> Clean </jet-button></div>
                    </div>

                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr class="border-b">
                                <th class="p-3">Id</th>
                                <th class="p-3">Date</th>
                                <th class="p-3">Title</th>
                                <th class="p-3">Description</th>
                                <th class="p-3">Slug</th>
                                <th v-for="(c, k) in columns" class="p-3" :key="c">
                                    <button @click="sort(k)">
                                        {{ c }}
                                        <template v-if="k == sortColumn">
                                            <template v-if="'asc' == sortDirection">&uarr;</template>
                                            <template v-else>
                                                &darr;
                                            </template>
                                        </template>
                                    </button>
                                </th>

                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b" v-for="p in posts.data" :key="p.id">
                                <td class="p-2">{{ p.id }}</td>
                                <td class="p-2">{{ p.date }}</td>
                                <td class="p-2">{{ p.title.substring(0, 15) }}</td>
                                <td class="p-2"><textarea class="w-48">{{ p.description }}</textarea></td>
                                <td class="p-2">
                                    <Link class="text-sm text-purple-400 hover:text-purple-700 mr-4"
                                        :href="route('post.edit', p.id)">Editar</Link>
                                    <!-- <Link as="button" type="button" method="DELETE" class="text-sm text-red-400 hover:text-red-700 ml-2"
                                        :href="route('post.destroy', p.id)">Delete</Link> -->
                                    <o-button iconLeft="delete" rounded size="small" variant="danger"
                                        @click="
                                        confirmDeleteActive = true;
                                        deletePostRow = p.id;">
                                        Borrar
                                    </o-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination class="my-4" :links="posts" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { Link, router } from "@inertiajs/vue3";
import JetLabel from "@/Components/InputLabel.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import JetButton from "@/Components/PrimaryButton.vue";
import JetInput from "@/Components/TextInput.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";

import Pagination from "@/Shared/Pagination.vue";

export default {
    props: {
        posts: Object,
        categories: Object,
        columns: "",
        prop_type: String,
        prop_search: String,
        prop_posted: String,
        prop_category_id: String,
        prop_from: String,
        prop_to: String,
        prop_sortDirection: String,
        prop_sortColumn: String,
    },
    data() {
        return {
            sortColumn: this.prop_sortColumn,
            sortDirection: this.prop_sortDirection,
            column: "id",
            confirmDeleteActive: false,
            deletePostRow: "",
            type: this.prop_type,
            category_id: this.prop_category_id,
            posted: this.prop_posted,
            search: this.prop_search,
            from: this.prop_from,
            to: this.prop_to,
        };
    },
    methods: {
        deletePost() {
            router.delete(route("post.destroy", this.deletePostRow));
            this.confirmDeleteActive = false;
        },
        customSearch() {
            router.get(
                route("post.index", {
                    category_id: this.category_id,
                    type: this.type,
                    posted: this.posted,
                    search: this.search,
                    from: this.from,
                    to: this.to,
                    sortColumn: this.column,
                    sortDirection: this.sortDirection == 'asc' ? 'desc' : 'asc',
                })
            );
        },
        sort(column) {
            this.column = column;
            this.customSearch();
        },
        cleanSearch() {
            router.get(route("post.index"));
        },
    },
        components: {
        AppLayout,
        Link,
        Pagination,
        JetButton,
        JetInput,
        ConfirmationModal,
        Modal,
        JetLabel
    },
};
</script>
