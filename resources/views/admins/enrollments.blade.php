<x-app-layout>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert />
                    <form action="{{ route('entollment.save') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-3">
                                <label for="student_id" class="form-label">Estudiante</label>
                                <select class="form-select" aria-label="Estudiante" name="student_id" required>
                                    <option value="" selected></option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="group_id" class="form-label">Grupo</label>
                                <select class="form-select" aria-label="Grupo" name="group_id" required>
                                    <option value="" selected></option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 mt-5">
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>

                    </form>

                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Estudiante</th>
                                <th>Grupo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enrollments as $enrollment)
                                <tr>
                                    <td>{{ $enrollment->student->user->name }}</td>
                                    <td>{{ $enrollment->group->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
