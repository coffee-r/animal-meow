<script setup>
    import { Link } from "@inertiajs/inertia-vue3";
    import PostCard from "@/Components/PostCard.vue";
    import LoginUserSpHeader from "@/Components/LoginUserSpHeader.vue";
    import FixedPostButton from "@/Components/FixedPostButton.vue";
    import LoginUserPcSideMenu from "@/Components/LoginUserPcSideMenu.vue";


    defineProps({
        posts: Array,
    });
</script>

<template>
    <!-- スマホ・タブレットのヘッダーメニュー -->
    <LoginUserSpHeader />

    <!-- スマホ・タブレットの投稿画面リンク -->
    <FixedPostButton />
   
    <main class="lg:flex">

        <!-- PCのサイドメニュー -->
        <LoginUserPcSideMenu />
        

        <!-- タイムライン -->
        <article class="bg-blue-100 bg-opacity-20 py-1 lg:w-full lg:mt-0">

            <!-- 投稿の通知 -->
            <div v-if="$page.props.flash.successMessages">
                <ul class="list-disc list-inside p-4 text-sm text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800" role="alert">
                    <li v-for="message in $page.props.flash.successMessages" :key="message" >
                        <span v-html="message" class="font-bold"></span> 
                    </li>
                </ul>
            </div>

            <PostCard
                v-for="post in posts"
                v-bind:key="post.id"
                v-bind:name="post.name"
                v-bind:message="post.message"
                v-bind:like_total_count="post.like_total_count"
                v-bind:avatar_image_url="post.avatar_image_url"
                v-bind:created_at="post.created_at"
            ></PostCard>
        </article>
    </main>
</template>
