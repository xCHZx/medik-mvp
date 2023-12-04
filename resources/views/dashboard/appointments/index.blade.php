@extends('adminlte::page')

@section('title', 'Calendario de Citas')

@section('content_header')

    <h1>Calendario de Citas</h1>

@stop

@section('content')

<button type="button" class="btn mdkbtn-success" data-toggle="modal" data-target="#newApointmentModal">
    Nueva cita
</button>

<div>
    <p>

    </p>
</div>

    <div id='calendar'></div>



    <!-- Modal -->
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
                <form class="px-3 py-2" method="POST" action="{{route('appointments.store')}}">
                    @csrf
                    <div class="row mb-2">
                        <div class="form-group col-md-12">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control"  name="date" id="date" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="time" class="form-label">Hora</label>
                            <input type="time" class="form-control"  name="time" id="time" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="patient" class="form-label">Paciente</label>
                            <input type="text" class="form-control"  name="patient" id="patient" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">Descripción o comentarios</label>
                            <textarea class="form-control mdkTextArea" name="description" id="description" rows="4"></textarea>
                        </div>
                        <input id="hidden" type="hidden" name="id" value="">
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

<!-- Show Appointment Modal -->
<div class="modal fade" id="showApointmentModal" tabindex="-1" role="dialog" aria-labelledby="showApointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showApointmentModalLabel">Cita</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div>

            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn mdkbtn-primary edit" data-dismiss="modal">Editar</button>
          <button type="button" class="btn mdkbtn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>





@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <script>

        //open te showAppointmentModal and clear all the data
        $('#newApointmentModal').on('hidden.bs.modal', function (e) {
            $('#newApointmentModal .modal-title').html('Nueva cita');
            $('#newApointmentModal #date').val('');
            $('#newApointmentModal #time').val('');
            $('#newApointmentModal #patient').val('');
            $('#newApointmentModal #description').val('');
            $('#newApointmentModal #hidden').val('');

            $('#newApointmentModal form').attr('action', '{{route('appointments.store')}}');
        });

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
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

            eventTimeFormat: { // like '7pm'
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
            },

            eventClick: function(info) {
                //trigger modal
                $('#showApointmentModal').modal('show');
                //parse info of appointent into modal
                $('#showApointmentModal .modal-body').html(`
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-center"><strong>${info.event.title}</strong></h5>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Fecha: </strong>${info.event.start.toLocaleDateString()}</p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Hora: </strong>${info.event.start.toLocaleTimeString()}</p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Paciente: </strong>${info.event.title}</p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Descripción: </strong>${info.event.extendedProps.description}</p>
                        </div>
                    </div>
                `);

                //trigger edit modal and parse info
                $('.edit').click(function(){
                    let id = info.event.id;
                    let patient = info.event.title;
                    let date = info.event.start.toISOString().substring(0, 10);
                    let time = info.event.start.toLocaleTimeString().substring(0, 5);
                    let description = info.event.extendedProps.description;

                    //validate if the time last char is a colon and remove it then add a zero at the begining
                    if(time.substring(4, 5) == ':'){
                        time = time.substring(0, 4);
                        time = '0' + time;
                    }

                    $('#showApointmentModal').modal('hide');
                    $('#newApointmentModal').modal('show');
                    $('#newApointmentModal .modal-title').html('Editar cita');
                    $('#newApointmentModal #date').val(date);
                    $('#newApointmentModal #time').val(time);
                    $('#newApointmentModal #patient').val(patient);
                    $('#newApointmentModal #description').val(description);
                    $('#newApointmentModal #hidden').val(id);
                });

            }
          });
          calendar.render();
        });

      </script>


@stop
