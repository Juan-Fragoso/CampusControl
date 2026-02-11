<x-app-layout>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert />
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Materia</th>
                                <th>Grupo</th>
                                <th> Acccion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courseAssignments as $courseAssignment)
                                <tr>
                                    <td>{{ $courseAssignment->subject->name }}</td>
                                    <td>{{ $courseAssignment->group->name }}</td>
                                    <td>
                                        <a href="{{ route('students.group.subject', [$courseAssignment->group_id, $courseAssignment->subject_id]) }}"
                                            class="btn btn-primary">
                                            Ingresar Calificaciones
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
