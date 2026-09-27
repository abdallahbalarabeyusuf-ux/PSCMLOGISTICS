@extends('layouts.admin')

@section('title', 'Customers')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900">All Customers</h2>
    </div>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">Name</th>
                        <th class="py-2 pr-4">Email</th>
                        <th class="py-2 pr-4">Phone</th>
                        <th class="py-2 pr-4">Shipments</th>
                        <th class="py-2 pr-4">Joined</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="py-3 pr-4 font-semibold text-gray-900">{{ $customer->name }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $customer->email }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $customer->phone ?? '—' }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $customer->shipments_count }}</td>
                            <td class="py-3 pr-4 text-gray-500">{{ $customer->created_at->format('d M Y') }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.customers.impersonate', $customer) }}">
                                    @csrf
                                    <button type="submit" class="text-primary font-semibold hover:underline">View Dashboard</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-gray-400">No registered customers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $customers->links() }}</div>
    </div>

@endsection
