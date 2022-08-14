<script setup>
    const props = defineProps({
        words: Array,
    });

    const emits = defineEmits(["addWordNotification", "removeWordNotification"])

    const addWord = function(word){
        console.log('aaa');
        emits("addWordNotification", word);
    }

    const removeWord = function(){
        emits("removeWordNotification");
    }

</script>

<!-- 動物言葉のIME -->
<template>
    <div class="flex flex-wrap gap-2">
        <button v-for="word in words" :key="word" @click="addWord(word)" type="button" class="bg-gray-900 text-white font-bold border-2 border-gray-900 rounded-full w-10 h-10">{{ word }}</button>
    </div>
</template>