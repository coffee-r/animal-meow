<script setup>
    import { ref } from "vue"
    import { Link } from "@inertiajs/inertia-vue3";

    defineProps({
        posts: Array,
    });

    const isOpenModalMenu = ref(false);

    const showModalMenu = function(value){
        isOpenModalMenu.value = value;
    }
</script>

<!-- PCのサイドメニュー -->
<template>
    <aside class="hidden lg:flex lg:flex-col lg:block lg:sticky lg:h-screen lg:top-0 lg:w-1/2">
        <header class="lg:flex-none">
            <Link href="/home"><img class="mt-4 ml-4 w-7 mt-6 ml-6 w-10 hover:opacity-50" src="/images/logo.svg"></Link>
        </header>

        <ul class="lg:flex-1 lg:text-center lg:mt-24 lg:flex lg:flex-col lg:gap-8">
            <li class="text-3xl font-bold hover:text-gray-500"><a href="{{ route('home') }}">ホーム</a></li>
            <li class="text-3xl font-bold hover:text-gray-500"><a href="{{ route('me') }}">自分の投稿</a></li>
            <li class="text-3xl font-bold hover:text-gray-500"><a href="{{ route('others') }}">その他</a></li>
            <li><a href="{{ route('post.create') }}"><button class="text-2xl bg-gray-900 hover:bg-gray-500 text-white font-bold py-4 px-12 rounded-full">鳴く</button></a></li>
        </ul>

        <footer class="lg:flex-none mt-16 mb-2">
            <ul class="flex justify-around gap-2">
                <li><a href="{{ route('terms') }}">利用規約</a></li>
                <li><a href="{{ route('privacy') }}">プライバシーポリシー</a></li>
                <li><a href="https://twitter.com/plus_marumaru" target="_blank">&copy; 2022 coffee-r</a></li>
            </ul>
        </footer>
    </aside>
</template>