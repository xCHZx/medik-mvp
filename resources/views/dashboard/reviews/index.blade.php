@extends('adminlte::page')

@section('title', 'Reportes - Opiniones')

@section('content_header')
    <h1>Opiniones</h1>
@stop

@section('content')
    @if(!$error)
        <section id="search-bar" class="d-flex justify-start my-4">
            <form action="{{ route('reviews.index') }}" method="GET" onsubmit="updateDateInputs()" class="w-full">
                <label>
                    Flujo
                    <select id="flowObjective" name="flowObjective" class="form-control mt-1 w-72">
                        <option value="" disabled selected hidden><p class="text-gray-200 m-0 p-0">Selecciona un flujo</p></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </label>
                <label class="ml-md-2">
                    Desde
                    <input
                        onfocus="toggleIcon(this)"
                        onblur="toggleIcon(this)"
                        type="text"
                        name="startDate"
                        class="form-control mt-1 w-48"
                        value="{{ request()->has('startDate') ? request()->input('startDate') : '' }}"
                        placeholder="Fecha de inicio"
                    >
                    <i class="far fa-calendar-alt text-gray-400 calendar-icon" onclick="handleIconClick(this)"></i>
                </label>
                <label class="ml-md-2">
                    Hasta
                    <input
                        onfocus="toggleIcon(this)"
                        onblur="toggleIcon(this)"
                        type="text"
                        name="endDate"
                        class="form-control mt-1 w-48"
                        value="{{ request()->has('endDate') ? request()->input('endDate') : '' }}"
                        placeholder= "Fecha de fin"
                    >
                    <i class="far fa-calendar-alt text-gray-400 calendar-icon" onclick="handleIconClick(this)"></i>
                </label>
                <button class="mdkbtn-success py-1.5 w-24 ml-md-2" type="submit">Filtrar</button>
                <a href="{{ route('reports.index') }}" class="mdkbtn-danger py-1.5 d-inline-block text-center w-24 ml-md-2">Limpiar</a>
            </form>
        </section>

        <section id="review-table" class="card">
            <div class="card-body">
                <table class="table w-full border">
                    <thead class="thead-light">
                        <tr>
                            <th>Visitante</th>
                            <th>Telefono</th>
                            <th>Objetivo del Flujo</th>
                            <th>Fecha de Creación</th>
                            <th>Calificación</th>
                            <th>Mostrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{$review->visit->visitor->firstName}} {{$review->visit->visitor->lastName}}</td>
                                <td>{{$review->visit->visitor->phone}}</td>
                                <td>{{$review->flow->objective}}</td>
                                <td>{{ date('d/m/Y \a \l\a\s H:i', strtotime($review->created_at)) }}</td>
                                <td><input class="rating" max="5" style="--value:{{$review->rating}}; --starsize: 1.5rem" type="range" disabled></td>
                                <td><button type="button" class="print" data-toggle="modal" data-target="#modal{{$review->id}}"><i class="far fa-eye ml-4"></i></button></td>
                            </tr>

                            <!-- Modal changeStatus -->
                            <div class="modal fade" id="modal{{$review->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog modal-dialog-centered ">
                                    <div class="modal-content rounded-xl shadow-none">
                                        <div class="modal-header border-b-2 border-gray-500">
                                            <div class="flex flex-row w-full">
                                                <div class="basis-4/5">
                                                    <h5 class="modal-title font-medium text-lg text-emerald-950">{{$review->visit->visitor->firstName}} {{$review->visit->visitor->lastName}}</h5>
                                                    <input class="rating" max="5" style="--value:{{$review->rating}}; --starsize: 1rem" type="range" disabled>
                                                </div>
                                                <div class="basis-1/5 flex items-center">
                                                    <p class="font-medium text-lg text-emerald-950">{{ date('d/m/Y', strtotime($review->created_at)) }}</p>
                                                </div>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body mb-0">
                                            <div class="card p-0 mt-3 mb-0 shadow-none rounded-xl" style="border-color: #E0E0E0!important; border-width: 1px">
                                                <div class="card-header bg-gray-100 rounded-t-2xl font-medium text-">
                                                    Comentario
                                                </div>
                                                <div class="card-body">
                                                    {{$review->comment}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-none flex justify-center mt-0 pt-0">
                                            <button type="button" class="btn mdkbtn-danger" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-end mt-3">
                    <button class="mdkbtn-info py-0.5 px-1.5 rounded-sm" id="reverse-btn"><</button>
                    <button class="mdkbtn-primary py-0.5 px-1.5 rounded-sm ml-3" id="forward-btn">></button>
                </div>
            </div>
        </section>

        {{$reviews->links()}}
    @else
       <p>Aún no tienes opiniones registradas</p>
    @endif
@stop

@section('js')
    <script>
        function toggleIcon(input) {
            const icon = input.nextElementSibling;
            if (input.type === 'text') {
                input.type = 'date';
                icon.style.display = 'none';
            } else {
                input.type = 'text';
                icon.style.display = 'inline-block';
            }
        }

        document.querySelectorAll('.print').forEach(function(element) {
            element.addEventListener('click', function() {
                console.log({{$review->id}});
            });
        });
    </script>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

