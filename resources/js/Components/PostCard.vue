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

onBeforeUnmount(() => {
    document.removeEventListener('click', closeDropDownMenu);
})

const like_total_count_reactive = ref(props.like_total_count);


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
                <p class="leading-6 text-sm text-gray-400">{{ post_created_at }}</p>
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

        <div class="ml-auto">
            
            <div class="fixed">
                
            </div>
        </div>

         

        
       
    </div>
</template>
