<script setup>
import { ref, reactive, onBeforeUnmount } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

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

// ドロップダウンメニューを表示するかの変数
const isOpenDropDownMenu = ref(false);

// 投稿のいいね総数
const like_total_count_reactive = ref(props.like_total_count);

// 投稿時刻を加工する
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

// ログインユーザーと投稿ユーザーが同一か判定する
const isSamePostUserAuthUser = function(){
    const authUser = usePage().props.value.auth.user;
    if(authUser == null){
        return false;
    }
    if(authUser.id != props.user_id){
        return false;
    }
    return true;
}

// ドロップダウンメニューを表示する
// ドロップダウンメニューは、メニュー以外の項目がクリックされた際に閉じるようにする
const openDropDownMenu = function(){
    isOpenDropDownMenu.value = true;
    document.addEventListener('click', closeDropDownMenu);
}

// ドロップダウンメニューを閉じる
const closeDropDownMenu = function(event){
    if(event.target.closest('.post-card-drop-down') != null){
        return;
    }
    isOpenDropDownMenu.value = false;
    document.removeEventListener('click', closeDropDownMenu);
}

// 投稿削除
const submitDeletePost = function(){
    Inertia.delete('/post/' + props.post_id);
}

// いいねを追加する
const addLikeCount = function(){
    const response = axios.post("/api/likes/" + props.post_id);
    like_total_count_reactive.value += 1;
}

</script>

<template>

    <div class="flex bg-white rounded-xl border border-gray-200 shadow-md mx-2 my-1 p-2">

        <img class="w-12 h-12 rounded-full border-4 border-slate-50 object-cover" :src=avatar_image_url />
        
        <div class="flex flex-col px-1">
            <div>
                <span class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">{{ user_name }}</span>
            </div>
            <p class="text-sm text-gray-700">{{ message }}</p>
            <div class="flex justify-between">
                <div>
                    <img @click="addLikeCount" class="inline w-4 h-4" src="/images/like_icon.svg" />
                    <span class="text-sm">{{ like_total_count_reactive }}</span>
                </div>
                <p class="leading-6 text-sm text-gray-400"></p>
                <p class="leading-6 text-sm text-gray-400">{{ postCreatedAt() }}</p>
            </div>
        </div>
        
        <img v-if="isSamePostUserAuthUser()" @click="openDropDownMenu()" class="post-card-drop-down ml-auto w-4 h-4" src="/images/three_point_leader_menu_icon.svg" />
        <div v-if="isSamePostUserAuthUser()" class="post-card-drop-down relative">
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
