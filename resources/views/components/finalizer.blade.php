<div class="flow-root p-10">
    <ul role="list" class="-mb-8">
        @if( !empty( $request->payload->userInput->userText) )
        <li>
            <div class="relative pb-8">
              <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
              <div class="relative flex items-start space-x-3">
                <div>
                  <div class="relative px-1">
                    <div class="h-8 w-8 bg-gray-100 rounded-full ring-8 ring-white flex items-center justify-center">
                      <!-- Heroicon name: solid/tag -->
                      <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div class="min-w-0 flex-1">
                    <div>
                      <div class="text-sm">
                        <a href="#" class="font-medium text-gray-900">You</a>
                      </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-700 bg-blue-100 py-3 px-5 rounded-full inline-block">
                      <p>{{ !empty( $request->payload->userInput->userText) ? $request->payload->userInput->userText : '(blank)' }}</p>
                    </div>
                  </div>
              </div>
            </div>
          </li>
          @endif
          @if( !empty( $response->payload->messages) && !empty( $response->payload->qaAction) )
            <li>
                <div class="relative pb-8">
                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                <div class="relative flex items-start space-x-3">
                    <div>
                    <div class="relative px-1">
                        <div class="h-8 w-8 bg-gray-100 rounded-full ring-8 ring-white flex items-center justify-center">
                        <!-- Heroicon name: solid/tag -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                        </svg>
                        </div>
                    </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-gray-900">Agent</a>
                        </div>
                        </div>
                        @if( !empty( $response->payload->messages) )
                            @foreach( $response->payload->messages as $message )
                                @if( !empty( $message->visual[0]->text) )
                                    <div>
                                        <div class="mt-2 text-sm text-gray-700 bg-gray-100 py-3 px-5 rounded-full inline-block">
                                            {{ !empty( $message->visual[0]->text) ? $message->visual[0]->text : '(blank)' }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if( !empty( $response->payload->qaAction) && !empty( $response->payload->qaAction->message->visual ) )
                        <div>
                            <div class="mt-2 text-sm text-gray-700 bg-gray-100 py-3 px-5 rounded-full inline-block">
                                {{ !empty( $response->payload->qaAction->message->visual[0]->text ) ? $response->payload->qaAction->message->visual[0]->text : '(blank)' }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                </div>
            </li>
        @endif
    </ul>
  </div>