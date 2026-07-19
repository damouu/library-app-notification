@props(['userProjection'])

<table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin: 0 auto;">
    <tr>
        <td style="vertical-align: middle; padding-right: 5px;">
            <img
                src="{{ $userProjection->avatar_img_url }}"
                alt="User avatar"
                width="40"
                height="40"
                style="display: block; width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
            >
        </td>

        <td style="vertical-align: middle; font-size: 22px; color: #ffffff;">
            <strong>{{ $userProjection->user_name }}様</strong>
        </td>
    </tr>
</table>
