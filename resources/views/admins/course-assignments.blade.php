<x-app-layout>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <h3>Registro de Calificaciones</h3>

                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="{{ route('students.group.subject', [$groupId, $subjectId]) }}"
                                    method="GET" class="d-flex gap-2">
                                    <input type="text" name="boleta" class="form-control"
                                        placeholder="Escriba la Boleta (Folio)" value="{{ $boleta }}">
                                    <button type="submit" class="btn btn-secondary">Buscar</button>
                                </form>
                            </div>
                        </div>

                        @if ($student && $enrollment)
                            <x-alert />

                            <div class="card border-success">
                                <div class="card-header bg-success text-white">Alumno Encontrado</div>
                                <div class="card-body">
                                    <h5>{{ $student->user->name }}</h5>
                                    <p>Boleta: {{ $student->boleta }}</p>

                                    <form action="{{ route('grade.save') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">
                                        <input type="hidden" name="subject_id" value="{{ $subjectId }}">
                                        <input type="hidden" name="teacher_id"
                                            value="{{ auth()->user()->teacher->id }}">

                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Calificación:</span>
                                            <input type="number" name="grade_value" class="form-control" step="0.1"
                                                min="0" max="10" value="{{ $grade->grade_value ?? '' }}"
                                                required>
                                            <button class="btn btn-success" type="submit">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif($boleta)
                            <div class="alert alert-danger">No se encontró el alumno o no pertenece a este grupo.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
