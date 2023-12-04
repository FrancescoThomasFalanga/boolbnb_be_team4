@extends('layouts.admin')
@section('content')

<main id="apartment_index">
    <div class="container">

        <table class="table table-striped my-5">
            <thead>
            <tr>
                <th scope="col">Immagine</th>
                <th scope="col" class="d-none d-md-table-cell">Lista</th>
                <th scope="col">Status</th>
                <th scope="col" class="d-none d-lg-table-cell">Stanze</th>
                <th scope="col" class="d-none d-lg-table-cell">Letti</th>
                <th scope="col" class="d-none d-lg-table-cell">Bagni</th>
                <th scope="col" class="d-none d-sm-table-cell">Indirizzo</th>
                <th scope="col">Dettagli</th>
            </tr>
            </thead>

            @php 
          
            @endphp
              <tbody>
                @if(count($apartments) > 0)
                  @foreach ($apartments as $apartment)
                  @if ($apartment->user_id == Auth::id())
                    <tr>
                      <td class="align-middle">
                        <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="Apartment Image" style="width: 80px; height: 50px;">
                        @if($apartment->sponsorships->count() > 0)
                          <i class="fa-solid fa-star text-warning px-2"></i>
                        @endif
                      </td>
                      <td class="align-middle d-none d-md-table-cell">{{strlen($apartment->name) > 25 ? substr($apartment->name, 0, 25) . '...' : $apartment->name}}</td>
                      <td class="align-middle">
                        <div class="d-flex align-items-center">
                          <div class="check {{$apartment->isVisible == 1 ? 'bg-success' : 'bg-danger'}}"></div>
                          <div class="px-2">{{$apartment->isVisible == 1 ? ' Listed' : ' Unlisted'}}</div>
                        </div>
                      </td>
                      <td class="align-middle d-none d-lg-table-cell">{{$apartment->rooms_number}}</td>
                      <td class="align-middle d-none d-lg-table-cell">{{$apartment->beds_number}}</td>
                      <td class="align-middle d-none d-lg-table-cell">{{$apartment->bathrooms_number}}</td>
                      <td class="align-middle d-none d-sm-table-cell">{{strlen($apartment->address) > 40 ? substr($apartment->address, 0, 40) . '...' : $apartment->address}}</td>
                      <td class="align-middle">
                        <div class="d-flex gap-3">
                          <a href="{{route ('admin.apartments.show' , $apartment->slug)}}"><i class="fa-solid fa-magnifying-glass"></i></a>
                          <a href="{{route ('admin.messages.single', $apartment->id)}}"><i class="fa-regular fa-envelope"></i></a>
                          <a href="{{route('admin.sponsorships.show', $apartment->slug)}}"><i class="fa-solid fa-chart-line"></i></a>
                        </div>
                      </td>
                    </tr>
                  @endif
                  @endforeach
                
                @else
                
                <tr>
                  <td colspan="8">
                    <div class="alert alert-light text-center" role="alert">
                      Non hai ancora registrato un appartamento.
                    </div>
                  </td>
                </tr>
              </tbody>
              @endif
            
        </table>

    </div>
</main>
@endsection