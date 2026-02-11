<x-app-layout>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Mi Boleta de Calificaciones</h2>
                        <div class="h4">
                            Promedio General:
                            <span class="badge {{ $average >= 6 ? 'bg-success' : 'bg-danger' }}">
                                {{ number_format($average, 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Materia</th>
                                        <th>Profesor</th>
                                        <th class="text-center">Calificación</th>
                                        <th class="text-center">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($grades as $grade)
                                        <tr>
                                            <td>{{ $grade->subject->name }}</td>
                                            <td>{{ $grade->teacher->user->name }}</td>
                                            <td class="text-center fw-bold">
                                                {{ number_format($grade->grade_value, 2) }}
                                            </td>
                                            <td class="text-center">
                                                @if ($grade->grade_value >= 6)
                                                    <span class="text-success"><i class="bi bi-check-circle-fill"></i>
                                                        Aprobado</span>
                                                @else
                                                    <span class="text-danger"><i class="bi bi-x-circle-fill"></i>
                                                        Reprobado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                No se han registrado calificaciones todavía.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
