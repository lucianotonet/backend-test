@csrf

@include('backstage.partials.forms.text', [
    'field' => 'name',
    'label' => 'Name',
    'value' => old('name') ?? $symbol->name,
])

@include('backstage.partials.forms.file', [
    'field' => 'image',
    'label' => 'Image',
    'value' => old('image') ?? $symbol->image,
])

@include('backstage.partials.forms.number', [
    'field' => 'x3_points',
    'label' => '3x Points',
    'step' => 0.01,
    'value' => old('x3_points') ?? $symbol->x3_points,
])

@include('backstage.partials.forms.number', [
    'field' => 'x4_points',
    'label' => '4x Points',
    'step' => 0.01,
    'value' => old('x4_points') ?? $symbol->x4_points,
])

@include('backstage.partials.forms.number', [
    'field' => 'x5_points',
    'label' => '5x Points',
    'step' => 0.01,
    'value' => old('x5_points') ?? $symbol->x5_points,
])

@include('backstage.partials.forms.submit')
