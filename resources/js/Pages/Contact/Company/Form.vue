<template>
    <contact-layout>
        <template #header>
            <div><h5>Contact - Company</h5></div>
        </template>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="col-span-6">
                        <jet-label>Name</jet-label>
                        <jet-input class="w-full" type="text" v-model="form.name" />
                        <jet-input-error :message="errors.name" />
                    </div>

                    <div class="col-span-6">
                        <jet-label>ID</jet-label>
                        <jet-input class="w-full" type="text" v-model="form.identification" />
                        <jet-input-error :message="errors.identification" />
                    </div>

                    <div class="col-span-6">
                        <jet-label>Email</jet-label>
                        <jet-input class="w-full" type="email" v-model="form.email" />
                        <jet-input-error :message="errors.email" />
                    </div>

                    <div class="col-span-6">
                        <jet-label value="Extra" />
                        <textarea class="rounded-md w-full border-gray-300" v-model="form.extra"></textarea>
                        <jet-input-error :message="errors.extra" />
                    </div>

                    <div class="col-span-6">
                        <jet-label value="Choice" />
                        <select class="rounded-md w-full border-gray-300" v-model="form.choices">
                            <option value="advert">Advert</option>
                            <option value="post">Post</option>
                            <option value="course">Course</option>
                            <option value="movie">Movie</option>
                        </select>
                        <jet-input-error :message="errors.choices" />
                    </div>

                    <div class="mt-3">
                        <jet-button type="submit">Enviar</jet-button>
                        <span class="mt-5 ml-3 cursor-pointer" @click="$emit('backStepEvent', 1)">Back</span>
                    </div>
                </form>
            </div>
        </div>
    </contact-layout>
</template>

<script>
import { useForm, router } from "@inertiajs/vue3";

import ContactLayout from "@/Layouts/ContactLayout.vue";
import JetInput from "@/Components/TextInput.vue";
import JetInputError from "@/Components/InputError.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetButton from "@/Components/PrimaryButton.vue";
import JetDangerButton from "@/Components/DangerButton.vue";
//import JetFormSection from "@/Components/FormSection.vue";
export default {
    emits: ['backStepEvent'],
    components: {
        ContactLayout,
        JetInput,
        JetInputError,
        JetLabel,
        JetButton,
        JetDangerButton,
        //JetFormSection,
    },
    props: {
        errors: Object,
        contactCompany: {
            type: Object,
            default: {
                id: "",
                name: "",
                identification: "",
                email: "",
                extra: "",
                choices: "",
            },
        },
        contactGeneralId: {
            type: Number,
            default: {
                id: 0
            },
        },
    },
    setup(props) {
        const form = useForm({
            id: props.contactCompany.id,
            name: props.contactCompany.name,
            identification: props.contactCompany.identification,
            email: props.contactCompany.email,
            extra: props.contactCompany.extra,
            choices: props.contactCompany.choices,
            contact_general_id: props.contactGeneralId,
        });
        function submit() {
            if (form.id == "") router.post(route("contact-company.store"), form);
            else
                router.post(route("contact-company.update", form.id), {
                    _method: "put",
                    name: form.name,
                    identification: form.identification,
                    email: form.email,
                    extra: form.extra,
                    choices: form.choices,
                    contact_general_id: props.contactGeneralId,
                });
        }
        return { form, submit };
    },
};
</script>
