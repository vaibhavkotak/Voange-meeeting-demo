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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>You're logged in!</p>
                    </div>

                    <div class="flex flex-col space-y-4">
                        <!-- Video container -->
                        <div
                            id="videoContainer"
                            class="bg-gray-100 rounded-lg overflow-hidden shadow-md h-[50vh] relative"
                        >
                            <p
                                class="absolute bottom-2 left-2 text-white bg-black bg-opacity-50 p-2 rounded"
                            >
                                Video will appear here
                            </p>
                        </div>

                        <div
                            class="bg-gray-100 rounded-lg overflow-hidden shadow-md h-[50vh] relative flex items-center justify-center"
                        >
                            <button
                                class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition"
                                @click="toggleScreenShare"
                            >
                                {{ buttonText }}
                            </button>
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

                        <!-- Screen Sharing Container -->
                        <div
                            id="screenContainer"
                            class="bg-gray-100 rounded-lg overflow-hidden shadow-md h-[50vh] relative"
                        >
                            <p
                                class="absolute bottom-2 left-2 text-white bg-black bg-opacity-50 p-2 rounded"
                            >
                                Screen sharing will appear here
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Room } from "@vonage/video-express";
import { onMounted, ref, computed } from "vue";
import { getActiveAudioOutputDevice } from "@vonage/video-express";

// Defining props using defineProps
const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    apikey: String,
    session_id: String,
    token: String,
});

const room = ref(null);
const buttonText = ref("Screen Share");
const isMicrophoneOn = ref(true);
const isVideoOn = ref(true);
const apiUrl = ref(import.meta.env.VITE_APP_URL);
// Function to toggle between the two icons
const toggleIcon = async () => {
    // Toggle microphone state
    isMicrophoneOn.value = !isMicrophoneOn.value;
    try {
        if (isMicrophoneOn.value) {
            // Enable microphone
            await room.value.camera.enableAudio(true);
            console.log("Microphone enabled");
        } else {
            // Disable microphone
            await room.value.camera.disableAudio(false);
            console.log("Microphone disabled");
        }
    } catch (error) {
        console.error("Error toggling microphone:", error);
    }
};
console.log(room);
// Function to toggle the video
const toggleVideo = async () => {
    // Toggle video state
    isVideoOn.value = !isVideoOn.value;

    try {
        if (isVideoOn.value) {
            // Enable video
            await room.value.camera.enableVideo(true);
            console.log("Video enabled");
        } else {
            // Disable video
            await room.value.camera.disableVideo(false);
            console.log("Video disabled");
        }
    } catch (error) {
        console.error("Error toggling video:", error);
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

// console.log(room);

// Vue's lifecycle hook equivalent in <script setup>
onMounted(async () => {
    const config = {
        apiKey: props.apikey,
        sessionId: props.session_id,
        token: props.token,
        roomContainer: "videoContainer",
        managedLayoutOptions: {
            layoutMode: "active-speaker",
            // cameraPublisherContainer: "cameraPublisherContainerDiv",
            // screenPublisherContainer: "screenPublisherContainerDiv",
        },
    };

    room.value = new Room(config);
    room.value.setLayoutMode("grid");

    try {
        await room.value.join();
        console.log("Connected to Vonage Video Express room successfully.");

        await room.value.camera.publish();

        const publisher = room.value.camera.initPublisher({
            publishCaptions: true, // Enable live captions
        });
        console.log(room.value.camera);
        // Publish the stream
        await room.value.camera.publish(publisher);

        room.value.on("captionReceived", (captionEvent) => {
            console.log("Caption received:", captionEvent.caption);
            displayCaption(captionEvent.caption);
        });
    } catch (error) {
        console.error("Error connecting to Vonage Video Express room:", error);
    }
    const disabledImageURI =
        "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrTFrhr_-pYR74jUgOy7IerAoHAX3zPIZZcg&s";

    room.value.camera.setDisabledImageURI(disabledImageURI);   

    room.value.on("captionReceived", (caption) => {
        console.log("Caption received:", caption);
        // Update your UI to display the caption
    });
});

const toggleScreenShare = async () => {
    if (!room.value) {
        console.error("Room is not initialized.");
        return;
    }

    try {
        if (buttonText.value === "Screen Share") {
            try {
                // Start screen sharing
                await room.value.startScreensharing("screenContainer");
                console.log("Started screen sharing");
                buttonText.value = "Stop Sharing"; // Update button text
            } catch (startError) {
                console.error("Error starting screen sharing:", startError);
                // Optionally, notify the user about the error
                alert("Failed to start screen sharing. Please try again.");
            }
        } else {
            try {
                // Stop screen sharing
                await room.value.stopScreensharing();
                console.log("Stopped screen sharing");
                buttonText.value = "Screen Share"; // Update button text
            } catch (stopError) {
                console.error("Error stopping screen sharing:", stopError);
                // Optionally, notify the user about the error
                alert("Failed to stop screen sharing. Please try again.");
            }
        }
    } catch (err) {
        // Handle any unexpected errors
        console.error("Unexpected error during screen sharing:", err);
        alert("An unexpected error occurred. Please try again.");
    }
};


</script>
<style scoped>
/* Optional: Customize the icon size */
i {
    font-size: 24px;
    cursor: pointer;
    padding: 10px; /* Add some padding to make the icon clickable */
}
</style>
