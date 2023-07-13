<template>
    <contact-layout>
        <template #header>
            <div><h5>Contact - General</h5></div>
        </template>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                        <div class="col-span-6">
                            <jet-label>Subject</jet-label>
                            <jet-input class="w-full" type="text" v-model="form.subject" />
                            <jet-input-error :message="errors.subject" />
                        </div>

                        <div class="col-span-6">
                            <jet-label value="Message" />
                            <textarea class="rounded-md w-full border-gray-300" v-model="form.message"></textarea>
                            <jet-input-error :message="errors.message" />
                        </div>

                        <div class="col-span-6">
                            <jet-label value="Type" />
                            <select class="rounded-md w-full border-gray-300" v-model="form.type">
                                <option value="company">Company</option>
                                <option value="person">Person</option>
                            <!--<option value="advert">Advert</option>
                                <option value="post">Post</option>
                                <option value="course">Course</option>
                                <option value="movie">Movie</option>-->
                            </select>
                            <jet-input-error :message="errors.type" />
                        </div>

                        <jet-button class="mt-5" type="submit">Enviar</jet-button>
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
        contactGeneral: {
            type: Object,
            default: {
                id: "",
                subject: "",
                message: "",
                type: "",
            },
        }
    },
    setup(props) {
        const form = useForm({
            id: props.contactGeneral.id,
            subject: props.contactGeneral.subject,
            message: props.contactGeneral.message,
            type: props.contactGeneral.type,
        });
        function submit() {
            if (form.id == "") router.post(route("contact-general.store"), form);
            else
                router.post(route("contact-general.update", form.id), {
                    _method: "put",
                    subject: form.subject,
                    type: form.type,
                    message: form.message,
                    //contact_general_id: props.contactGeneralId,
                });
        }
        return { form, submit };
    },
};
</script>
