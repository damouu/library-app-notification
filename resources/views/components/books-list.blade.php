@foreach($books as $chapter)
    <div>
        @if(data_get($chapter, 'cover_artwork_url'))
            <img
                src="{{ data_get($chapter, 'cover_artwork_url') }}"
                alt="{{ data_get($chapter, 'title') }}"
                width="250"
                style="display: block; margin: 0 auto 10px;"
            >
        @endif

        <p><strong>タイトル：</strong>{{ data_get($chapter, 'title') }}</p>
        <p><strong>サブタイトル：</strong><em>{{ data_get($chapter, 'second_title') }}</em></p>
        <p>第<em>{{ data_get($chapter, 'chapter_number') }}</em>巻</p>
    </div>
@endforeach
