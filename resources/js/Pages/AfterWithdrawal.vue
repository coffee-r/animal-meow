<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import CustomHeader from '@/Components/CustomHeader.vue';
</script>

<template>
    <!-- 退会の通知 -->
    <div v-if="$page.props.flash.successMessages">
        <div v-for="message in $page.props.flash.successMessages" :key="message" class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-bold">{{ message }}</span> 
        </div>
    </div>

    <div class="bg-blue-100 bg-opacity-20">
    <CustomHeader />

        <article class="prose prose-sm sm:prose-base lg:prose-base max-w-5xl mx-auto bg-white border border-gray-200 rounded-xl shadow-md px-4 py-8 sm:px-8">

            <h1 class="text-center">Thank you!</h1>

            <p>
                この度はあにまるにゃ〜んをご利用頂き、ありがとうございました。僅かでもお役に立てたのであれば幸いです。また機会がありましたらご利用ください。
            </p>

        </article>

        <footer>
            <ul class="py-4 flex flex-col gap-y-4 lg:py-8 lg:flex-row lg:justify-center lg:gap-x-24">
                <Link href="/terms"><li class="grid justify-items-center hover:opacity-50">利用規約</li></Link>
                <Link href="/privacy"><li class="grid justify-items-center hover:opacity-50">プライバシーポリシー</li></Link>
                <a href="https://twitter.com/plus_marumaru" target="_blank"><li class="grid justify-items-center hover:opacity-50">&copy; 2022 coffee-r</li></a>
            </ul>
        </footer>
        
    </div>

</template>