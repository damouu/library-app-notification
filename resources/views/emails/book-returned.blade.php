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
        <x-borrow-title/>
    </div>

    <div class="notification-data">
        <div class="borrow-number-information">
            <x-borrow-number-information :borrowUUID="$notificationData['borrow_uuid']"/>
        </div>
        <div class="dede">
            <x-return-dates-information :borrowStartDate="$notificationData['borrow_start_date']"
                                        :borrowEndDate="$notificationData['borrow_end_date']"
                                        :borrowReturnDate="$notificationData['borrow_return_date']"/>
        </div>
        <div class="popo">
            @if($notificationData['return_lately'])
                <x-return-lately-notice :endDate="Carbon::parse($notificationData['borrow_end_date'])"
                                        :daysLate="$notificationData['days_late']"
                                        :fine="$notificationData['late_fee']"/>
            @else
                <x-return-on-time-notice/>
            @endif
        </div>
    </div>
</div>


<div class="chapters-count">
    <x-return-books-count :chaptersCount="$notificationData['chapters']"/>
</div>

<div class="chapters-list">
    <x-books-list :notificationData="$notificationData"/>
</div>

<div class="borrow-footer">
    <x-borrow-footer/>
</div>
