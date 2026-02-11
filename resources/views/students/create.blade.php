<x-app-layout>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-3">Registrar Estudiante</h2>
                    <x-alert />
                    <form action="{{ route('students.save') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $student->id ?? '' }}">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="boleta" class="form-label">Folio</label>
                                <input type="text" class="form-control" id="boleta" name="boleta" placeholder=""
                                    value="{{ old('boleta', $student->boleta ?? '') }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="name" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder=""
                                    value="{{ old('name', $student->user->name ?? '') }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder=""
                                    value="{{ old('phone', $student->phone ?? '') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder=""
                                    value="{{ old('email', $student->user->email ?? '') }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                        </div>





                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('students') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
</x-app-layout>
