<script setup>
import { ref, reactive, onBeforeUnmount } from 'vue';
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

const isOpenDropDownMenu = ref(false);
const like_total_count_reactive = ref(props.like_total_count);

const postCreatedAt = function(){
    const nowDate = new Date();
    const postDate = new Date(props.post_created_at);
    const diffSeconds = (nowDate - postDate) / 1000;

    // 投稿時刻が現在時刻の60秒前は秒表示
    if(diffSeconds < 60){
        return parseInt(diffSeconds) + '秒';
    }

    // 投稿時刻が現在時刻の60分前は分表示
    if(diffSeconds < 3600){
        return parseInt(diffSeconds / 60) + '分';
    }

    // 投稿時刻が現在時刻の24時間前は時間表示
    if(diffSeconds < 86400){
        return parseInt(diffSeconds / 3600) + '時間';
    }

    // 投稿時刻が現在時刻の365日前は月日表示 (※うるう年は考慮しない)
    if(diffSeconds < 31536000){
        return (postDate.getMonth() +1 ) + '月' + postDate.getDate() + '日';
    }

    // それら以外は年月日表示
    return postDate.getFullYear() + '年' + (postDate.getMonth() + 1) + '月' + postDate.getDate() + '日';
}

const openDropDownMenu = function(){
    isOpenDropDownMenu.value = true;
    document.addEventListener('click', closeDropDownMenu);
}

const closeDropDownMenu = function(event){
    if(event.target.closest('.post-card-drop-down') != null){
        return;
    }
    isOpenDropDownMenu.value = false;
    document.removeEventListener('click', closeDropDownMenu);
}

const submitDeletePost = function(){
    Inertia.delete('/post/' + props.post_id);
}

const addLikeCount = function(){
    const response = axios.post("/api/likes/" + props.post_id);
    like_total_count_reactive.value += 1;
}

</script>

<template>

    <div class="flex m-6 p-2 max-w-full bg-white rounded-lg border border-gray-200 shadow-md">

        <img class="w-12 h-12 rounded-full border-4 border-slate-50 object-cover" :src=avatar_image_url />
        
        <div class="flex flex-col px-1">
            <div>
                <span class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">{{ user_name }}</span>
            </div>
            <p class="text-sm text-gray-700">{{ message }}</p>
            <div class="flex justify-between">
                <div>
                    <img @click="addLikeCount" class="inline w-4 h-4" src="/images/like_icon.svg" />
                    <span class="text-sm">{{ like_total_count_reactive }} いいね</span>
                </div>
                <p class="leading-6 text-sm text-gray-400"></p>
                <p class="leading-6 text-sm text-gray-400">{{ postCreatedAt() }}</p>
            </div>
        </div>
        

        <img @click="openDropDownMenu()" class="post-card-drop-down ml-auto w-4 h-4" src="/images/three_point_leader_menu_icon.svg" />
        <div class="post-card-drop-down relative">
            <div class="absolute z-10 top-4 right-0 w-44 bg-white rounded shadow dark:bg-gray-700" v-show="isOpenDropDownMenu">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                    <li>
                        <form @submit.prevent="submitDeletePost">
                            <button type="submit" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">削除</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
