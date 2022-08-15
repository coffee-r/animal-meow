<script setup>
    import { ref, reactive, watch } from "vue"
    import { Inertia } from '@inertiajs/inertia'
    import AnimalIME from "@/Components/AnimalIME.vue";
    import LoginUserSpHeader from "@/Components/LoginUserSpHeader.vue";
    import LoginUserPcSideMenu from "@/Components/LoginUserPcSideMenu.vue";
    import ValidationErrors from "@/Components/ValidationErrors.vue";

    const props = defineProps({
        animals: Array,
    });

    const currentAnimalAvailableWords = ref(null);

    const postForm = reactive({
        animalTypeId: '',
        message: '',
        withTweet: null,
    });

    // 動物を選択したときに、IMEを切り替える
    watch(
        () => postForm.animalTypeId,
        (animalTypeId, prevAnimalTypeId) => {
            // IMEの切り替え
            // currentAnimalAvailableWords.value = props.animals[animalTypeId]['availableWords']; これだと何故か項目が増殖するため以下にする
            currentAnimalAvailableWords.value = Array.from(new Set(props.animals[animalTypeId]['availableWords']));

            // テキストエリアのクリア
            postForm.message = '';
        }
    )

    const addMessage = function(word){
        // 120文字以上は投稿できない
        if(postForm.message.length > 120){
            return;
        }
        postForm.message += word;
    }

    const backMessage = function(){
        console.log('bbbbb');
        postForm.message = postForm.message.slice(0, -1);
    }
    

    const submitPost = function(){
        Inertia.post('/post', postForm);
    }

</script>

<template>

    <!-- スマホ・タブレットのヘッダーメニュー -->
    <LoginUserSpHeader />
   
    <main class="lg:flex">

        <!-- PCのサイドメニュー -->
        <LoginUserPcSideMenu />

        <!-- 投稿フォーム -->
        <article class="bg-blue-100 bg-opacity-20 py-1 lg:w-full lg:mt-0">

            <!-- バリデーションエラー表示 -->
            <ValidationErrors />

            <div class="flex mx-6 my-4 p-2 max-w-full bg-white rounded-lg border border-gray-200 shadow-md">
                <form @submit.prevent="submitPost" class="w-full m-4">

                    <select v-model="postForm.animalTypeId" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example">
                        <option disabled value=''>動物を選ぶ</option>
                        <option value="1">ネコ</option>
                        <option value="2">イヌ</option>
                        <option value="3">ゴリラ</option>
                    </select>

                    <textarea v-model="postForm.message" rows="4" class="block mt-4 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>

                    <AnimalIME class="mt-2" v-bind:words=currentAnimalAvailableWords @backWordNotification='backMessage' @addWordNotification='addMessage' />

                    <br/>

                    <div class="flex items-center mt-8">
                        <input v-model="postForm.withTweet" id="tweet-checkbox" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                        <label for="tweet-checkbox" class="ml-2 font-medium text-gray-900 dark:text-gray-300">Twitterにも投稿する</label>
                    </div>
                    <button type="submit" class="mt-8 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                </form>
            </div>
        </article>
    </main>
</template>
