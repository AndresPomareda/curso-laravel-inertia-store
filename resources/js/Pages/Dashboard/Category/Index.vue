<template>
<!--
    <o-modal v-model:active="confirmDeleteActive">
        <p class="p-4">¿Seguro que desea eliminar el registro?</p>

        <div class="flex flex-row-reverse gap-2 bg-gray-100 p-3">
            <o-button variant="danger" @click="deleteCategory">Delete</o-button>
            <o-button @click="confirmDeleteActive = false">Cancel</o-button>
        </div>
    </o-modal>
-->
    <app-layout>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <Link class="link-button-default my-2" :href="route('category.create')">Create</Link>
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <th class="p-3">Id</th>
                            <th class="p-3">Title</th>
                            <th class="p-3">Slug</th>
                            <th class="p-3">Actions</th>
                        </thead>
                        <tbody>
                            <tr v-for="c in categories.data" :key="c.id">
                                <td class="p-2">{{ c.id }}</td>
                                <td class="p-2">{{ c.title }}</td>
                                <td class="p-2">{{ c.slug }}</td>
                                <td class="p-2">
                                    <Link class="text-sm text-purple-400 hover:text-purple-700"
                                        :href="route('category.edit', c.id)">Edit</Link>
                                    <Link method="DELETE" as="button" class="text-sm text-red-400 hover:text-red-700 ml-3"
                                        :href="route('category.destroy', c.id)">Borrar</Link>
<!--
                                    <o-button iconLeft="delete" rounded size="small" variant="danger"
                                        @click="confirmDeleteActive = true; deleteCategoryRow = c.id; "> Delete </o-button> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <pagination class="my-4" :links="categories" />

                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import { Link, router } from "@inertiajs/vue3"
import AppLayout from "@/Layouts/AppLayout.vue"

import Pagination from '@/Shared/Pagination.vue'
//import Pagination from "@/Components/Pagination.vue"

export default {
    data() {
        return {
            confirmDeleteActive: false,
            deleteCategoryRow: "",
        };
    },
    methods: {
        deleteCategory() {
            router.delete(route("category.destroy", this.deleteCategoryRow));
            this.confirmDeleteActive = false;
        },
    },
    components: {
        AppLayout,
        Link,
        Pagination
    },
    props: {
        categories: Object
    }
}
</script>
