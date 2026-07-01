@props(['userProjection'])

<table role="presentation" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="vertical-align: middle; padding-right: 10px;">
            <img
                src="{{ $userProjection->avatar_img_url }}"
                alt="User avatar"
                class="user-avatar"
            >
        </td>
        <td style="vertical-align: middle;">
            <strong>{{ $userProjection->user_name }}様</strong>
        </td>
    </tr>
</table>
