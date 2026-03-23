@extends('layouts.app')
@section('title','Announcements')

@section('content')

<style>
    /* Background blur */
    .bg-blur {
        background: url('/images/bg.png') no-repeat center center fixed;
        background-size: cover;
        filter: blur(6px);
        position: fixed;
        top:0; left:0;
        width:100%; height:100%;
        z-index:-2;
    }
</style>

<div class="bg-blur"></div>

<div class="flex justify-center items-start min-h-screen px-4 pt-10">

    <div class="w-full max-w-3xl bg-white p-8 rounded-2xl shadow-2xl border border-gray-200 relative z-10">

        {{-- PAGE TITLE --}}
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center opacity-90">
            📢 Manage Announcements
        </h2>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 opacity-90">
                {{ session('success') }}
            </div>
        @endif

        {{-- CREATE FORM --}}
        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-4 mb-10">
            @csrf
            <div>
                <label class="block font-semibold mb-1 opacity-80">Title</label>
                <input name="title" required
                       class="border border-gray-300 w-full p-3 rounded-lg opacity-90 focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g., System Maintenance Notice">
            </div>

            <div>
                <label class="block font-semibold mb-1 opacity-80">Content</label>
                <textarea name="body" rows="3" required
                          class="border border-gray-300 w-full p-3 rounded-lg opacity-90 focus:ring-2 focus:ring-blue-500"
                          placeholder="Write your announcement..."></textarea>
            </div>

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg shadow font-semibold">
                ➕ Post Announcement
            </button>
        </form>

        {{-- LIST OF ANNOUNCEMENTS --}}
        <h3 class="text-xl font-semibold text-gray-700 mb-4 opacity-80">Recent Announcements</h3>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Content</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($announcements as $a)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 font-semibold text-gray-800">{{ $a->title }}</td>
                        <td class="p-3 text-gray-700">{{ $a->body }}</td>
                        <td class="p-3 text-center">

                            {{-- EDIT BUTTON --}}
                            <button onclick="openEditModal({{ $a->id }}, '{{ $a->title }}', '{{ $a->body }}')"
                                    class="text-blue-600 hover:underline font-semibold mr-3">
                                ✏️ Edit
                            </button>

                            

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>


{{-- EDIT MODAL --}}
<div id="editModal"
     class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">

    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl">
        <h3 class="text-xl font-bold mb-4 text-gray-800">✏️ Edit Announcement</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <label class="block font-semibold mb-1">Title</label>
            <input id="editTitle" name="title" class="border w-full p-2 rounded mb-3" required>

            <label class="block font-semibold mb-1">Content</label>
            <textarea id="editBody" name="body" rows="3"
                      class="border w-full p-2 rounded mb-3" required></textarea>

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 rounded">
                    Cancel
                </button>

                <button class="px-4 py-2 bg-blue-600 text-white rounded">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

</div>


{{-- MODAL SCRIPT --}}
<script>
function openEditModal(id, title, body) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editTitle').value = title;
    document.getElementById('editBody').value = body;

    document.getElementById('editForm').action =
        "/admin/announcements/update/" + id;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>

@endsection
