<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    Hi There!<br />
                    <span class="font-bold">Your Point:</span>
                    <span class="inline-block py-1 px-2 leading-none text-center whitespace-nowrap align-baseline font-bold bg-yellow-600 text-white rounded"> {{ auth()->user()->credit }}</span><br />
                    <span class="font-bold">Your Registration Views:</span><span> {{ auth()->user()->registration_views }}</span><br />

                    <span class="font-bold">Your Referral Link is:</span>
                    <span>{{ route('register', ['referral' => auth()->id()]) }}</span><br />
                </div>
            </div>
        </div>
    </div>

    <div class="pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let userByDays = @json($userByDays);
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(userByDays),
                datasets: [{
                    label: '# Of Referral Users',
                    data: userByDays,
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
