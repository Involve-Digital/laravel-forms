@php
    /** @var \InvolveDigital\LaravelLivewireForms\Inputs\Select $field */

    $id = $field->getId() ?: $form->getDefaultIdForInput($field);
@endphp

@if($field->getShowLabel())
    @php
        $labelClass = $theme->labels[$field->getThemeType()]['label'] ?? '';

        if ($errors->has($form->formatModelName($field))) {
            $labelClass .= ' ' . $theme->labelError;
        }
    @endphp

    <label for="{{ $id }}" {{ $field->getLabelHtmlAttributes()->merge(['class' => $labelClass]) }}>
        <span class="{{ $theme->labels[$field->getThemeType()]['span'] ?? '' }}">@lang($field->getLabel())</span>

        @if($tooltip = $field->getTooltip())
            <span
                    class="{{ $field->getTooltipIcon() ? $theme->labelTooltipWithIcon : $theme->labelTooltip }}"
                    @if($tooltipIcon = $field->getTooltipIcon())
                        {!! $theme->getTooltipIcon($tooltipIcon) !!}
                    @endif
                    {!! $theme->getTooltip($tooltip) !!}
                    tabindex="0"
            >
        @endif
    </label>
@endif

@php
    $inputClass = $theme->inputs[$field->getThemeType()] ?? '';

    if ($errors->has($form->formatModelName($field))) {
       $inputClass .= ' ' . $theme->inputError;
    }
@endphp

<select
        @if($form->getIsLivewire())
            wire:{{ $field->getWireType() }}{{ $field->getWireMode() ? '.' . $field->getWireMode() : '' }}="{{ $field->getModel() }}"
        @else
            name="{{ $field->getModel() }}"
        @endif
        id="{{ $id }}"
        data-input-name="{{ $field->getModel() }}"
        x-init="toggleState[$el.id] = $el.value; $wire.{{ $field->getModel() }} = $el.value || null"
        @change="toggleState[$event.target.id] = $event.target.value"
        @if($field->getIsMultiOptions())multiple @endif
        {{ $field->getHtmlAttributes()->merge(['class' => $inputClass]) }}
>
    @if($prompt = $field->getPrompt())
        <option value="">@lang($prompt)</option>
    @endif

    @foreach($field->getOptions() as $optionValue => $title)
        <option value="{{ $optionValue }}" @if(!$field->getPrompt() && $loop->first)selected @endif>
            @if($field->getTranslateOptions())
                @lang($title)
            @else
                {{ $title }}
            @endif
        </option>
    @endforeach
</select>

@error($form->formatModelName($field))
<span class="{{ $theme->inputErrorMessage }}">{{ $message }}</span>
{!! $theme->getInputError($message) !!}
@enderror
