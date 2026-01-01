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

        <div class="borrow-dates-information">
            <x-borrow-dates-information :borrowStartDate="$notificationData['borrow_start_date']"
                                        :borrowEndDate="$notificationData['borrow_end_date']"/>
        </div>

    </div>

</div>

<div class="chapters-count">
    <x-borrow-books-count :chaptersCount="$notificationData['chapters']"/>
</div>

<div class="chapters-list">
    <x-books-list :notificationData="$notificationData"/>
</div>

<div class="borrow-footer">
    <x-borrow-footer/>
</div>
