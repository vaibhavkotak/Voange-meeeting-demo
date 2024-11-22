<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

// Define props passed from the server
defineProps({
    meetings: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
                <div class="mt-6">
                    <Link
                        :href="route('createRoom')"
                        class="btn btn-primary bg-[#5c1994] text-white rounded-[5px] cursor-pointer inline-block min-w-[110px] text-center font-semibold leading-normal px-3 py-1.5 text-base"
                    >
                        Create room
                    </Link>
                </div>
                <!-- Display list of rooms -->
                <div class="mt-6 bg-white shadow-sm sm:rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4">Available Rooms</h3>
                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Room Name</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(meeting, index) in meetings"
                                :key="index"
                                class="odd:bg-white even:bg-gray-50"
                            >
                                <td class="border border-gray-300 px-4 py-2">{{ meeting.name }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <Link
                                        :href="route('previewRoom',meeting.id)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded"
                                    >
                                        Join
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
