@extends('layouts.main')

@section('content')

    <div class=" container">
        <div>
        <div>
            <div>
                <p class=" mb-0">ID сделки: {{$lead['id']}}</p>
                <p>Имя Сделки: {{$lead['name']}}</p>
                <p class=" mb-0">Бюджет: {{$lead['price']}}</p>
                <p class=" mb-0">
                    @foreach ($lead['custom_fields_values'] as $customField)
                    @if ($customField['field_name'] === 'Себестоимость')
                        @foreach ($customField['values'] as $value)
                        Себестоимость: {{ $value['value'] }}
                        @endforeach
                    @endif
                @endforeach
                </p>

                <p class=" mb-0">
                    @foreach ($lead['custom_fields_values'] as $customField)
                        @if ($customField['field_name'] === 'Прибыль')
                            @foreach ($customField['values'] as $value)
                                Прибыль: {{ $value['value'] }}
                            @endforeach
                        @endif
                    @endforeach
                </p>

            </div>
            <div>
                <a href="{{route('lead.index')}}" class="btn btn-primary">Назад</a>
            </div>
        </div>  
        
    </div>
@endsection