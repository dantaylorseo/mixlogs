<nav aria-label="Progress">
  <ol role="list" class="m-4 border border-gray-300 rounded-md divide-y divide-gray-300 md:flex md:divide-y-0">


    <li class="relative md:flex-1 md:flex">
      <!-- Current Step -->
      <a href="#" class="px-6 py-4 flex items-center text-sm font-medium" aria-current="step">
        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full">
          <span class="text-indigo-600">From</span>
        </span>
        <span class="ml-4">
          <span class=" text-base font-bold">
            <strong>{{ $from->component }}</strong> &raquo; {{ $from->name }}<br>
          </span>
          <span class="text-sm font-medium">
            {{ ucwords( $from->type ) }} <br>
            @if( !empty( $log->session ) && !empty( $log->session->project_id ) ) 
              <a class="underline text-indigo-600" href="https://mix.nuance.{{ $log->application->tld }}/v3/dialog/{{ $log->session->project_id }}/design/nodes/{{ $from->uuid }}">{{ $from->uuid }}</a>
            @else
              {{ $from->uuid }}
            @endif
          </span>
        </span>
      </a>

      <!-- Arrow separator for lg screens and up -->
      <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
        <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
          <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
        </svg>
      </div>
    </li>

    <li class="relative md:flex-1 md:flex">
      <!-- Current Step -->
      <span class="px-6 py-4 flex items-center text-sm font-medium" aria-current="step">
        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full">
          <span class="text-indigo-600">To</span>
        </span>
        <span class="ml-4">
          <span class=" text-base font-bold">
            <strong>{{ $to->component }}</strong> &raquo; {{ $to->name }}<br>
          </span>
          <span class="text-sm font-medium">
            {{ ucwords( $to->type ) }} <br>
            @if( !empty( $log->session ) && !empty( $log->session->project_id ) ) 
              <a class="underline text-indigo-600" href="https://mix.nuance.{{ $log->application->tld }}/v3/dialog/{{ $log->session->project_id }}/design/nodes/{{ $to->uuid }}">{{ $to->uuid }}</a>
            @else
              {{ $to->uuid }}
            @endif
          </span>
        </span>
      </span>

      
    </li>
  </ol>
</nav>