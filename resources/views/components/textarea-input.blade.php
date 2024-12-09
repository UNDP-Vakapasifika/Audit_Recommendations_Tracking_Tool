@props(['disabled' => false, 'rows' => 3, 'cols' => 5, 'value' => ''])

<textarea rows="{{$rows}}" cols="{{$cols}}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm']) !!}>
    {{$value}}
</textarea>
