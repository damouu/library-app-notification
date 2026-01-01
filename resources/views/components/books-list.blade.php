@foreach($notificationData['chapters'] as $chapter)
    <div>
        <h3>タイトル：{{ $chapter['chapter_title'] }}</h3>
        <img src="{{ $chapter['chapter_cover_url'] }}"
             alt="{{ $chapter['chapter_title'] }}"
             width="250"
             style="display: block; margin: 0 auto 10px;">
        <h3>サブタイトル：<em>{{ $chapter['chapter_second_title'] }}</em></h3>
        <h3>第<em>{{ $chapter['chapter_number'] }}巻</em></h3>
    </div>
@endforeach
