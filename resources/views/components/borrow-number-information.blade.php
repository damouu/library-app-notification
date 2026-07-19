@props(['borrowUUID'])

<h3 style="text-align: center">貸出番号： {{ Str::limit($borrowUUID, 8, '') }} </h3>

