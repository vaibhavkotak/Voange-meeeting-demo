<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";

const errorsMessage = ref("");
const successMessage = ref("");

const form = ref({
    meeting_name: "",
});

// errors messages
const errors = ref({});
;
// Handle form submission
const HandleSubmit = async () => {
    // Reset previous messages
    successMessage.value = "";
    errorsMessage.value = "";
    errors.value = {};

    try {
        const response = await axios.post("/store-meeting", form.value);
        successMessage.value = response.data.message;

        // Reset form after successful submission
        form.value = {
            meeting_name: "",
        };
    } catch (error) {
        if (error.response && error.response.status === 422) {
            // Backend validation errors
            errors.value = error.response.data.errors;
        } else {
            // General errors
            errorsMessage.value = "An error occurred while adding the meeting.";
        }
    }
};
</script>
<template>
    <Head title="Create new meeting" />

    <AuthenticatedLayout>
        <div class="container mx-auto">
            <div class="row justify-content-center">
                <div class="col-md-12 meeting_list_btn mt-4 px-4">
                    <div class="text-center mt-5 mb-3">
                        <h2 class="text-[#262626] mt-12 mb-4 text-2xl">
                            <strong>Create new room</strong>
                        </h2>
                    </div>
                    <!-- Show error message -->
                    <div
                        v-if="successMessage"
                        id="alert-2"
                        class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert"
                    >
                        <svg
                            class="flex-shrink-0 w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                            />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ms-3 text-sm font-medium">
                            {{ successMessage }}
                        </div>
                        <button
                            type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                            @click="successMessage = ''"
                            aria-label="Close"
                        >
                            <span class="sr-only">Close</span>
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                        </button>
                    </div>
                    <div
                        v-if="errorMessage"
                        id="alert-3"
                        class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                        role="alert"
                    >
                        <svg
                            class="flex-shrink-0 w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                            />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ms-3 text-sm font-medium">
                            {{ errorMessage }}
                        </div>
                        <button
                            type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                            @click="errorMessage = ''"
                            aria-label="Close"
                        >
                            <span class="sr-only">Close</span>
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                        </button>
                    </div>
                    <div
                        class="card relative flex flex-col min-w-0 break-words bg-white bg-clip-border border border-opacity-10 rounded"
                    >
                        <div
                            class="card-header rounded-tl-[calc(.25rem-1px)] rounded-tr-[calc(.25rem-1px)] rounded-bl-none rounded-br-none p-2 px-4 mb-0 bg-[rgba(0,0,0,.03)] border-b border-b-opacity-10"
                        >
                            Add Contact
                        </div>
                        <div class="card-body flex-1 p-4">                            
                            <form @submit.prevent="HandleSubmit">
                                <div class="form-group">
                                    <label for="first-name">Room name</label>
                                    <input
                                        type="text"
                                        id="first-name"
                                        v-model="form.meeting_name"
                                        class="form-control custom-input-design mb-2 w-full"
                                        :class="{
                                            'is-invalid': errors.meeting_name,
                                            'border-red-500': errors.meeting_name,
                                            'border-gray-300':
                                                !errors.meeting_name,
                                        }"
                                    />
                                    <div
                                        class="error-message text-red-500"
                                        v-if="errors.meeting_name"
                                    >
                                        {{ errors.meeting_name[0] }}
                                    </div>
                                </div>                                

                                <button
                                    type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300px-6 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300"
                                >
                                    Create room
                                </button>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
