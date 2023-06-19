<template>
    <app-layout>
        <jet-form-section @submitted="submit" class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <template #title> Crear-Editar un Post </template>
            <template #description> Crear-Editar un Post (Save)</template>
            <template #form>
                <div class="col-span-6">
                    <jet-label>Title</jet-label>
                    <jet-input class="w-full" type="text" v-model="form.title" />
                    <jet-input-error :message="errors.title" />
                </div>

                <div class="col-span-6">
                    <jet-label value="Slug" />
                    <jet-input class="w-full" type="text" v-model="form.slug" />
                    <jet-input-error :message="errors.slug" />
                </div>

                <div class="col-span-6">
                    <jet-label value="Date" />
                    <jet-input class="w-full" type="date" v-model="form.date" />
                    <jet-input-error :message="errors.date" />
                </div>
                <div class="col-span-6">
                    <jet-label value="Text" />
                    <!-- <textarea class="rounded-md w-full border-gray-300" v-model="form.text"></textarea> -->
                    <!-- <textarea
                            class="rounded-md w-full border-gray-300"
                            v-model="form.text"></textarea> -->

                    <ckeditor :editor="editor.editor" v-model="form.text"></ckeditor>

                    <jet-input-error :message="errors.text" />
                </div>
                <div class="col-span-6">
                    <jet-label value="Description" />
                    <textarea class="rounded-md w-full border-gray-300" v-model="form.description"></textarea>
                    <jet-input-error :message="errors.description" />
                </div>
                <div class="col-span-6">
                    <jet-label value="Posted" />

                    <select class="rounded-md w-full border-gray-300" v-model="form.posted">
                        <option value="not">No</option>
                        <option value="yes">Yes</option>
                    </select>

                    <jet-input-error :message="errors.posted" />
                </div>
                <div class="col-span-6">
                    <jet-label value="Type" />

                    <select class="rounded-md w-full border-gray-300" v-model="form.type">
                        <option value="advert">Advert</option>
                        <option value="post">Post</option>
                        <option value="course">Course</option>
                        <option value="movie">Movie</option>
                    </select>

                    <jet-input-error :message="errors.type" />
                </div>
                <div class="col-span-6">
                    <jet-label value="Category" />
                    <select class="rounded-md w-full border-gray-300" v-model="form.category_id">
                        <option value=""></option>
                        <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.title }}</option>
                    </select>
                    <jet-input-error :message="errors.category_id" />
                </div>
            </template>
            <template #actions>
                <jet-button type="submit">Grabar</jet-button>
            </template>
        </jet-form-section>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="col-span-6">
                            <div>
                                <jet-label value="Image" />
                                <jet-input class="w-full" type="file" @input="form.image = $event.target.files[0]" />
                                <jet-input-error :message="errors.image" />
                            </div>
                        </div>

                        <div class="col-span-6">
                            <jet-label value="Image" />
                            <o-upload v-model="form.image">
                                <o-button tag="a" variant="primary">
                                    <o-icon icon="upload"></o-icon>
                                    <span>Click to upload</span>
                                </o-button>
                            </o-upload>
                            <jet-input-error :message="errors.image" />
                        </div>

                        <div class="col-span-6" v-if="post.id">
                            <o-upload v-model="dropFiles"  multiple drag-drop>
                                <section class="ex-center">
                                    <p>
                                        <o-icon icon="upload" size="is-large"> </o-icon>
                                    </p>
                                    <p>Drop your files here or click to upload</p>
                                </section>
                            </o-upload>
                        </div>

                        <div>
                            <jet-button class="mt-3" @click="upload">Send</jet-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mostramos la imagen -->
        <div class="container mt-4" v-if="post.image">
            <div class="card">
                <div class="card-body">
                    <img class="max-w-xs rounded-md shadow-sm" :src="'/image/post/' + post.image" alt="">
                    <jet-danger-button class="mt-4" @click="form.delete(route('post.image-delete',form.id))">Delete</jet-danger-button>
                    <a :href="'/image/post/' + post.image" download="" class="ml-2 mt-4 link-button-default">Download</a>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { useForm, router } from "@inertiajs/vue3";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic"
import AppLayout from "@/Layouts/AppLayout.vue";
import JetFormSection from "@/Components/FormSection.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetInputError from "@/Components/InputError.vue";
import JetInput from "@/Components/TextInput.vue";
import JetButton from "@/Components/PrimaryButton.vue";
import JetDangerButton from "@/Components/DangerButton.vue";
import { objectToString } from "@vue/shared";

export default {
    components: {
        AppLayout,
        JetInput,
        JetInputError,
        JetLabel,
        JetButton,
        JetFormSection,
        JetDangerButton,
        ClassicEditor
    },
    data() {
        return {
            editor: {
                editor: ClassicEditor
            }
        }
    },
    props: {
        errors: Object,
        post: {
            type: Object,
            default: {
                id: "",
                title: "",
                slug: "",
                date: "",
                description: "",
                text: "",
                type: "",
                posted: "",
                category_id: "",
            },
        },
        categories: Object,
        dropFiles: [],
    },

    setup(props) {
        const form = useForm({
            id: props.post.id,
            title: props.post.title,
            slug: props.post.slug,
            date: props.post.date,
            description: props.post.description,
            text: props.post.text,
            type: props.post.type,
            posted: props.post.posted,
            category_id: props.post.category_id,
            image: "",
        });

        function submit() {
            if (form.id != "") router.put(route("post.update", form.id), {});
            else router.post(route("post.store"), form);
        }
        return { form, submit };
    },
    watch: {
        dropFiles: {
            handler(val) {
            inertia.post(route("post.upload", this.$page.props.post.id), {
                "image":val[val.length -1]
            });
            }
        }
    },
};
</script>
