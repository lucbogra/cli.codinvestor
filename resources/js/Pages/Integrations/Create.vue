<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, } from 'vue';
import { Link } from '@inertiajs/inertia-vue3'
import { CollectionIcon, ChevronLeftIcon } from '@heroicons/vue/solid';
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";

export default {
    components: {
        JetInput,
        AppLayout,
        CollectionIcon,
        ChevronLeftIcon
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                external_link: '',
                description: '',
                logo:''
            }),
        }
    },
    methods: {
        onFileChange(e) {
            this.form.logo = e.target.files[0];
        },
        store() {
            this.form.post(route('integrations.store'), {
                errorBag: 'store',
                preserveScroll: true,
                onSuccess: () => {

                },
            });
        }
    }
}

</script>
<template>
    <AppLayout title="Integrations">
        <template #page-header>
            <div class="max-w-8xl pt-6 mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="sm:hidden" aria-label="Back">
                    <a href="#" class="  flex items-center text-sm font-medium text-gray-400 hover:text-gray-200  ">
                        <ChevronLeftIcon class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-500" aria-hidden="true" />
                        Back
                    </a>

                </nav>
                <nav class="mt-2 mx-10" aria-label="Breadcrumb">
                    <ol role="list" class="flex justify-between mb-5">
                        <li>
                            <a href="#" class="text-2xl font-medium text-primary-800 flex hover:text-primary-600">
                                <CollectionIcon class="w-7 h-7 text-primary-800 mr-2" />
                                Integrations
                            </a>

                        </li>
                    </ol>
                </nav>
            </div>
        </template>

        <template #content>
            <div class="flex items-center justify-center p-12">
                <div class=" w-10/12 bg-white">
                    <Form @submit.prevent="store" class="py-6 px-9" action="https://formbold.com/s/FORM_ID" method="POST">
                        <div class="mb-5">
                            <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                                Name:
                            </label>
                            <JetInput v-model="form.name" type="text" class="w-full" />
                        </div>

                        <div class="mb-5">
                            <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                                External Link:
                            </label>
                            <JetInput v-model="form.external_link" type="text" class="w-full" />

                        </div>

                        <div class="mb-5">
                            <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                                Description:
                            </label>
                            <textarea row="5" v-model="form.description"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                        </div>

                        <div class="mb-6 pt-4">
                            <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                                Logo
                            </label>

                            <div class="mb-8">
                                <input type="file" v-on:change="onFileChange" name="file" id="file" class="sr-only" />
                                <label for="file"
                                    class="relative flex min-h-[200px] items-center justify-center rounded-md border border-dashed border-[#e0e0e0] p-12 text-center">
                                    <div>
                                        <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                                            Drop files here
                                        </span>
                                        <span class="mb-2 block text-base font-medium text-[#6B7280]">
                                            Or
                                        </span>
                                        <span
                                            class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]">
                                            Browse
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="hover:shadow-form w-full rounded-md bg-primary-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                                Add Integration
                            </button>
                        </div>
                    </Form>
                </div>
            </div>
        </template>

    </AppLayout>
</template>
