<head>
    <style>
        {!! file_get_contents('resources/css/app.css') !!}
    </style>
</head>

<div class="user-email">

    <div class="borrow-header">
        <x-borrow-header/>
    </div>

    <div style="margin-top: 30px;">
        <div class="appli-title">
            <x-user-registration/>
        </div>

        <div style="margin-top: 24px; border-bottom: 1px solid #eee;">
            <x-user-welcome-message :user-projection="$userProjection"/>
            <x-user-membercard :user-projection="$userProjection"/>
        </div>
    </div>

    <div style="margin-top: 40px;">
        <div class="appli-title">
            <x-books-popular/>
        </div>

        <div class="chapters-list">
            <x-books-list :books="$popularChapters"/>
        </div>

        <div style="margin-top: 24px; border-bottom: 1px solid #eee;">
            <x-catalog-button url="https://library.damou.dev/series?page=1"/>
            <p style="text-align:center; color:#6b7280; font-size: 14px; margin-top: 16px;">
                あなたにぴったりの一冊が見つかりますように。📚
            </p>
        </div>

        <div style="text-align: center; border-bottom: 1px solid #eee;">
            <x-use-explanation/>
        </div>

        <div>
            <x-use-reminder/>
        </div>
    </div>

    <div style="margin-top: 40px;">
        <x-user-register-footer/>
    </div>

</div>
