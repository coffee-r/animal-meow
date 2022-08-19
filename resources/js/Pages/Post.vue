<script setup>
import { ref, reactive, watch, computed } from "vue"
import { useForm } from '@inertiajs/inertia-vue3'
import AnimalIME from "@/Components/AnimalIME.vue";
import CustomButton from "@/Components/CustomButton.vue";
import LoginUserSpHeader from "@/Components/LoginUserSpHeader.vue";
import LoginUserPcSideMenu from "@/Components/LoginUserPcSideMenu.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";

const props = defineProps({
    animals: Object,
});

// 投稿メッセージとして入力できる動物言葉
// バインドさせておくことで、動物IMEの中の文字を入れ替えられるようにしたい
const currentAnimalAvailableWords = ref([]);

// 投稿メッセージの言葉の配列
// ※ postForm.messageで絵文字を削除しようとすると文字化けする問題があったため、ユーザーの入力を一旦配列に入れます
const inputWordsArray = ref([]);

// 投稿フォーム
const postForm = useForm({
    animalTypeId: '',
    message: '',
    withTweet: null,
});


// 投稿フォームに入力しているか
const isFilledPostForm = computed(() => postForm.animalTypeId != '' && postForm.message.trim().length != 0)


// 動物を選択したときに、動物IMEの中の文字を入れ替える
watch(
    () => postForm.animalTypeId,
    (animalTypeId, prevAnimalTypeId) => {
        // 文字の入れ替え
        // currentAnimalAvailableWords.value = props.animals[animalTypeId]['availableWords']; これだと文字が重複する挙動が何故か起こるので以下コードにする
        currentAnimalAvailableWords.value = Array.from(new Set(props.animals.find(animal => animal.id == animalTypeId).words));

        // 投稿メッセージのクリア
        inputWordsArray.value = [];
        postForm.message = inputWordsArray.value.join('');
    }
)

// 投稿メッセージ末尾に文字を追加する
const addWordToMessage = function(word){
    // 120文字以上は投稿できない
    if(inputWordsArray.value.length >= 120){
        return;
    }
    inputWordsArray.value.push(word);
    postForm.message = inputWordsArray.value.join('');
}

// 投稿メッセージ末尾の文字を削除する
const removeOneWordToMessage = function(){
    inputWordsArray.value.pop();
    postForm.message = inputWordsArray.value.join('');
}

// 投稿フォームを送信する
const submitPost = function(){
    postForm.post(route('post.store'));
}
</script>

<template>

    <!-- スマホ・タブレットのヘッダーメニュー -->
    <LoginUserSpHeader />

    <!-- バリデーションエラー表示 -->
    <ValidationErrors />
    
    <!-- PCのみ2カラム構成のレイアウトにする -->
    <main class="lg:flex">

        <!-- PCのサイドメニュー -->
        <LoginUserPcSideMenu />

        <!-- 投稿フォーム -->
        <article class="lg:w-full lg:h-auto lg:mt-0">
            
            <!-- 投稿フォーム -->
            <div class="flex bg-white rounded-xl border border-gray-200 shadow-md mx-2 mb-4 px-4 py-4 lg:mx-6 lg:mt-3 lg:mb-6 lg:px-8 lg:py-8">
                <form @submit.prevent="submitPost" class="w-full m-4">

                    <!-- 動物選択 -->
                    <select v-model="postForm.animalTypeId" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example">
                        <option disabled value=''>動物を選ぶ</option>
                        <option v-for="animal in animals" :key="animal.id" :value="animal.id">{{animal.name}}</option>
                    </select>

                    <!-- 投稿メッセージ -->
                    <textarea readonly v-model="postForm.message" rows="3" class="resize-none block mt-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>

                    <!-- 動物言葉の入力IME -->
                    <!-- 動物言葉1文字ごとにボタンを配置し、押下されたら動物言葉をemitする -->
                    <AnimalIME class="mt-2" v-bind:words="currentAnimalAvailableWords" @removeWordNotification="removeOneWordToMessage" @addWordNotification="addWordToMessage" />

                    <!-- ツイート投稿オプション -->
                    <div class="flex items-center mt-8">
                        <input v-model="postForm.withTweet" id="tweet-checkbox" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2" >
                        <label for="tweet-checkbox" class="ml-2 font-medium text-gray-900 dark:text-gray-300">Twitterにも投稿する</label>
                    </div>

                    <!-- 投稿ボタン -->
                    <CustomButton type="submit" v-bind:disabled="postForm.processing || !isFilledPostForm">鳴く</CustomButton>

                </form>
            </div>
        </article>
    </main>
</template>
