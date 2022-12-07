@php
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
    $field['value'] = $field['value'] ?? $field['default'] ?? '';

    $field['options_root_id'] = $field['options_root_id'] ?? null;
    $field['options_sort_by'] = $field['options_sort_by'] ?? 'id';
    $field['options_parent_id'] = $field['options_parent_id'] ?? $field['name'] ?? '';
    $field['option_name'] = $field['option_name'] ?? 'name';
    $field['options'] = $field['options'] ?? [];
    $field['depth_max'] = $field['depth_max'] ?? 10;
    $field['depth_prefix'] = $field['depth_prefix'] ?? '.';

    $options = collect($field['options'])->filter(function ($item) use ($field) {
        return $item[$field['options_parent_id']] === $field['options_root_id'];
    })->sortBy($field['options_sort_by'])->all();
    $optionsByParentId = collect($field['options'])->groupBy($field['options_parent_id'])->map(function ($options) use($field) {
        return $options->sortBy($field['options_sort_by']);
    })->toArray();

    $render = function ($options, $render, $depth = 0) use ($optionsByParentId, $field) {
        if($depth > $field['depth_max']) {
            return;
        }
        $result = [];
        $prefix = str_repeat($field['depth_prefix'], $depth);
        foreach ($options as $option){
            $name = $depth === 0 ? "<b>{$option[$field['option_name']]}</b>" : "{$prefix} {$option[$field['option_name']]}";
            $selected = (int)$field['value'] === (int)$option['id'] ? 'selected' : '';
            $result[] = "<option {$selected} value='{$option['id']}'>{$name}</option>";

            $childOptions = $optionsByParentId[$option['id']] ?? [];
            if(is_array($childOptions) && count($childOptions) > 0){
                $result[] = $render($childOptions, $render, $depth + 1) ?? '';
            }
        }
        return implode('', $result);
    }
@endphp
    <!-- select tree view -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<select
    name="{{ $field['name'] }}"
    @include('crud::fields.inc.attributes')
>
    @if ($field['allows_null'])
        <option value="">-</option>
    @endif

    <?= $render($options, $render, 0); ?>
</select>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')
