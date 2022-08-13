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

    const isSelectedUrlPath = function(path){
        if(location.pathname == path){
            return true
        }
    }
</script>

<!-- スマホのヘッダーメニュー -->
<template>
    <header>
        <!-- アイコン -->
        <div class="flex justify-between bg-white sticky top-0 lg:hidden">
            <Link href="/home"><img class="hover:opacity-50 w-8 my-4 ml-4 sm:w-9 sm:my-5 sm:ml-5 lg:w-10 lg:my-6 lg:ml-6" src="/images/logo.svg"></Link>
            <img @click="showModalMenu(true)" class="hover:opacity-50 w-8 my-4 mr-4 sm:w-9 sm:my-5 sm:mr-5 lg:w-10 lg:my-6 lg:mr-6" src="/images/menu_icon.svg">
        </div>

        <!-- モーダルのナビゲーション -->
        <nav class="overflow-y-auto overflow-x-hidden fixed top-0 left-0 w-full h-full bg-gray-900/25 lg:hidden" @click.self="showModalMenu(false)" v-show="isOpenModalMenu">
            <div class="text-center bg-white h-auto p-4 shadow-xl rounded mt-10 mx-6">
                <ul class="mt-12 flex flex-col gap-8">
                    <Link href="/home"><li class="text-3xl hover:text-gray-500" v-bind:class="{'font-bold':isSelectedUrlPath('/home') }">ホーム</li></Link>
                    <Link href="/me"><li class="text-3xl hover:text-gray-500" v-bind:class="{'font-bold':isSelectedUrlPath('/me') }">自分の投稿</li></Link>
                    <Link href="/others"><li class="text-3xl hover:text-gray-500" v-bind:class="{'font-bold':isSelectedUrlPath('/others') }">その他</li></Link>
                    <li><Link href="/post"><button class="text-2xl bg-gray-900 hover:bg-gray-500 text-white font-bold py-4 px-12 rounded-full">鳴く</button></Link></li>
                </ul>

                <footer class="mt-16 mb-2">
                    <ul class="flex flex-col justify-around gap-2">
                        <li><Link href="/terms">利用規約</Link></li>
                        <li><Link href="/privacy">プライバシーポリシー</Link></li>
                        <li><a href="https://twitter.com/plus_marumaru" target="_blank">&copy; 2022 coffee-r</a></li>
                    </ul>
                </footer>
            </div>
        </nav>
    </header>
</template>