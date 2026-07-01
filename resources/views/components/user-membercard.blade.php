@props(['userProjection'])

<div class="member_card">
    <h3 style="
        margin:0 0 16px;
        font-size:18px;
        color:#1f2937;
    ">
        🪪 会員情報
    </h3>

    <table role="presentation" width="100%" cellpadding="6" cellspacing="0" style="font-size: 15px;">
        <tr>
            <td width="120" style="color:#6b7280; padding-bottom: 8px;">
                👤 ユーザー名
            </td>
            <td style="padding-bottom: 8px;">
                <strong style="color: #111827;">{{ $userProjection->user_name }}</strong>
            </td>
        </tr>

        <tr>
            <td style="color:#6b7280; padding-bottom: 8px;">
                📧 メール
            </td>
            <td style="padding-bottom: 8px;">
                <strong style="color: #111827;">{{ $userProjection->email }}</strong>
            </td>
        </tr>

        <tr>
            <td style="color:#6b7280;">
                🪪 会員番号
            </td>
            <td>
                <code style="
                    background:#eef2ff;
                    color: #4338ca;
                    padding:4px 8px;
                    border-radius:6px;
                    font-size:14px;
                    font-weight: bold;
                ">
                    {{ $userProjection->member_card_uuid }}
                </code>
            </td>
        </tr>
    </table>
</div>
