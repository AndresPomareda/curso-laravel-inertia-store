<template>
    <app-layout>
        <jet-form-section @submitted="submit" class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <template #title> Create Category </template>
            <template #description> Create a Category </template>
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
            </template>
            <template #actions>
                <jet-button type="submit">Send</jet-button>
            </template>
        </jet-form-section>
    </app-layout>
</template>

<script>
import { useForm, router } from "@inertiajs/vue3"

import AppLayout from "@/Layouts/AppLayout.vue";
import JetFormSection from "@/Components/FormSection.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetInputError from "@/Components/InputError.vue";
import JetInput from "@/Components/TextInput.vue";
import JetButton from "@/Components/PrimaryButton.vue";

export default {
    props: {
        errors: Object,
        category: Object
    },
    components: {
        AppLayout,
        JetFormSection,
        JetLabel,
        JetInputError,
        JetInput,
        JetButton,
    },
    setup(props) {
        const form = useForm({
            id: props.category.id,
            title: props.category.title,
            slug: props.category.slug,
        });

        function submit() {
            router.put(route("category.update", form.id), form)
        }

        return { form, submit }

    }
}

</script>
