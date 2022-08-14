<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import PostCard from "@/Components/PostCard.vue";

defineProps({
    posts: Array,
});
</script>

<template>
    <!-- ログアウトの通知 -->
    <div v-if="$page.props.flash.successMessages">
        <div v-for="message in $page.props.flash.successMessages" :key="message" class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-bold">{{ message }}</span> 
        </div>
    </div>

    <main class="lg:flex">
        <section class="lg:flex lg:flex-col lg:w-full lg:sticky lg:h-screen lg:top-0">
            <header class="lg:flex-none">
                <img class="mt-4 ml-4 w-7 lg:mt-6 lg:ml-6 lg:w-10" src="/images/logo.svg" />
            </header>

            <div class="lg:flex-1">
                <h1 class="text-center font-bold text-6xl mt-10 lg:text-7xl lg:mt-20 lg:leading-tight">
                    あにまる<br />にゃ〜ん
                </h1>
                <p class="mt-8 text-center font-bold text-xl lg:text-2xl">
                    人間社会に疲れた人が作った<br />
                    動物の言葉でしか呟けないSNS<br />
                    (ベータ版)
                </p>

                <div class="text-center mt-12">
                    <a href="/login/twitter">
                        <button class="text-2xl bg-gray-900 hover:bg-gray-700 text-white font-bold py-4 px-12 rounded-full">
                            Twitterでログイン
                        </button>
                    </a>
                </div>
            </div>

            <footer class="hidden my-10 lg:block lg:flex-none">
                <ul class="px-20 flex justify-around">
                    <Link href="/terms"><li>利用規約</li></Link>
                    <Link href="/privacy"><li>プライバシーポリシー</li></Link>
                    <a href="https://twitter.com/plus_marumaru" target="_blank"><li>&copy; 2022 coffee-r</li></a>
                </ul>
            </footer>
        </section>

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

    <footer class="lg:hidden">
        <ul class="my-3 flex flex-col">
            <li class="my-2 grid justify-items-center">利用規約</li>
            <li class="my-2 grid justify-items-center">
                <a href="#">プライバシーポリシー</a>
            </li>
            <li class="my-2 grid justify-items-center">
                <a href="https://twitter.com/plus_marumaru" target="_blank"
                    >&copy; 2022 coffee-r</a
                >
            </li>
        </ul>
    </footer>
</template>
