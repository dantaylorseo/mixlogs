<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($application->name . ' Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($logs as $log)
            {{-- @if ($log->logType != 'Transition' && $log->logType != 'Message' && $log->logType != 'Data-required' && $log->logType != 'Data-received')
                @continue
            @endif --}}

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                
                <div class="px-4 py-5 sm:px-6">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <span class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                        {{ $log->service }}
                      </span>
                      {{ $log->logType }}
                    </h3>
                  <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $log->timestamp->format('d/m/Y H:i:s.v') }}</p>
                  
                </div>
                @if( $log->logType == 'Transition' )
                    <x-transition :log="$log" :from="$log->events[0]->value->from" :to="$log->events[0]->value->to"></x-transition>
                @elseif( $log->logType == 'Message' )
                    <x-message :message="!empty( $log->events[0]->value->visual[0] ) ? $log->events[0]->value->visual[0]->text : '(Blank)'"></x-message>
                @elseif( $log->logType == 'Data-required' )
                    <x-data-required :event="$log->events[0]"></x-data-required>
                @elseif( $log->logType == 'Data-received' )
                    <x-data-received :event="$log->events[0]"></x-data-received>
                @elseif( $log->logType == 'DLGaaS-Execute-End' )
                    <x-finalizer :request="$log->request" :response="$log->response"></x-finalizer>
                @else 
                    <x-basic :logData="$log->data"></x-basic>
                @endif
              </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
