<script setup>
    import { reactive } from "vue"
    import { Inertia } from '@inertiajs/inertia'
    import LoginUserSpHeader from "@/Components/LoginUserSpHeader.vue";
    import FixedPostButton from "@/Components/FixedPostButton.vue";
    import LoginUserPcSideMenu from "@/Components/LoginUserPcSideMenu.vue";

    const submitLogout = function(){
        Inertia.post('/logout');
    }

    const withdrawalForm = reactive({
      confirmText: null,
    })

    const submitWithdrawal = function(){
        Inertia.post('/withdrawal', withdrawalForm);
    }

</script>

<template>
    <!-- スマホのヘッダーメニュー -->
    <LoginUserSpHeader />

    <!-- スマホ・タブレットの投稿画面リンク -->
    <FixedPostButton />

    <main class="lg:flex">

        <!-- PCのサイドメニュー -->
        <LoginUserPcSideMenu />

        <!-- その他 -->
        <article class="bg-blue-100 bg-opacity-20 py-1 lg:w-full lg:mt-0">
            <div class="mx-6 my-4 py-8 px-4 max-w-full bg-white rounded-lg border border-gray-200 shadow-md">
                <h2 class="font-bold text-2xl lg:text-4xl">開発のために主に利用や参考にさせて頂いたもの</h2>
        
                <ul class="list-disc list-outside pl-5 mt-2">
                    <li>Twitter</li>
                    <li>Laravel</li>
                    <li>Postgres</li>
                    <li>Heroku</li>
                    <li>Docker</li>
                    <li>Vite</li>
                    <li>Tailwind CSS</li>
                    <li>Figma</li>
                    <li>Draw.io</li>
                    <li>icooon-mono.com</li>
                    <li>kiyaku.jp</li>
                </ul>
        
                <p class="mt-2"></p>
        
                その他、世に広まっているたくさんの技術のおかげで本サービスを開発することが出来ています。
            </div>
        
            <div class="mx-6 my-4 py-8 px-4 max-w-full bg-white rounded-lg border border-gray-200 shadow-md">
                <h2 class="font-bold text-2xl lg:text-4xl">ログアウト</h2>
        
                <form @submit.prevent="submitLogout" class="w-full m-4">
                    <button type="submit" class="text-2xl bg-gray-900 hover:bg-gray-500 text-white font-bold py-4 px-12 rounded-full">ログアウトする</button>
                </form>
            </div>
        
            <div class="mx-6 my-4 py-8 px-4 max-w-full bg-white rounded-lg border border-gray-200 shadow-md">
                <h2 class="font-bold text-2xl lg:text-4xl">退会</h2>
        
                <ul class="list-disc list-outside pl-5">
                    <li>当サイトからあなたのアカウントを削除します。</li>
                    <li>当サイトでのあなたの全ての投稿を削除します。</li>
                    <li>Twitterへ併せて投稿していた場合の、Twitterのツイートは削除しません。</li>
                    <li>他のユーザー投稿にしたいいねの数は削除しません。</li>
                </ul>
        
                <form @submit.prevent="submitWithdrawal" class="w-full m-4">
                    <input type="text" v-model="withdrawalForm.confirmText" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"  placeholder="「退会する」と入力してボタンを押す">
                    <button type="submit" class="text-2xl bg-red-600 hover:bg-red-400 text-white font-bold py-4 px-12 rounded-full">退会する</button>
                </form>
        
            </div>
        </article>
    </main>
</template>
