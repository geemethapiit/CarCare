<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Stay organized with our user-friendly Calendar featuring events, reminders, and a customizable interface. Built with HTML, CSS, and JavaScript. Start scheduling today!" />
    <meta name="keywords" content="calendar, events, reminders, javascript, html, css, open source coding" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/appointment_style.css" />
    <title>Calendar with Events</title>
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
                <!-- Calendar days will be dynamically generated here -->
            </div>
            <div class="goto-today">
                <form method="GET" action="{{ route('appointments.by_date') }}">
                    <input type="date" name="date" value="{{ $selectedDate }}" />
                    <button type="submit" class="goto-btn">Go</button>
                </form>
            </div>
        </div>
    </div>
    <div class="right">
        <div class="today-date">
            <div class="event-day">{{ \Carbon\Carbon::parse($selectedDate)->format('D') }}</div>
            <div class="event-date">{{ \Carbon\Carbon::parse($selectedDate)->format('dS F Y') }}</div>
        </div>
        <div class="events">
            @if (!empty($timeSlots))
                @foreach ($timeSlots as $timeSlot => $appointments)
                    <div class="event-time-slot">
                        <div class="time-slot-header">
                            <strong>{{ $timeSlot }}</strong>
                        </div>
                        <ul class="appointment-list">
                            @foreach ($appointments as $appointment)
                                <li>
                                    <strong>Vehicle:</strong> {{ $appointment->vehicle_number }}<br>
                                    <strong>Service:</strong> {{ $appointment->ServiceTypeId }}<br>
                                    <strong>Branch:</strong> {{ $appointment->BranchID }}<br>
                                    <strong>Status:</strong> {{ $appointment->status }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @else
                <p>No appointments found for the selected date.</p>
            @endif
        </div>
        <div class="add-event-wrapper">
            <div class="add-event-header">
                <div class="title">Add Event</div>
                <i class="fas fa-times close"></i>
            </div>
            <div class="add-event-body">
                <div class="add-event-input">
                    <input type="text" placeholder="Event Name" class="event-name" />
                </div>
                <div class="add-event-input">
                    <input type="text" placeholder="Event Time From" class="event-time-from" />
                </div>
                <div class="add-event-input">
                    <input type="text" placeholder="Event Time To" class="event-time-to" />
                </div>
            </div>
            <div class="add-event-footer">
                <button class="add-event-btn">Add Event</button>
            </div>
        </div>
    </div>
    <button class="add-event">
        <i class="fas fa-plus"></i>
    </button>
</div>

<script src="/js/appointment_js.js"></script>
</body>
</html>