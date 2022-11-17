<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto relative">
                    @if(request()->routeIs('admin.user'))
                        <a href="{{ route('admin.user', ['user_id' => $user->parent->id ?? null]) }}">Back To Parent</a>
                    @endif
                    <x-table>
                        <x-slot name="header">
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Name</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Email</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Registered Date</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Number of Referred Users</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Total Points Earned</th>
                            <th class="border font-medium px-6 py-4 font-bold text-slate-500 bg-slate-100 text-left">Action</th>
                        </x-slot>
                        @foreach($children as $user)
                            <tr>
                                <x-table-column><a href="{{ route('admin.user', ['user_id' => $user->id]) }}">{{$user->name}}</a></x-table-column>
                                <x-table-column>{{ $user->email }}</x-table-column>
                                <x-table-column>{{ $user->created_at }}</x-table-column>
                                <x-table-column>{{ $user->flatChilds($user)->count() }}</x-table-column>
                                <x-table-column>{{ $user->credit }}</x-table-column>
                                <x-table-column>
                                    <a href="{{ route('administration.edit', ['administration' => $user->id]) }}" class="inline-block py-1 px-2 leading-none text-center whitespace-nowrap align-baseline font-bold bg-yellow-600 text-white rounded-md">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </x-table-column>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
