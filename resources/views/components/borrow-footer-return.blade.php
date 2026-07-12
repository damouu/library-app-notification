@props(['isLate'])

@if($isLate)
    <p style="color: orange; font-size: 13px; text-align: center;">
        ※延滞金のお支払いは、次回のご来館時に窓口にてお願いいたします。
    </p>
@else
    <p style="color: #a0aec0; font-size: 13px; text-align: center;">
        ※またのご利用を心よりお待ちしております。
    </p>
@endif
