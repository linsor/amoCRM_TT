@extends('layouts.main')

@section('content')

    <div class=" container">
        <div>
            <a href="{{route('lead.create')}}" class="btn btn-primary">Создать сделку</a>
        </div>
        <div>
            <div>

                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя сделки</th>
                        <th scope="col">Бюджет</th>
                        <th scope="col">Прибыль</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            @foreach ($lead as $item)
                                <tr>
                                    <th>{{$item['id']}}</th>
                                    <td>{{$item['name']}}</td>
                                    <td>{{$item['price']}}</td>
                                    <td>
                                        @foreach ($item['custom_fields_values'] as $customField)
                                            @if ($customField['field_name'] === 'Прибыль')
                                                @foreach ($customField['values'] as $value)
                                                    {{ $value['value'] }}
                                                @endforeach
                                            @endif
                                        @endforeach    
                                    </td> 
                                    <td>
                                        <a href="{{route('lead.show', $item['id'])}}" class=" btn-primary">Шкибиди доб</a>
                                    </td>
                                    <td>
                                        <a href="{{route('lead.edit', $item['id'])}}" class=" btn-primary">ес ес</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>  
        
    </div>
@endsection