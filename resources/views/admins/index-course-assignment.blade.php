<x-app-layout>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert />
                    <form action="{{ route('course-assignments.save') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-3">
                                <select class="form-select" aria-label="Docente" name="teacher_id" required>
                                    <option value="" selected>Docente</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-select" aria-label="Materia" name="subject_id" required>
                                    <option value="" selected>Materia</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-select" aria-label="Grupo" name="group_id" required>
                                    <option value="" selected>Grupo</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>

                    </form>

                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre del Docente</th>
                                <th>Materia</th>
                                <th>Grupo</th>
                                {{-- <th>Acción</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courseAssignments as $courseAssignment)
                                <tr>
                                    <td>{{ $courseAssignment->teacher->user->name }}</td>
                                    <td>{{ $courseAssignment->subject->name }}</td>
                                    <td>{{ $courseAssignment->group->name }}</td>
                                    {{-- <td>
                                        <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
