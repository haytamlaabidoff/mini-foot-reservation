<x-app-layout>

<div class="max-w-5xl mx-auto p-6">

    <div class="bg-white shadow-lg rounded-2xl p-6">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            ➕ Ajouter Staff
        </h1>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('staff.store') }}"
              enctype="multipart/form-data">

            @csrf

            {{-- USER INFO --}}
            <div class="mb-8">

                <h3 class="font-bold text-xl mb-4 text-indigo-700">
                    👤 Informations Utilisateur
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- NAME --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Nom
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Téléphone
                        </label>

                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                    </div>

                </div>

            </div>

            <hr class="my-8">

            {{-- STAFF INFO --}}
            <div>

                <h3 class="font-bold text-xl mb-4 text-green-700">
                    💼 Informations Staff
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- DEPARTMENT --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Département
                        </label>

                        <select name="department_id"
                                id="department"
                                class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                            <option value="">
                                -- Sélectionner Département --
                            </option>

                            @foreach($departments as $dept)

                                <option value="{{ $dept->id }}"
                                    {{ old('department_id') == $dept->id ? 'selected' : '' }}>

                                    {{ $dept->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- POST --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Poste
                        </label>

                        <select name="post_id"
                                id="post"
                                class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                            <option value="">
                                -- Sélectionner Poste --
                            </option>

                        </select>

                    </div>

                    {{-- STATUS --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Statut
                        </label>

                        <select name="status"
                                class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>

                        </select>

                    </div>

                    {{-- SALARY --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Salaire
                        </label>

                        <input type="number"
                               name="salary"
                               value="{{ old('salary') }}"
                               class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                    </div>

                    {{-- CIN --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            CIN
                        </label>

                        <input type="text"
                               name="cin"
                               value="{{ old('cin') }}"
                               class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                    </div>

                    {{-- ADDRESS --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Adresse
                        </label>

                        <input type="text"
                               name="address"
                               value="{{ old('address') }}"
                               class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-300">

                    </div>

                    {{-- IMAGE --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700">
                            Photo
                        </label>

                        <input type="file"
                               name="image"
                               class="w-full border rounded-xl p-3 bg-gray-50">

                    </div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="mt-8">

                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl shadow">

                    ✅ Ajouter Staff

                </button>

            </div>

        </form>

    </div>

</div>

{{-- AJAX POSTS --}}
<script>

document.getElementById('department').addEventListener('change', function () {

    let deptId = this.value;

    let postSelect = document.getElementById('post');

    // Loading
    postSelect.innerHTML =
        '<option>⏳ Chargement...</option>';

    // Empty
    if (!deptId) {

        postSelect.innerHTML =
            '<option value="">-- Sélectionner Poste --</option>';

        return;
    }

    fetch(`/departments/${deptId}/posts`)

        .then(response => response.json())

        .then(data => {

            postSelect.innerHTML =
                '<option value="">-- Sélectionner Poste --</option>';

            if (data.length === 0) {

                postSelect.innerHTML +=
                    '<option disabled>Aucun poste disponible</option>';

                return;
            }

            data.forEach(post => {

                postSelect.innerHTML += `
                    <option value="${post.id}">
                        ${post.name}
                    </option>
                `;

            });

        })

        .catch(error => {

            console.error(error);

            postSelect.innerHTML =
                '<option value="">Erreur chargement</option>';

        });

});

</script>

</x-app-layout>