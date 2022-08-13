<script setup>
    import { ref } from "vue"
    import { Link } from "@inertiajs/inertia-vue3";

    defineProps({
        posts: Array,
    });

    const isSelectedUrlPath = function(path){
        if(location.pathname == path){
            return true
        }
    }

</script>

<!-- PCのサイドメニュー -->
<template>
    <aside class="hidden lg:flex lg:flex-col lg:block lg:sticky lg:h-screen lg:top-0 lg:w-1/2">
        <header class="lg:flex-none">
            <Link href="/home"><img class="mt-4 ml-4 w-7 mt-6 ml-6 w-10 hover:opacity-50" src="/images/logo.svg"></Link>
        </header>

        <ul class="lg:flex-1 lg:text-center lg:mt-24 lg:flex lg:flex-col lg:gap-8">
            <li class="text-3xl" v-bind:class="{'font-bold':isSelectedUrlPath('/home') }"><Link class="hover:text-gray-500" href="/home">ホーム</Link></li>
            <li class="text-3xl" v-bind:class="{'font-bold':isSelectedUrlPath('/me') }"><Link class="hover:text-gray-500" href="/me">自分の投稿</Link></li>
            <li class="text-3xl" v-bind:class="{'font-bold':isSelectedUrlPath('/others') }"><Link class="hover:text-gray-500" href="/others">その他</Link></li>
            <li><Link href="/post"><button class="text-2xl bg-gray-900 hover:bg-gray-500 text-white font-bold py-4 px-12 rounded-full">鳴く</button></Link></li>
        </ul>

        <footer class="lg:flex-none mt-16 mb-2">
            <ul class="flex justify-around gap-2">
                <li><Link href="/terms">利用規約</Link></li>
                <li><Link href="/privacy">プライバシーポリシー</Link></li>
                <li><a href="https://twitter.com/plus_marumaru" target="_blank">&copy; 2022 coffee-r</a></li>
            </ul>
        </footer>
    </aside>
</template>