<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<!-- スマホ用の投稿ボタン -->
<template>
    <Link href="/post">
        <button class="fixed bottom-6 right-6 align-bottom leading-14 text-2xl text-white font-bold bg-gray-900 hover:bg-gray-700 rounded-full w-14 h-14 lg:hidden"><span>＋</span></button>
    </Link>
</template>
