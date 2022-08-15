<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import PostCard from "@/Components/PostCard.vue";
import FlashSuccessMessages from "@/Components/FlashSuccessMessages.vue";

defineProps({
    posts: Array,
});
</script>

<template>
    <!-- ログアウトの通知 -->
    <FlashSuccessMessages />

    <!-- PCのみ2カラム構成のレイアウトにする -->
    <main class="lg:flex">

        <!-- サイト紹介セクション -->
        <section class="lg:flex lg:flex-col lg:w-full lg:sticky lg:h-screen lg:top-0">

            <!-- ヘッダー -->
            <header class="lg:flex-none">
                <Link href="/"><img class="hover:opacity-50 w-8 my-4 ml-4 sm:w-9 sm:my-5 sm:ml-5 lg:w-10 lg:my-6 lg:ml-6" src="/images/logo.svg"></Link>
            </header>

            <div class="lg:flex-1">

                <!-- サイトタイトル -->
                <h1 class="text-center font-bold text-6xl mt-10 lg:text-7xl lg:mt-20 lg:leading-tight">
                    あにまる<br />にゃ〜ん
                </h1>

                <!-- サイトの説明 -->
                <p class="mt-8 text-center font-bold text-xl lg:text-2xl">
                    人間社会に疲れた人が作った<br />
                    動物の言葉でしか呟けないSNS<br />
                    (ベータ版)
                </p>

                <!-- ログインボタン -->
                <div class="text-center mt-12">
                    <a href="/login/twitter">
                        <button class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-3 px-9 rounded-full text-xl lg:py-4 lg:px-12 lg:text-2xl">
                            Twitterでログイン
                        </button>
                    </a>
                </div>
            </div>

            <!-- PC用フッター -->
            <footer class="hidden my-10 lg:block lg:flex-none">
                <ul class="px-20 flex justify-around">
                    <Link href="/terms"><li>利用規約</li></Link>
                    <Link href="/privacy"><li>プライバシーポリシー</li></Link>
                    <a href="https://twitter.com/plus_marumaru" target="_blank"><li>&copy; 2022 coffee-r</li></a>
                </ul>
            </footer>

        </section>

        <!-- 投稿タイムライン -->
        <article class="bg-blue-100 bg-opacity-20 mt-10 py-3 lg:w-full lg:mt-0">

            <PostCard
                v-for="post in posts"
                v-bind:key="post.post_id"
                v-bind:post_id="post.post_id"
                v-bind:user_id="post.user_id"
                v-bind:user_name="post.user_name"
                v-bind:message="post.message"
                v-bind:like_total_count="post.like_total_count"
                v-bind:avatar_image_url="post.avatar_image_url"
                v-bind:post_created_at="post.post_created_at"
            ></PostCard>
            
        </article>
        
    </main>

    <!-- SP用フッター -->
    <footer class="lg:hidden">
       <ul class="py-4 flex flex-col gap-y-4">
            <Link href="/terms"><li class="grid justify-items-center hover:opacity-50">利用規約</li></Link>
            <Link href="/privacy"><li class="grid justify-items-center hover:opacity-50">プライバシーポリシー</li></Link>
            <a href="https://twitter.com/plus_marumaru" target="_blank"><li class="grid justify-items-center hover:opacity-50">&copy; 2022 coffee-r</li></a>
        </ul>
    </footer>

</template>
