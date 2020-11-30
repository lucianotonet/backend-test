@csrf

@include('backstage.partials.forms.text', [
    'field' => 'name',
    'label' => 'Name',
    'value' => old('name') ?? $campaign->name,
])

@include('backstage.partials.forms.select', [
    'field' => 'timezone',
    'label' => 'Timezone',
    'value' => old('timezone') ?? $campaign->timezone,
    'options' => $campaign->getAvailableTimezones(),
])

{{-- @include('backstage.partials.forms.number', [
    'field' => 'tokens',
    'label' => 'Number of start tokens',
    'value' => old('tokens') ?? $campaign->tokens,
]) --}}

@include('backstage.partials.forms.number', [
    'field' => 'totalspins',
    'label' => 'Number of spins per game',
    'value' => old('totalspins') ?? $campaign->totalspins,
])

@include('backstage.partials.forms.select', [
    'field' => 'spin_schedule',
    'label' => 'Spins Schedule',
    'value' => old('spin_schedule') ?? $campaign->spin_schedule,
    'options' => ['1' => 'Daily', '2' => 'Weekly'],
])


@include('backstage.partials.forms.starts-ends', [
    'starts_at' => old('starts_at') ?? ($campaign->starts_at === null ? $campaign->starts_at : $campaign->starts_at->format('d-m-Y H:i:s')),
    'ends_at' => old('ends_at') ?? ($campaign->ends_at === null ? $campaign->ends_at : $campaign->ends_at->format('d-m-Y H:i:s')),
])

@include('backstage.partials.forms.toggle', [
    'field' => 'targeting',
    'label' => 'Targeting',
    'value' => old('targeting') ?? $campaign->targeting,
])

@include('backstage.partials.forms.toggle', [
    'field' => 'segmentation',
    'label' => 'Segmentation',
    'value' => old('segmentation') ?? $campaign->segmentation,
])

@include('backstage.partials.forms.number', [
    'field' => 'games_allowed',
    'label' => 'Player can play',
    'value' => old('games_allowed') ?? $campaign->games_allowed,
])

@include('backstage.partials.forms.select', [
    'field' => 'games_frequency',
    'label' => 'per',
    'value' => old('games_frequency') ?? $campaign->games_frequency,
    'options' => ['day' => 'Day', 'campaign' => 'Campaign'],
])

@include('backstage.partials.forms.points', [
   'pointsband' => $campaign::$pointsband
])

@include('backstage.partials.forms.submit')
