<script setup>

const props = defineProps({
    words: Array
});

const emits = defineEmits([
    "addWordNotification",
    "removeWordNotification"
])

const addWord = function(word){
    emits("addWordNotification", word);
}

const removeWord = function(){
    emits("removeWordNotification");
}
</script>

<script>
import { defineComponent } from "@vue/runtime-core";
export default defineComponent({
    inheritAttrs: false,
});
</script>



<!-- 動物言葉のIME -->
<template>
    <div class="flex flex-wrap gap-2">
        <button v-for="word in words" :key="word" @click="addWord(word)" type="button" class="bg-gray-900 text-white font-bold border-2 border-gray-900 rounded-full w-10 h-10">{{ word }}</button>
    </div>
    <button v-if="words.length != 0" @click="removeWord()" type="button" class="mt-4 bg-gray-900 text-white font-bold border-2 border-gray-900 px-4 py-2 rounded-full">一つ戻る</button>
</template>