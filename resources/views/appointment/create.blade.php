<x-visitor-layout>

    <div>
        <h1 class="text-center">Agenda del doctor {{$doctor->firstName}} {{$doctor->lastName}}</h1>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>

<!-- New Appointment Modal -->
<div class="modal fade" id="newApointmentModal" tabindex="-1" role="dialog" aria-labelledby="newApointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newApointmentModalLabel">Nueva cita</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div>
                <form class="px-3 py-2" method="POST" action="{{route('appointments.externalStore')}}">
                    @csrf
                    <div class="row mb-2">
                        <div class="form-group col-md-12">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control"  name="date" id="date" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="time" class="form-label">Hora</label>
                            <input type="time" class="form-control"  name="time" id="time" step="3600" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="patient" class="form-label">Nombre del Paciente</label>
                            <input type="text" class="form-control"  name="patient" id="patient" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control"  name="email" id="email" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control"  name="phone" id="phone" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">Descripción o comentarios</label>
                            <textarea class="form-control mdkTextArea" name="description" id="description" rows="4"></textarea>
                        </div>
                        <input id="hidden" type="hidden" name="hidden" value="">
                    </div>
                    <div class="mt-2 mb-0">
                        <button type="submit" class="mdkbtn-success py-1 px-3">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn mdkbtn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

</x-visitor-layout>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



@vite(['resources/css/app.css', 'resources/js/app.js'])



<script>
            document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridDay',
                // views: ['day', 'week'],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                slotMinTime: '07:00:00',
                slotMaxTime: '23:59:00',
                slotDuration: '01:00', // 1 hours
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: true,
                },
                selectable: true,
                contentHeight: 600,
                locale: 'es',
                eventTimeFormat: { // like '7pm'
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: true
                },
                events: [
                    @foreach($appointments as $appointment)
                    {
                        id: '{{$appointment->id}}',
                        title: '{{$appointment->patient}}',
                        start: '{{$appointment->date}}T{{$appointment->time}}',
                        description: '{{$appointment->description}}',

                    },
                    @endforeach
                ],
                dateClick: function(info) {
                    let date = info.dateStr.slice(0, 10)
                    let time = info.dateStr.slice(11, 16)
                    let doctorId = '{{$doctor->id}}'
                    console.log(doctorId)
                    $('#newApointmentModal').modal('show');
                    $('#newApointmentModal .modal-title').html('Nueva cita');
                    $('#newApointmentModal #date').val(date);
                    $('#newApointmentModal #time').val(time);
                    $('#newApointmentModal #patient').val('');
                    $('#newApointmentModal #email').val('');
                    $('#newApointmentModal #phone').val('');
                    $('#newApointmentModal #description').val('');
                    $('#newApointmentModal #hidden').val(doctorId);

                },
            });
            calendar.render();
        });
</script>

