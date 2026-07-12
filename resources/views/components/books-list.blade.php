@foreach($books as $chapter)
    <div>
        @if(data_get($chapter, 'cover_artwork_url'))
            <a href="http://localhost:3000/chapter/{{ data_get($chapter, 'chapter_uuid') }}">
                <img
                    src="{{ data_get($chapter, 'cover_artwork_url') }}"
                    alt="{{ data_get($chapter, 'title') }}"
                    width="250"
                    style="display: block; margin: 0 auto 10px;"
                >
            </a>
        @endif

        <p><em>{{ data_get($chapter, 'title') }}</em></p>
        <p>第<em>{{ data_get($chapter, 'chapter_number') }}</em>巻</p>
    </div>
@endforeach
