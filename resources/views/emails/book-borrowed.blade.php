<head>
    <style>
        {!! file_get_contents('resources/css/app.css') !!}
    </style>
</head>

<div class="borrow-header">
    <x-borrow-header/>
</div>

<div style="margin-top: 30px">
    <div class="appli-title">
        <x-borrow-title/>
    </div>

    <div class="notification-data">

        <div class="borrow-number-information">
            <x-borrow-number-information :borrowUUID="$borrowEvent->borrowCreatedEventDataDTO->borrowUuid"/>
        </div>

        <div class="borrow-dates-information">
            <x-borrow-dates-information :borrowStartDate="$borrowEvent->borrowCreatedEventDataDTO->borrowStartDate"
                                        :borrowEndDate="$borrowEvent->borrowCreatedEventDataDTO->borrowEndDate"/>
        </div>

    </div>

</div>

<div class="chapters-count">
    <x-borrow-books-count :count="$books->count()"/>
</div>

<div class="chapters-list">
    <x-books-list :books="$books"/>
</div>

<div class="borrow-footer">
    <x-borrow-footer/>
</div>
