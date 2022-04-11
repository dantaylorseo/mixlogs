<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
    <dl class="sm:divide-y sm:divide-gray-200">
      <div class="p-4 sm:py-5 flex sm:gap-4 sm:px-6">
        <dt class="flex-initial w-32 text-sm font-medium text-gray-500">Return Code</dt>
        <dd class="flex-1 mt-1 text-sm text-gray-900 sm:mt-0">
          {{ $event->value->returnCode ?? '' }}
          @if( isset( $event->value->returnCode ) )
            @if( $event->value->returnCode == 0 )
              <svg xmlns="http://www.w3.org/2000/svg" class="inline text-green-700 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            @else
              <svg xmlns="http://www.w3.org/2000/svg" class="inline text-red-700 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            @endif
          @endif
        </dd>
      </div>
      <div class="p-4 sm:py-5 flex sm:gap-4 sm:px-6">
        <dt class="flex-initial w-32 text-sm font-medium text-gray-500">Duration</dt>
        <dd class="flex-1 mt-1 text-sm text-gray-900 sm:mt-0">{{ $event->value->duration ?? '' }}</dd>
      </div>
      <div class="p-4 sm:py-5 flex sm:gap-4 sm:px-6">
        <dt class="flex-initial w-32 text-sm font-medium text-gray-500">Data</dt>
        <dd class="flex-1 mt-1 text-sm text-gray-900 sm:mt-0"><textarea rows="10" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ !empty( $event->value->data ) ? json_encode($event->value->data, JSON_PRETTY_PRINT) : '' }}</textarea></dd>
      </div>
    </dl>
</div>