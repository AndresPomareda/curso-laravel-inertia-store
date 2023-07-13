<template>
    <contact-layout>
        <template #header>
            <div><h5>Contact - Person</h5></div>
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
                        <jet-label>Surname</jet-label>
                        <jet-input class="w-full" type="text" v-model="form.surname" />
                        <jet-input-error :message="errors.surname" />
                    </div>

                    <div class="col-span-6">
                        <jet-label value="Other" />
                        <textarea class="rounded-md w-full border-gray-300" v-model="form.other"></textarea>
                        <jet-input-error :message="errors.other" />
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

                    <jet-button class="mt-5" type="submit">Enviar</jet-button>
                    <span class="mt-5 ml-3 cursor-pointer" @click="$emit('backStepEvent', 1)">Back</span>
                </form>
            </div>
        </div>
    </contact-layout>
</template>

<script>
import { useForm, router } from "@inertiajs/vue3"

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
        contactPerson: {
            type: Object,
            default: {
                id: "",
                name: "",
                surname: "",
                other: "",
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
            id: props.contactPerson.id,
            name: props.contactPerson.name,
            surname: props.contactPerson.surname,
            other: props.contactPerson.other,
            choices: props.contactPerson.choices,
            contact_general_id: props.contactGeneralId,

        });
        function submit() {
            if (form.id == "") router.post(route("contact-person.store"), form);
            else
                router.post(route("contact-person.update", form.id), {
                    _method: "put",
                    name: form.name,
                    surname: form.surname,
                    other: form.other,
                    choices: form.choices,
                    contact_general_id: props.contactGeneralId,
                });
        }
        return { form, submit };
    },
};
</script>
