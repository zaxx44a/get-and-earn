<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Referral Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto relative">

                    <h3 class="mb-3">My Clients</h3>
                    @if (($user->id ?? null) !== auth()->id())
                        >> <a href="{{ route('my-clients', ['user_id' => $user->parent->id ?? null]) }}">Back To
                            Parent</a>
                    @endif
                    <x-table>
                        <x-slot name="header">
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Name</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Email</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Phone</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Registered Date</th>
                            {{-- <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Level</th> --}}
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Point</th>
                        </x-slot>
                        @foreach (($user->childs ?? []) as $child)
                            <tr>
                                <x-table-column><a
                                        href="{{ route('my-clients', ['user_id' => $child->id]) }}">{{ $child->name }}</a>
                                </x-table-column>
                                <x-table-column>{{ $child->email }}</x-table-column>
                                <x-table-column>{{ $child->phone }}</x-table-column>
                                <x-table-column>{{ $child->created_at }}</x-table-column>
                                <x-table-column>{{ $child->credit }}</x-table-column>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
