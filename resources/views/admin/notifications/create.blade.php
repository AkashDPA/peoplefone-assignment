{{-- resources/views/admin/notifications/create.blade.php --}}
<x-app-layout>
    <div class="max-w-xl mx-auto p-6 space-y-4">
        <h1 class="text-xl font-semibold">Post notification</h1>


        @if ($errors->any())
            <div class="p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm mb-1">Type</label>
                <select name="type" class="w-full border rounded p-2">
                    @foreach ($types as $t)
                        <option value="{{ $t }}" @selected(old('type') == $t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm mb-1">Short text</label>
                <input name="short_text" maxlength="255" class="w-full border rounded p-2"
                    value="{{ old('short_text') }}" placeholder="Some small info!">
            </div>

            <div>
                <label class="block text-sm mb-1">Expires at</label>
                <input type="date" name="expires_at" class="w-full border rounded p-2"
                    value="{{ old('expires_at') }}">
            </div>

            <div x-data="{ dest: '{{ old('destination', 'all') }}' }">
                <label class="block text-sm mb-1">Destination</label>
                <select name="destination" class="w-full border rounded p-2" x-model="dest">
                    <option value="all">All users</option>
                    <option value="user">Specific user</option>
                </select>

                <div class="mt-3" x-show="dest=='user'">
                    <label class="block text-sm mb-1">Target user</label>
                    <select name="user_id" class="w-full border rounded p-2">
                        <option value="">Select…</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" @selected(old('user_id') == $u->id)>{{ $u->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="bg-black text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>

    {{-- If you don’t already have Alpine from Breeze, remove x-data/x-show and use plain JS --}}
</x-app-layout>
