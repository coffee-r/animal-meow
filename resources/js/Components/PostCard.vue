<script setup>

defineProps({
    name: {
        type: String,
        default: '投稿者名'
    },
    message: {
        type: String,
        default: '投稿メッセージ'
    },
    like_total_count: {
        type: Number,
        default: 0,
    },
    avatar_image_url: {
        type: String,
        default: 'http://abs.twimg.com/sticky/default_profile_images/default_profile.png'
    },
    created_at: {
        type: String,
        default: '23時間前'
    },
});

</script>

<template>
    <div class="flex m-6 p-2 max-w-full bg-white rounded-lg border border-gray-200 shadow-md">
        <img class="w-12 h-12 rounded-full border-4 border-slate-50 object-cover" :src=avatar_image_url />
        <div class="flex flex-col px-1">
            <div>
                <span class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">{{ name }}</span>
            </div>
            <p class="text-sm text-gray-700">{{ message }}</p>
            <div class="flex justify-between">
                <div>
                    <img class="inline w-4 h-4" src="/images/like_icon.svg" />
                    <span class="text-sm">{{ like_total_count }} いいね</span>
                </div>
                <p class="leading-6 text-sm text-gray-400"></p>
                <p class="leading-6 text-sm text-gray-400">{{ created_at }}</p>
            </div>
        </div>
    </div>
</template>
