<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Calendar view for selecting dates" />
    <link rel="stylesheet" href="/css/appointment_style.css" />
    <title>Calendar View</title>
    <style>
        .day {
            cursor: pointer;
        }
        .day:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left">
        <div class="calendar">
            <div class="month">
                <i class="fas fa-angle-left prev"></i>
                <div class="date">{{ \Carbon\Carbon::parse($selectedDate)->format('F Y') }}</div>
                <i class="fas fa-angle-right next"></i>
            </div>
            <div class="weekdays">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>
            <div class="days">
                @foreach ($days as $day)
                    <div class="day" data-date="{{ $day['date'] }}">{{ $day['day'] }}</div>
                @endforeach
            </div>
            <div class="goto-today">
                <button class="today-btn">Today</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/appointment_js.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.day').forEach(day => {
            day.addEventListener('click', function() {
                const selectedDate = this.getAttribute('data-date');
                window.location.href = `/appointments?date=${selectedDate}`;
            });
        });
    });
</script>
</body>
</html>
