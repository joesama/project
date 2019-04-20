<div class="panel panel-{{$background}} panel-colorful text-left">
    <div class="pad-all">
        <p class="text-lg text-semibold">
          <i class="psi-coins icon-fw"></i> 
          {{ $title }}
        </p>
        <p class="mar-no text-semibold">
          {{ Carbon\Carbon::now()->localeMonth }} - {{ Carbon\Carbon::now()->format('Y') }}
          <span class="pull-right text-semibold">
            RM {{ number_format($transData->get('monthTrans'),2) }}
          </span>
        </p>
{{--         @foreach(data_get($transData,'monthTransDets') as $clientName => $clientMonthTrans)
        <p class="mar-no text-sm">
          @php
            $client = (int)($clientMonthTrans->get('detail')->first()->client_id == $project->client_id);
          @endphp
          <span class="text-bold">
            {{ __('joesama/project::manager.financial.receiver.' . $chartId . '.' . $client) }}
          </span>
          {{ $clientName }}
          <span class="pull-right text-semibold">
            {{ number_format($clientMonthTrans->get('amount'),2) }}
          </span>
        </p>
        @endforeach --}}
        <p class="mar-no text-semibold">
          YTD - {{ Carbon\Carbon::now()->format('Y') }}
          <span class="pull-right text-semibold">
            RM {{ number_format($transData->get('ytd'),2) }}
          </span>
        </p>
{{--         @foreach(data_get($transData,'yearDetails') as $clientName => $clientYearTrans)
        <p class="mar-no text-sm">
          @php
            $client = (int)($clientYearTrans->get('detail')->first()->client_id == $project->client_id);
          @endphp
          <span class="text-bold">
            {{ __('joesama/project::manager.financial.receiver.' . $chartId . '.' . $client) }}
          </span>
          {{ $clientName }}
          <span class="pull-right text-semibold">
            {{ number_format($clientYearTrans->get('amount'),2) }}
          </span>
        </p>
        @endforeach --}}
        <p class="mar-no text-semibold">
          TTD
          <span class="pull-right text-semibold">
            RM {{ number_format($transData->get('ttd'),2) }}
          </span>
        </p>
{{--         @foreach(data_get($transData,'tillDate') as $clientName => $tillDateTrans)
        <p class="mar-no text-sm">
          @php
            $client = (int)($tillDateTrans->get('detail')->first()->client_id == $project->client_id);
          @endphp
          <span class="text-bold">
            {{ __('joesama/project::manager.financial.receiver.' . $chartId . '.' . $client) }}
          </span>
          {{ $clientName }}
          <span class="pull-right text-semibold">
            {{ number_format($tillDateTrans->get('amount'),2) }}
          </span>
        </p>
        @endforeach --}}
    </div>
</div>