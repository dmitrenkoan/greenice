@extends('main')

@section('city_sort')
    @if(!empty($nameSortItems))
        @foreach($nameSortItems as $name => $arLocation)
            <option value="{{$name}}" {{!empty($curCityName)&& $name == $curCityName ? "selected" : ""}}>{{$name}}</option>
        @endforeach
    @endif
@endsection

@section('cities_list')
    @if(!empty($setLocation) && $setLocation == "Y")
        <thead>
        <tr>
            <th>Area (Город)</th>
            <th>Distance, kms (Расстояние, км)</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($distanceSortItems))
            @foreach($distanceSortItems as $name => $arLocation)
                <tr>
                    <td>{{$name}}</td>
                    <td>{{$arLocation['distance']}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    @else
        <thead>
        <tr>
            <th>Area (Город)</th>
            <th>Latitude (Широта)</th>
            <th>Longitude (Долгота)</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($nameSortItems))
            @foreach($nameSortItems as $name => $arLocation)
                <tr>
                    <td>{{$name}}</td>
                    <td>{{$arLocation['lat']}}</td>
                    <td>{{$arLocation['long']}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    @endif
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-2 sidenav">


            </div>

            <div class="col-sm-8">

                <div class="col-2">
                    <form action="{{route('city_index')}}" method="GET">
                        <div class="form-group">

                            <label for="exampleFormControlSelect1"></label>
                            <select class="form-control" name="city_name" onchange="$(this).closest('form').submit();">
                                <option value="">Choose city</option>
                                @yield('city_sort')
                            </select>
                        </div>
                    </form>
                </div>
                <table class="table table-hover">
                    @yield('cities_list')
                </table>


            </div>
            <div class="col-sm-2">


            </div>
        </div>
    </div>



    @endsection