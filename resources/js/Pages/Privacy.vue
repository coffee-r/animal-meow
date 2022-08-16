<script setup>
import OneColumnPageHeader from "@/Components/OneColumnPageHeader.vue";
import OneColumnPageFooter from "@/Components/OneColumnPageFooter.vue";
</script>

<template>

    <!-- 背景色指定 -->
    <div class="bg-blue-100 bg-opacity-20">

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
                    <li>Cookieとはお客様のウェブサイト閲覧情報を、そのお客様のコンピューター（PCやスマートフォン、タブレットなどインターネット接続可能な機器）に記憶させる機能のことです。</li>
                    <li>Cookieには、本サービスによって設定されるもの（ファーストパーティークッキー）と、本サービスと提携する第三者によって設定されるもの（サードパーティークッキー）があります。</li>
                    <li>本サービスではユーザーのログイン状態を維持するためにCookieを使用しています。</li>
                </ul>     
            </p>

            <h5 class="text-center mt-8">最終更新日 2022/8/7</h5>

        </article>

        <!-- フッター -->
        <OneColumnPageFooter />

    </div>

</template>