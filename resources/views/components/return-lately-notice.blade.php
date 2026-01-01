@props(['endDate', 'daysLate', 'fine', 'notificationData'])

<div
    style="background-color: #fff5f5; border-left: 4px solid #ff5252; padding: 5px; margin: 20px 0;">
    <p style="color: #ff5252; font-weight: bold; margin: 0; font-size: 16px; text-align: center;">
        【重要】返却期限超過のお知らせ
    </p>
    <p style="color: #333; font-size: 14px; line-height: 1.6; margin: 10px 0 0 5px;">
        恐れ入りますが、図書の返却期限日（{{ $endDate->format('Y/m/d') }}）を<strong>{{ $daysLate }}
            日</strong>経過しての返却となりました。<br>
        規定に基づき、延滞金として<strong>{{ number_format($fine) }}円</strong>が発生いたしましたので、窓口にでお支払いをお願いいたします。
    </p>
</div>
