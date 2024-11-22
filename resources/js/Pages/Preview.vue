<template>
    <Head title="Room" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Room
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative"
                >
                    <div class="p-6 text-gray-900">
                        <p>Preview your audio video</p>
                    </div>

                    <div id="previewContainer" class="bg-gray-200"></div>

                    <div
                        class="bg-gray-100 rounded-lg overflow-hidden shadow-md flex items-center justify-center preview-control-btn"
                    >
                        <i
                            :class="iconClass"
                            @click="toggleIcon"
                            :style="iconStyle"
                        ></i>
                        <i
                            :class="videoIconClass"
                            @click="toggleVideo"
                            :style="videoIconStyle"
                        ></i>
                    </div>
                    <!-- Background Change Controls -->
                    <!-- Video Filter Controls -->
                    <div class="filter-controls flex gap-4">
                        <button
                            class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition"
                            @click="applyVideoFilter('none')"
                        >
                            No Filter
                        </button>
                        <button
                            class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition"
                            @click="
                                applyVideoFilter('backgroundBlur', {
                                    blurStrength: 'high',
                                })
                            "
                        >
                            Background Blur (High)
                        </button>
                        <button
                            class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition"
                            @click="
                                applyVideoFilter('backgroundBlur', {
                                    blurStrength: 'low',
                                })
                            "
                        >
                            Background Blur (Low)
                        </button>
                        <button
                            class="w-[80px]"
                            @click="
                                applyVideoFilter('backgroundReplacement', {
                                    backgroundImgUrl: `${appUrl}/images/f9c7bed4fd49d2c199b09c3bf60e2ce6.jpg`,
                                })
                            "
                        >
                            <img
                                :src="`${appUrl}/images/f9c7bed4fd49d2c199b09c3bf60e2ce6.jpg`"
                            />
                        </button>
                        <button
                            class="w-[80px]"
                            @click="
                                applyVideoFilter('backgroundReplacement', {
                                    backgroundImgUrl: `${appUrl}/images/free-video-1580455.jpg`,
                                })
                            "
                        >
                            <img
                                :src="`${appUrl}/images/free-video-1580455.jpg`"
                            />
                        </button>
                        <button
                            class="w-[80px]"
                            @click="
                                applyVideoFilter('backgroundReplacement', {
                                    backgroundImgUrl: `${appUrl}/images/abstract-background-gradient-blue-purple-red.jpg`,
                                })
                            "
                        >
                            <img
                                :src="`${appUrl}/images/abstract-background-gradient-blue-purple-red.jpg`"
                            />
                        </button>
                    </div>

                    <div class="flext w-full max-w-fit justify-center items-center mx-auto">
                        <Link
                            :href="route('room', props.room.id)"
                            class="block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded cursor-pointer"
                        >
                            Join
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { Room, PreviewPublisher } from "@vonage/video-express";

const appUrl = ref(import.meta.env.VITE_APP_URL);
// Define props
const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    apikey: String,
    session_id: String,
    token: String,
    room: Array,
});
const backgroundStyle = ref({ backgroundColor: "transparent" });
// Reactive state
let previewPublisher = null;

const isMicrophoneOn = ref(true);
const isVideoOn = ref(true);

// Function to toggle between the two icons
const toggleIcon = async () => {
    if (!previewPublisher) {
        console.error("PreviewPublisher is not initialized yet.");
        return;
    }
    // Toggle microphone state
    isMicrophoneOn.value = !isMicrophoneOn.value;
    try {
        if (isMicrophoneOn.value) {
            // Enable microphone
            await previewPublisher.enableAudio(true);
            console.log("Microphone enabled");
        } else {
            // Disable microphone
            await previewPublisher.disableAudio(false);
            console.log("Microphone disabled");
        }
    } catch (error) {
        console.error("Error toggling microphone:", error);
    }
};

// Function to toggle the video
const toggleVideo = async () => {
    if (!previewPublisher) {
        console.error("PreviewPublisher is not initialized yet.");
        return;
    }

    // Toggle video state
    isVideoOn.value = !isVideoOn.value;

    try {
        if (isVideoOn.value) {
            // Enable video
            await previewPublisher.enableVideo(true);
            console.log("Video enabled");
        } else {
            // Disable video
            await previewPublisher.disableVideo(false);
            console.log("Video disabled");
        }
    } catch (error) {
        console.error("Error toggling video:", error);
    }
};

const applyVideoFilter = async (filterType, options = {}) => {
    if (!previewPublisher) {
        console.error("PreviewPublisher is not initialized.");
        return;
    }

    try {
        switch (filterType) {
            case "none":
                await previewPublisher.clearVideoFilter();
                console.log("No filter applied");
                break;
            case "backgroundBlur":
                await previewPublisher.setVideoFilter({
                    type: "backgroundBlur",
                    blurStrength: options.blurStrength || "low", // Default to "low"
                });
                console.log(
                    `Background blur applied with ${
                        options.blurStrength || "low"
                    } strength`
                );
                break;
            case "backgroundReplacement":
                await previewPublisher.setVideoFilter({
                    type: "backgroundReplacement",
                    backgroundImgUrl: options.backgroundImgUrl,
                });
                console.log("Background replacement applied");
                break;
            default:
            // console.error("Unsupported filter type");
        }
    } catch (error) {
        console.error("Error applying video filter:", error);
    }
};

// Compute the class based on the state
const iconClass = computed(() => {
    return isMicrophoneOn.value
        ? "fas fa-microphone"
        : "fas fa-microphone-slash";
});

// Compute the class for the video icon based on its state
const videoIconClass = computed(() => {
    return isVideoOn.value ? "fas fa-video" : "fas fa-video-slash";
});

// Compute the style based on the state
const iconStyle = computed(() => {
    return isMicrophoneOn.value ? {} : { backgroundColor: "red" };
});

// Compute the style for the video icon based on its state
const videoIconStyle = computed(() => {
    return isVideoOn.value ? {} : { backgroundColor: "red" };
});
// Lifecycle hook for initialization
onMounted(async () => {
    // // Initialize PreviewPublisher
    previewPublisher = new PreviewPublisher("previewContainer");
    console.log(previewPublisher);
    try {
        await previewPublisher.previewMedia({
            targetElement: "previewContainer",
            publisherProperties: {
                resolution: "1280x720",
            },
        });
        applyVideoFilter();
    } catch (error) {
        console.error("Failed to initialize preview publisher:", error);
    }
});
</script>
<style>
/* Optional: Customize the icon size */
i {
    font-size: 24px;
    cursor: pointer;
    padding: 10px; /* Add some padding to make the icon clickable */
}
div#previewContainer {
    padding: 20px 0;
}
div#previewContainer .OT_mirrored {
    width: 100% !important;
    height: auto !important;
    max-width: 600px;
    height: 400px !important;
    margin: 0 auto;
    border: 1px solid #000;
    border-radius: 11px;
}
.preview-control-btn {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 180px;
    z-index: 999;
    gap: 30px;
    width: 100%;
    max-width: fit-content;
    background: transparent;
    box-shadow: none;
}
.preview-control-btn i {
    width: 50px;
    height: 50px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}
.filter-controls {
    padding: 30px;
    justify-content: center;
}
</style>
