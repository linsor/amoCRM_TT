@extends('layouts.main')

@section('content')
    
    <div class=" container">
        <div> 
            <div>
                <form action="{{route('lead.store')}}" method="post" enctype="multipart">
                  @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Название сделки</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="продажа нижнего белья">
                      </div>
                      <div class="mb-3">
                        <label for="price" class="form-label">Бюджет сделки</label>
                        <input type="text" class="form-control" name="price" id="price" placeholder="20000">
                      </div>
                      <div class="mb-3">
                        <label for="costPrice" class="form-label">Себестоимость</label>
                        <input type="text" class="form-control"  name="costPrice" id="costPrice" placeholder="3000">
                      </div>    

                      <button type="submit" class="btn btn-primary mb-3">Занести сделку</button>
                </form>
            </div>
            <div>
              <div> <a href="{{ route('lead.index') }}" class="btn btn-primary mb-3">Назад</a>
              </div>
          </div>
        </div>
    </div>

@endsection