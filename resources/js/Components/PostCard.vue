<script setup>
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    post_id: {
        type: Number,
        default: 0
    },
    user_id: {
        type: Number,
        default: 0
    },
    user_name: {
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
    post_created_at: {
        type: String,
        default: '23時間前'
    },
});


const submitDeletePost = function(){
    Inertia.delete('/post/' + props.post_id);
}

</script>

<template>
{{ id }}
    <div class="flex m-6 p-2 max-w-full bg-white rounded-lg border border-gray-200 shadow-md">
        <img class="w-12 h-12 rounded-full border-4 border-slate-50 object-cover" :src=avatar_image_url />
        <div class="flex flex-col px-1">
            <div>
                <span class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">{{ user_name }}</span>
            </div>
            <p class="text-sm text-gray-700">{{ message }}</p>
            <div class="flex justify-between">
                <div>
                    <img class="inline w-4 h-4" src="/images/like_icon.svg" />
                    <span class="text-sm">{{ like_total_count }} いいね</span>
                </div>
                <p class="leading-6 text-sm text-gray-400"></p>
                <p class="leading-6 text-sm text-gray-400">{{ post_created_at }}</p>
            </div>
        </div>

         <div id="dropdown" class=" z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                <li>
                    <form @submit.prevent="submitDeletePost">
                        <button type="submit" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">削除</button>
                    </form>
                        
                </li>
            </ul>
        </div>

        <img class="w-4 h-4" src="/images/three_point_leader_menu_icon.svg" />
       
    </div>
</template>
