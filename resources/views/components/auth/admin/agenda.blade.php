<!-- Begin Page Content -->
<div class="container-fluid page-agenda">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h2 mb-2 text-gray-900 font-weight-bold">Mon agenda</h1>
    </div>

    <p class="mb-4">Tous mes rendez-vous, Google, Portfolio.</p>

    <div class="row">

        <div id="calendar" style="width: 100%;"></div>

        <script type="text/javascript">
            $(document).ready(function() {

                /*------------------------------------------
                --------------------------------------------
                Get Site URL
                --------------------------------------------
                --------------------------------------------*/
                var SITEURL = "{{ url('/') }}";

                /*------------------------------------------
                --------------------------------------------
                CSRF Token Setup
                --------------------------------------------
                --------------------------------------------*/
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                /*------------------------------------------
                --------------------------------------------
                FullCalender JS Code
                --------------------------------------------
                --------------------------------------------*/
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    themeSystem: 'bootstrap4',
                    locale: 'fr',
                    timeZone: 'Europe/Paris',
                    displayEventTime: false,
                    navLinks: true,
                    dayMaxEvents: true,
                    droppable: true,
                    editable: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    selectable: true,
                    eventTimeFormat: {
                        hour: 'numeric',
                        minute: '2-digit',
                        timeZoneName: 'short'
                    },
                    eventSources: [{
                            googleCalendarApiKey: '',
                            googleCalendarId: 'zineddinehamel@gmail.com',
                            className: 'fc-event-email',
                            color: 'yellow', // an option!
                            textColor: 'black' // an option!
                        },
                        {
                            timeZoneParam: 'Europe/Paris',
                            url: '/fullcalenderAjax',
                            method: 'POST',
                            extraParams: {
                                type: 'get',
                            },
                            success: function(data) {},
                            failure: function(error) {},
                            color: '#95cbf99c', // a non-ajax option
                            textColor: 'black', // a non-ajax option
                        }
                    ],
                    select: function(start, end, allDay) {

                        var title = prompt('Titre de l\'événement :');


                        if (title) {

                            var startDate = moment(start.startStr, 'YYYY.MM.DD HH:mm:ss').format(
                                'YYYY-MM-DD HH:mm:ss')
                            var endDate = moment(start.endStr, 'YYYY.MM.DD HH:mm:ss').format(
                                'YYYY-MM-DD HH:mm:ss')

                            console.log(startDate);

                            $.ajax({
                                url: SITEURL + "/fullcalenderAjax",
                                data: {
                                    title: title,
                                    start: startDate,
                                    end: endDate,
                                    type: 'add'
                                },
                                type: "POST",
                                success: function(data) {
                                    displayMessage("Événement créé avec succès");

                                    setTimeout(() => {
                                        // location.reload();
                                    }, 1200);

                                },
                                error: function(error) {}
                            });
                        }
                    },
                    eventDrop: function(data) {

                        var startDate = moment(data.event.start, 'YYYY.MM.DD').format('YYYY-MM-DD')
                        var endDate = moment(data.event.end, 'YYYY.MM.DD').format('YYYY-MM-DD')

                        $.ajax({
                            url: SITEURL + '/fullcalenderAjax',
                            data: {
                                title: data.event.title,
                                start: startDate,
                                end: endDate,
                                id: data.event.id,
                                type: 'update'
                            },
                            type: "POST",
                            success: function(response) {
                                displayMessage("Événement mis à jour avec succès");
                            }
                        });
                    },
                    eventClick: function(data) {

                        var deleteMsg = confirm("Voulez-vous vraiment supprimer ?");

                        if (deleteMsg) {

                            $.ajax({
                                type: "POST",
                                url: SITEURL + '/fullcalenderAjax',
                                data: {
                                    id: data.event.id,
                                    type: 'delete'
                                },
                                success: function(response) {

                                    var event = calendar.getEventById(data.event.id).remove();

                                    displayMessage("Événement supprimé avec succès");
                                }
                            });
                        }

                    }
                });
                calendar.render();
            });

            /*------------------------------------------
            --------------------------------------------
            Toastr Success Code
            --------------------------------------------
            --------------------------------------------*/
            function displayMessage(message) {
                toastr.success(message, 'Event');
            }
        </script>

    </div>

</div>
<!-- /.container-fluid -->
