<x-visitor-layout>
    <div class="mb-8 mx-3 text-center">
        <h2>¡Gracias por tu registro !</h2>
    </div>
    <div>
        <p>
            Tu cita se ha registrado con éxito y falta aprobación del médico.

        </p>
        <p>
            Los detalles de tu cita son:
        </p>
        <ul>
            <li>Fecha: {{ $appointment->date }}</li>
            <li>Hora: {{ $appointment->time }}</li>
            <li>Paciente: {{ $appointment->patient}}</li>
            <li>Descripción: {{ $appointment->description }}</li>
            <li>Médico: {{ $appointment->user->firstName }} {{$appointment->user->lastName}}</li>
    </div>
    </x-visitor-layout>
