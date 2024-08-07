@php
    /**
     * @var \InvolveDigital\LaravelLivewireForms\Inputs\TextInput $field
     * @var \InvolveDigital\LaravelLivewireForms\Themes\UiKitTheme $theme
     */

    $id = $field->getId() ?: $form->getDefaultIdForInput();
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
                    title=""
                    tabindex="0"
            ></span>
        @endif
    </label>
@endif

@php
    $inputClass = $theme->inputs[$field->getThemeType()] ?? '';

    if ($errors->has($form->formatModelName($field))) {
       $inputClass .= ' ' . $theme->inputError;
    }
@endphp

<input
        type="{{ $field->getType() }}"
        @if($form->getIsLivewire())
            wire:{{ $field->getWireType() }}{{ $field->getWireMode() ? '.' . $field->getWireMode() : '' }}="{{ $field->getModel() }}"
        @else
            name="{{ $field->getModel() }}"
        @endif
        id="{{ $id }}"
        data-input-name="{{ $field->getModel() }}"
        x-init="toggleState[$el.id] = $el.value"
        @keyup="toggleState[$event.target.id] = $event.target.value"
        {{ $field->getHtmlAttributes()->merge(['class' => $inputClass]) }}
>

@error($form->formatModelName($field))
<span class="{{ $theme->inputErrorMessage }}">{{ $message }}</span>
{!! $theme->getInputError($message) !!}
@enderror
