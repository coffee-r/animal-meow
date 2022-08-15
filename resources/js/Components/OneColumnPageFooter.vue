<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <footer>
        <ul class="py-4 flex flex-col gap-y-4 lg:py-8 lg:flex-row lg:justify-center lg:gap-x-24">
            <Link href="/terms"><li class="grid justify-items-center hover:opacity-50">利用規約</li></Link>
            <Link href="/privacy"><li class="grid justify-items-center hover:opacity-50">プライバシーポリシー</li></Link>
            <a href="https://twitter.com/plus_marumaru" target="_blank"><li class="grid justify-items-center hover:opacity-50">&copy; 2022 coffee-r</li></a>
        </ul>
    </footer>
</template>
