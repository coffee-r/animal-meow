<script setup>
import OneColumnPageHeader from "@/Components/OneColumnPageHeader.vue";
import OneColumnPageFooter from "@/Components/OneColumnPageFooter.vue";
</script>

<template>

    <!-- ヘッダー -->
    <OneColumnPageHeader />

    <!-- プライバシーポリシー 本文 -->
    <article class="prose prose-sm sm:prose-base lg:prose-base max-w-5xl mx-2 lg:mx-auto bg-white border border-gray-200 rounded-xl shadow-md px-4 py-8 sm:px-8">
        
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
                <li>外部SNSに投稿するための認可情報は、外部SNSサービスにて無効化することができます。Twitterの場合「連携しているアプリ」より本サービスの許可を取り消してください。</li>
            </ul>
        </p>

        <h2>本サービスでの投稿による取得</h2>
        <p>
            <ul>
                <li>本サービスの投稿機能において、ユーザーが文章を入力できます。この文章は本サービスの提供のため、本サービスのシステムに保存し、サイト上で公開されます。</li>
                <li>本サービスの投稿機能において、ユーザーが自発的に個人情報を入力し投稿した場合、その個人情報が他のユーザーに参照される可能性があります。この場合は本サービスの個人情報保護の対象外となり、投稿を行なったユーザ自身の責任となりますので、あらかじめご了承ください。</li>
            </ul>
        </p>

        <h2>Cookieの使用</h2>
        <p>
            <ul>
                <li>Cookieとはユーザーのウェブサイト閲覧情報を、そのユーザーのコンピューター（PCやスマートフォン、タブレットなどインターネット接続可能な機器）に記憶させる機能のことです。</li>
                <li>Cookieには、本サービスによって設定されるもの（ファーストパーティークッキー）と、本サービスと提携する第三者によって設定されるもの（サードパーティークッキー）があります。</li>
                <li>本サービスでは、Cookieを、ログイン状態の維持やCSRF対策など、本サービスを正常に機能させるために使用しています。</li>
                <ul>
                    <li>Coookie名「_session」</li>
                    <li>Coookie名「XSRF-TOKEN」</li>
                </ul>
                <li>本サービスでは、Cookieを使用して収集した情報を利用して、ユーザーのウェブサイトの利用状況（アクセス状況、トラフィック、ルーティング等）を分析し、ウェブサイト自体のパフォーマンス改善や、本サービスからユーザーに提供するサービスの向上、改善のために使用することがあります。またこの分析には Googleアナリティクス が利用され、ツール提供者に情報提供されることがあります。</li>
                <ul>
                    <li>Coookie名「_ga」</li>
                    <li>Coookie名「_ga_K9D6BFDXNW」</li>
                </ul>
                <li>ユーザーがブラウザの設定を変更することによりCookieを無効にすることが可能です。ただし、Cookieを無効にした場合は、一部のサービスが受けられない場合があります。Cookieの設定の変更方法については、各ブラウザの製造元へご確認ください。</li>
            </ul>     
        </p>

        <h5 class="text-center mt-8">最終更新日 2022/8/16</h5>

    </article>

    <!-- フッター -->
    <OneColumnPageFooter />

</template>