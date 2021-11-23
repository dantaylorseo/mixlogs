<div wire:poll>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <input class="shadow border-b border-gray-200 sm:rounded-lg px-3 py-1 text-left text-xs font-medium text-gray-500 min-w-full outline-none focus:outline-none" wire:model="textSearch" class="form-control" type="text" placeholder="Search by text">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input class="shadow border-b border-gray-200 sm:rounded-lg px-3 py-1 text-left text-xs font-medium text-gray-500 min-w-full outline-none focus:outline-none" wire:model="sessionid" class="form-control" type="text" placeholder="Session ID">
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Timestamp
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Records
                                </th>
                                
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            @if($loop->iteration % 2 == 0)
                            <tr class="bg-white">
                                @else
                            <tr class="bg-gray-50">
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $log->sessionid }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($log->timestamp)->toDayDateTimeString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $log->logs_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a target="_blank" href="{{ url('/log', $log->sessionid) }}" class="text-indigo-600 hover:text-indigo-900">View Log</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        <div class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
