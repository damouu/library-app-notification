@props([
    'url' => 'http://localhost:8080/catalog'
])

<div style="text-align:center; margin:32px 0;">
    <a href="{{ $url }}"
       style="
            display:inline-block;
            background:#2563eb;
            color:#fff;
            text-decoration:none;
            padding:14px 28px;
            border-radius:8px;
            font-weight:bold;
            font-size:16px;
            font-family:Arial, Helvetica, sans-serif;
        ">
        📚 蔵書を見る
    </a>
</div>
