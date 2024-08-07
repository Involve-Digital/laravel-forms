@php
    $id = $field->getId() ?: $form->getDefaultIdForInput($field);

    $inputClass = $theme->inputs[$field->getThemeType()] ?? '';

    if ($errors->has($form->formatModelName($field))) {
       $inputClass .= ' ' . $theme->inputError;
    }
@endphp

<input
        type="checkbox"
        @if($form->getIsLivewire())
            wire:{{ $field->getWireType() }}{{ $field->getWireMode() ? '.' . $field->getWireMode() : '' }}="{{ $field->getModel() }}"
        @else
            name="{{ $field->getModel() }}"
        @endif
        id="{{ $id }}"
        data-input-name="{{ $field->getModel() }}"
        x-init="toggleState[$el.id] = $el.checked"
        @change="toggleState[$event.target.id] = $event.target.checked"
        {{ $field->getHtmlAttributes()->merge(['class' => $inputClass]) }}
>

@if($field->getShowLabel())
    @php
        $labelClass = $theme->labels[$field->getThemeType()]['label'] ?? '';

        if ($errors->has($form->formatModelName($field))) {
            $labelClass .= ' ' . $theme->labelError;
        }
    @endphp

    <label
            for="{{ $id }}"
            {{ $field->getLabelHtmlAttributes()->merge(['class' => $labelClass]) }}
    >
        <span class="{{ $theme->labels[$field->getThemeType()]['span'] ?? '' }}">@lang($field->getLabel())</span>

        @if($tooltip = $field->getTooltip())
            <span
                    class="{{ $field->getTooltipIcon() ? $theme->labelTooltipWithIcon : $theme->labelTooltip }}"
                    @if($tooltipIcon = $field->getTooltipIcon())
                        {!! $theme->getTooltipIcon($tooltipIcon) !!}
                    @endif
                    {!! $theme->getTooltip($tooltip) !!}
                    title=""
                    tabindex="0"
            ></span>
        @endif
    </label>
@endif

@error($form->formatModelName($field))
<span class="{{ $theme->inputErrorMessage }}">{{ $message }}</span>
{!! $theme->getInputError($message) !!}
@enderror
