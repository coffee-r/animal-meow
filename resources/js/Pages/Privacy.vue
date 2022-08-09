<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    users: Array,
});
</script>

<template>
    <header class="flex justify-between">
        <a href="#"><img class="hover:opacity-50 my-4 ml-4 w-7 lg:mt-6 lg:ml-6 lg:w-10" src="/images/logo.svg"></a>
    </header>

    <article class="prose px-4 py-8 bg-white rounded-lg border border-gray-200 shadow-md max-w-full lg:px-12 lg:py-12 lg:mx-auto lg:w-9/12">
        
        <h1 class="text-center">プライバシーポリシー</h1>

        <p>
            この文章は本サービスにおける個人情報の保護およびその適切な取り扱いについての方針を示したものです。
        </p>

        <h2>外部SNSアカウント連携による情報の取得</h2>
        <p>
            <ul>
                <li>本サービスでのユーザー新規登録およびログイン時に、外部SNS(Twitter)よりユーザー名、アバター画像、外部SNSに投稿するための認可情報を取得します。</li>
                <li>ユーザー名、アバター画像については、本サービス上で投稿者が分かるようにするためにサイト上にて公開をします。</li>
                <li>外部SNSに投稿するための認可情報は、本サービスでユーザーが投稿を行う際に外部SNSにも併せて投稿を行う場合に限り使用します。</li>
            </ul>
        </p>

        <h2>本サービスでの投稿による取得</h2>
        <p>
            <ul>
                <li>本サービスの投稿機能において、入力が許可されている文字を使用して、ユーザーが文章を入力できます。この文章は本サービスの提供のため、本サービスのシステムに保存し、サイト上で公開されます。</li>
                <li>本サービスの投稿機能において、ユーザーが自発的に個人情報を入力し投稿した場合、その個人情報が他のユーザーに参照される可能性があります。この場合は本サービスの個人情報保護の対象外となり、投稿を行なったユーザ自身の責任となりますので、あらかじめご了承ください。</li>
            </ul>
                         
        </p>

        <h2>Cookieの使用</h2>
        <p>
            <ul>
                <li>お客様のウェブサイト利用状況を分析し、または個々のお客様に対してカスタマイズされたサービス・広告を提供する等の目的のため、Cookieを使用して一定の情報を収集します。</li>
                <li>Cookieには、本サービスによって設定されるもの（ファーストパーティークッキー）と、本サービスと提携する第三者によって設定されるもの（サードパーティークッキー）があります。</li>
                <li>本サービスでは、Cookieを、お客様がウェブサイトを閲覧する際に同じ情報を繰り返し入力することがなくなるなど、お客様の利便性向上のために使用しています。</li>
                <li>本サービスでは、Cookieを使用して収集した情報を利用して、お客様のウェブサイトの利用状況（アクセス状況、トラフィック、ルーティング等）を分析し、ウェブサイト自体のパフォーマンス改善や、本サービスからお客様に提供するサービスの向上、改善のために使用することがあります。</li>
                <li>また、この分析にあたっては、Google アナリティクスが利用され、ツール提供者に情報提供されることがあります。</li>
                <li>お客様がブラウザの設定を変更することによりCookieを無効にすることが可能です。ただし、Cookieを無効にした場合は、一部のサービスが受けられない場合があります。Cookieの設定の変更方法については、各ブラウザの製造元へご確認ください。</li>
            </ul>     
        </p>

        <h5>最終更新日 2022/8/7</h5>

    </article>

    <footer>
        <ul class="my-3 flex flex-col">
            <li class="my-2 grid justify-items-center"><a href="#">利用規約</a></li>
            <li class="my-2 grid justify-items-center"><a href="#">プライバシーポリシー</a></li>
            <li class="my-2 grid justify-items-center"><a href="https://twitter.com/plus_marumaru" target="_blank">&copy; 2022 coffee-r</a></li>
        </ul>
    </footer>
</template>