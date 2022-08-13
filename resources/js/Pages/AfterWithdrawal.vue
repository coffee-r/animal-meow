<template>
    <header class="flex justify-between">
        <a href="{{ route('home') }}"><img class="hover:opacity-50 my-4 ml-4 w-7 lg:mt-6 lg:ml-6 lg:w-10" src="/images/logo.svg"></a>
    </header>

    <article class="px-4 py-8 bg-white rounded-lg border border-gray-200 shadow-md max-w-full lg:px-12 lg:py-12 lg:mx-auto lg:w-9/12">
        <h1 class="text-center font-bold text-3xl lg:text-4xl">退会しました</h1>            

        <p class="mt-8">
            この度は本サービスをご利用頂き、誠にありがとうございました。わずかでもお役に立てたのであれば幸いです。
        </p>

        <a href="{{ route('index') }}"><button class="text-2xl bg-gray-900 hover:bg-gray-500 text-white font-bold py-4 px-12 rounded-full">TOPへ戻る</button></a>

    </article>

    <footer>
        <ul class="my-3 flex flex-col">
            <li class="my-2 grid justify-items-center"><a href="#">利用規約</a></li>
            <li class="my-2 grid justify-items-center"><a href="#">プライバシーポリシー</a></li>
            <li class="my-2 grid justify-items-center"><a href="https://twitter.com/plus_marumaru" target="_blank">&copy; 2022 coffee-r</a></li>
        </ul>
    </footer>
</template>