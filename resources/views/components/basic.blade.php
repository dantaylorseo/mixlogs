<div class="border-t border-gray-200 px-4 py-5 sm:p-0">
    <dl class="sm:divide-y sm:divide-gray-200">
      <div class="p-4 sm:py-5 flex sm:gap-4 sm:px-6">
        <dt class="flex-initial w-32 text-sm font-bold text-indigo-700">Data</dt>
        <dd class="flex-1 mt-1 text-sm text-gray-900 sm:mt-0"><textarea rows="10" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ !empty( $logData ) ? json_encode($logData, JSON_PRETTY_PRINT) : '' }}</textarea></dd>
      </div>
    </dl>
</div>