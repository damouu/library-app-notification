@php use Carbon\Carbon; @endphp

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
        <x-user-information :user-projection="$userProjection"/>
    </div>

    <div class="appli-title">
        <x-borrow-title/>
    </div>

    <div class="notification-data">

        <div class="borrow-number-information">
            <x-borrow-number-information :borrowUUID="$returnBorrowEvent->returnCreatedEventDataDTO->borrowUuid"/>
        </div>

        <div class="dede">
            <x-return-dates-information
                :borrowStartDate="$returnBorrowEvent->returnCreatedEventDataDTO->borrowStartDate"
                :borrowEndDate="$returnBorrowEvent->returnCreatedEventDataDTO->borrowEndDate"
                :borrowReturnDate="$returnBorrowEvent->returnCreatedEventDataDTO->borrowReturnDate"/>
        </div>

        <div class="popo">
            @if($returnBorrowEvent->returnCreatedEventDataDTO->returnLately)
                <x-return-lately-notice
                    :endDate="Carbon::parse($returnBorrowEvent->returnCreatedEventDataDTO->borrowEndDate)"
                    :daysLate="$returnBorrowEvent->returnCreatedEventDataDTO->daysLate"
                    :fine="$returnBorrowEvent->returnCreatedEventDataDTO->lateFee"/>
            @else
                <x-return-on-time-notice/>
            @endif
        </div>

    </div>
</div>


<div class="chapters-count">
    <x-return-books-count :books="$books->count()"/>
</div>

<div class="chapters-list">
    <x-books-list :books="$books"/>
</div>

<div class="borrow-footer">
    <x-borrow-footer-return :isLate="$returnBorrowEvent->returnCreatedEventDataDTO->returnLately"/>
</div>
