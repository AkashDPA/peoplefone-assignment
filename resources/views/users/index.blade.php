<style>
    table.dataTable tbody tr.even {
        background-color: #e2e3e3; /* Tailwind gray-50 */
    }
</style>

<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-4">Users</h1>
        {!! $dataTable->table(['class' => 'w-full text-sm even:bg-gray-100', 'style' => 'width:100%']) !!}
    </div>

    @push('scripts')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        {!! $dataTable->scripts() !!}
    @endpush
</x-app-layout>
